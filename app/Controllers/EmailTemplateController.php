<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\TenantModel;
use App\Models\QuestionModel;
use App\Models\SurveyModel;
use App\Models\ExternalcontactsModel;
use App\Models\CreatecontactsModel;
use App\Models\AnswercreateModel;

class EmailTemplateController extends BaseController
{
    public function index()
    {
        $model = new ExternalcontactsModel(); 
        $externalList = $model->where('created_by', session()->get('id'))->find();    
        $model = new SurveyModel();  
        $getSurvey = $model->where('user_id', session()->get('id'))->find(); 
        return view('admin/emailtemplate',["getSurvey" => $getSurvey,"externalList" => $externalList]);
    }
    public function uploadFile(){
        $input = $this->validate([
            'formData' => 'uploaded[formData]|max_size[formData,2048]|ext_in[formData,csv]'
        ]);
        if (!$input) {
            $data['validation'] = $this->validator;
            echo json_encode(['failed'=> $data, 'csrf' => csrf_hash() ]);
        }else {
            if($file = $this->request->getFile('formData')) {
                if ($file->isValid() && ! $file->hasMoved()) {                    
                    $newName = $file->getRandomName();
                    $file->move('../public/csvfile', $newName);
                    $file = fopen("../public/csvfile/".$newName,"r");
                    $i = 0;
                    $numberOfFields = 5;
                    $csvArr = array();
                    while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                        $num = count($filedata);
                        if($i > 0 && $num == $numberOfFields){ 
                            $csvArr[$i]['name'] = $filedata[0];
                            $csvArr[$i]['firstname'] = $filedata[1];
                            $csvArr[$i]['lastname'] = $filedata[2];
                            $csvArr[$i]['contact'] = $filedata[3];
                            $csvArr[$i]['email'] = $filedata[4];
                        }
                        $i++;
                    }
                    fclose($file);
                    $count = 0;
                    $emaillist= array();
                    foreach($csvArr as $exportData){
                        $validateEmail = $this->getExternalContact($exportData["email"]);
                        if($validateEmail) {
                            $tenant  = [
                                "tenant_id" => session()->get('tenant_id'),
                                "tenant_name" =>  session()->get('tenant_name')
                            ];
                            $data = [
                                "name" => $exportData["name"],
                                "firstname" => $exportData["firstname"],
                                "lastname" => $exportData["lastname"],
                                "contact_details" => $exportData["contact"],
                                "email_id" => $exportData["email"],
                                "created_by" => session()->get('id')
                            ];
                            if($tenant['tenant_id'] == 1) {
                                $this->createContact($data); 
                            } else {
                                $this->tenantCreateContact($data, $tenant);
                            }                                             
                            array_push($emaillist, $exportData["email"]);
                        }
                    }
                    $return_email = implode("," , $emaillist);
                    echo json_encode(['success'=> "success", 'csrf' => csrf_hash(), "query" =>  $return_email]);                    
                }
            }
        }
    }
    public function getExternalContact($emailid){
        $model = new ExternalcontactsModel();
        $multiClause = array('email_id' => $emailid);
        $contactlist = $model->where($multiClause)->first();
        if($contactlist){
            return false;
        }
        return true;
    }
    public function createContact($exportData){

        $model = new ExternalcontactsModel();
        $multiClause = array('email_id' => $exportData['email_id']);
        $contactlist = $model->where($multiClause)->first();
        if(!$contactlist){
            $model = new ExternalcontactsModel();
            $result = $model->insertBatch([$exportData]);                 
        }
    }
    public function tenantCreateContact($exportData, $tenantdata) {
        $dbname = "nps_".$tenantdata['tenant_name'];        
        //new DB creation for Tenant details
        $db = db_connect();
        $db->query('USE '.$dbname);
        $new_db_select ="SELECT * FROM ".$dbname.".nps_external_contacts  WHERE `nps_external_contacts`.`email_id` = '". $exportData['email_id']."'";        
        $result = $db->query($new_db_select);
        if(count($result->getResult()) == 0) {
            $key = array_keys($exportData); 
            $values = array_values($exportData); 
            $new_db_insert_user ="INSERT INTO ".$dbname.".nps_external_contacts ( ". implode(',' , $key) .") VALUES('". implode("','" , $values) ."')";
            $db->query($new_db_insert_user);
        }
    }
    public function sendEmail(){
        $model = new ExternalcontactsModel(); 
        $externalList = $model->where('created_by', session()->get('id'))->find(); 
        $model = new SurveyModel();  
        $getSurvey = $model->where('user_id', session()->get('id'))->find(); 
        if ($this->request->getMethod() == 'post') {
            $userId = session()->get('id');
            $this->createMailTemplate($this->request->getPost(),$userId);
            session()->setFlashdata('response',"Email has been send and record properly");
            return view('admin/emailtemplate',["getSurvey" => $getSurvey,"externalList" => $externalList]);
        }
        return view('admin/emailtemplate',["getSurvey" => $getSurvey,"externalList" => $externalList]);
    }
    public function createMailTemplate($postData, $userId) 
    {
        $List = implode(', ', $postData["checkoutemail"]);
        $model = new CreatecontactsModel();  
        $data = [
            "subject" => $postData["subject"],
            "survey_id" => $postData["survey"],
            "email_list" => $List,
            "message" => $postData["editor"],
            "user_id" => $userId
        ];
        $result = $model->insertBatch([$data]);
    }
    public function getSurveyAnwser($email, $survey_id, $userid, $tenantid)
    {
        $getSurveyData = $this->getcollection($email, $survey_id, $userid, $tenantid);
        return view('validateanswer',["getSurveyData" => $getSurveyData]);
    }

    public function getcollection($email, $survey_id, $userid, $tenantid){
        $model = new ExternalcontactsModel(); 
        $multiClause = array('created_by' => $userid,'email_id' => $email);
        $externalList = $model->where($multiClause)->first();    
        $model = new SurveyModel();  
        $multiClause2 = array('user_id' => $userid,'campign_id' => $survey_id);
        $getSurvey = $model->where($multiClause2)->first(); 
        $model = new QuestionModel();
        $multiClause3 = array('user_id' => $userid,'question_id' => $getSurvey['question_id_1']); 
        $multiClause4 = array('user_id' => $userid,'question_id' => $getSurvey['question_id_2']);  
        $getquestion1 = $model->where($multiClause3)->first(); 
        $getquestion2 = $model->where($multiClause4)->first(); 
        $questioncollection = array();
        array_push($questioncollection, $getquestion1, $getquestion2);
        $model = new UserModel();
        $multiClause5 = array('id' => $userid,'tenant_id' => $tenantid); 
        $user = $model->where($multiClause5)->first();
        $model = new TenantModel();
        $tenantDetails = $model->where('tenant_id',  $user['tenant_id'])->first();

        $getSurveyData  = [
            "email_id" => $externalList['email_id'],
            "contactId" => $externalList['id'],
            "contactname" => $externalList['name'],
            "campaignId" => $getSurvey['campign_id'],
            "campaignname" => $getSurvey['campain_name'],
            "questionlist" => $questioncollection,
            "userData"  => $user,
            "tenantData" => $tenantDetails
        ];
        return $getSurveyData;
    }
    public function createsurveyanswer(){
  
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'RESULT_TextField0' => 'required',
            ];
            $errors = [
                'RESULT_TextField0' => [
                    'required' => 'You must choose a first question.',
                ]
            ];
             $getSurveyData = $this->getcollection($this->request->getPost('emailid'),$this->request->getPost('surveyid'), $this->request->getPost('userid'),$this->request->getPost('tenantid'));
             if (!$this->validate($rules, $errors)) {
                return view('validateanswer', [
                    "validation" => $this->validator,
                    "getSurveyData" => $getSurveyData
                ]);
            } else {
                $answer = array();
                array_push($answer, $this->request->getPost("RESULT_TextField0"), $this->request->getPost("RESULT_TextField1"));

                    $data = [
                        "campign_id" => $this->request->getPost("surveyid"),
                        "email" => $this->request->getPost("emailid"),
                        "user_id" => $this->request->getPost("userid"),
                        "question_id" => $this->request->getPost("question")[0],
                        "answer_id" => $answer[0],
                        "question_id2" => $this->request->getPost("question")[1],
                        "answer_id2" => $answer[1],
                        "ip_details" => getHostByName(getHostName())
                    ];
                    $model = new AnswercreateModel();
                    $result = $model->insertBatch([$data]);

                session()->setFlashdata('response',"Your survey feedback has beed recorded.");
                return view('validateanswer', ["getSurveyData" => $getSurveyData]);
            }

        }

    }
}
