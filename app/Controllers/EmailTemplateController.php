<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\TenantModel;
use App\Models\QuestionModel;
use App\Models\SurveyModel;
use App\Models\ExternalcontactsModel;

class EmailTemplateController extends BaseController
{
    public function index()
    {
        $model = new SurveyModel();  
        $getSurvey = $model->where('user_id', session()->get('id'))->find(); 
        return view('admin/emailtemplate',["getSurvey" => $getSurvey]);
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
                    $return_email = implode("," , $emaillist);
                    echo json_encode(['success'=> "success", 'csrf' => csrf_hash(), "query" =>  $return_email]);
                }
            }
        }
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
        $model = new SurveyModel();  
        $getSurvey = $model->where('user_id', session()->get('id'))->find(); 
        if ($this->request->getMethod() == 'post') {
            
        }
        return view('admin/emailtemplate',["getSurvey" => $getSurvey]);
    }
}
