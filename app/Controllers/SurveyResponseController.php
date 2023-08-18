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

class SurveyResponseController extends BaseController
{
    public function index()
    {
        $model = new TenantModel();  
        $userId = array();
        $getTenantdata = $model->findall(); 
        $selectTenant = '';
        if($this->request->getGet("tenantId") == '1' || $this->request->getGet("tenantId") == '' ) {
            $model = new UserModel();
            $userlist = $model->where('tenant_id', session()->get('tenant_id'))->findall();
        }else {
            $model = new UserModel();
            $userlist = $model->where('tenant_id', $this->request->getGet("tenantId"))->findall();
            $selectTenant = $this->request->getGet("tenantId");
        }
        foreach($userlist as $userarray){
            array_push($userId, $userarray['id']);
        }
        $model = new SurveyModel();  
        $getsurveyList = $model->whereIn('user_id', $userId)->find(); 
        $getsurveyfirst = $model->whereIn('user_id', $userId)->first(); 
        $camp_id = isset($getsurveyfirst) ? $getsurveyfirst['campign_id'] : '';
        if ($this->request->getMethod() == 'post') {
            $camp_id =  $this->request->getPost("surveyid");
        }
        $model = new AnswercreateModel();
        $multiClause = array('campign_id' => $camp_id);  
        $getSurveyData = $model->whereIn('user_id', $userId)->where($multiClause)->find(); 
        $getfullcollection = array();
        foreach($getSurveyData as $key => $getdata){
            $model = new QuestionModel();  
            $getquestionData = $model->where('question_id', $getdata['question_id'])->first(); 
            $getquestionData2 = $model->where('question_id', $getdata['question_id2'])->first(); 


            $model = new ExternalcontactsModel();  
            $getcontactData = $model->where('email_id', $getdata['email'])->first(); 
            $questionData = array();
            array_push($questionData, $getquestionData, $getquestionData2);
            $getSurveycollection = [
                "survey_id" => $getdata['id'],
                "campign_id"=> $getdata['campign_id'],
                "ip_details" => $getdata['ip_details'],
                "answer_id1" => $getdata['answer_id'],
                "answer_id2" => $getdata['answer_id2'],
                "created_at" => $getdata['created_at'],
                "questiondata" => $questionData,
                "userdata" => $getcontactData

            ];            
            array_push($getfullcollection, $getSurveycollection);

        }     
        return view('admin/surveyresponselist',['getSurveyData' =>  $getfullcollection, "getsurveylist" => $getsurveyList, "selectsurvey" => $getsurveyfirst, "getTenantdata" => $getTenantdata, "selectTenant" => $selectTenant]); 
    }
    public function getCustomerList(){
        $model = new ExternalcontactsModel();    
        $userslist = $model->where('created_by', session()->get('id'))->find();       
        return view('admin/getCustomerlist', ["userslist" => $userslist  ]);
    }
   
}
