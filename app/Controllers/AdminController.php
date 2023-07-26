<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\AnswercreateModel;
use App\Models\ExternalcontactsModel;
use App\Models\SurveyResponseModel;
use App\Models\CreatecontactsModel;
use App\Models\TenantModel;

class AdminController extends BaseController
{
    public function __construct()
    {
        if (session()->get('role') != "admin") {
            echo 'Access denied';
            exit;
        }
    }
    public function index()
    {
        $tenantId = session()->get('tenant_id');
        $userId = array();
        $model = new TenantModel();  
        $getTenantdata = $model->findall(); 
        // Filter concept
        $selectTenant = '';
        if($this->request->getGet("tenantId") == '1' || $this->request->getGet("tenantId") == '' ) {
            $model = new UserModel();
            $userlist = $model->where('tenant_id', session()->get('tenant_id'))->findall();
        }else {
            $model = new UserModel();
            $userlist = $model->where('tenant_id', $this->request->getGet("tenantId"))->findall();
            $selectTenant = $this->request->getGet("tenantId");
        }
        $daterange = '';
        if($this->request->getGet("daterange") != '' ) {
            $daterange = explode("_" , $this->request->getGet("daterange"));
        }
        foreach($userlist as $userarray){
            array_push($userId, $userarray['id']);
        }
        $model = new AnswercreateModel();
        if(is_array($daterange)){
            $model->where("CAST(created_at AS DATE) BETWEEN '$daterange[0]' AND '$daterange[1]'");
        }
        $getSurveyData = $model->whereIn('user_id', $userId)->findall();  
        // $db = db_connect(); 
        // $query = $db->getLastQuery();
        // print_r($query);
        $detractorsArray1  = array();
        $passivesArray1   = array();
        $promotersArray1  = array();
        $detractorsArray2  = array();
        $passivesArray2   = array();
        $promotersArray2 = array();
        foreach($getSurveyData as $key => $getSurveylist) {
            if($getSurveylist['answer_id'] >= 8) {
                array_push($promotersArray1, $getSurveylist['answer_id']);
            }
            if($getSurveylist['answer_id2'] >= 8) {
                array_push($promotersArray2, $getSurveylist['answer_id2']);
            }
            if($getSurveylist['answer_id'] < 8 && $getSurveylist['answer_id'] >= 5) {
                array_push($passivesArray1, $getSurveylist['answer_id']);
            }
            if($getSurveylist['answer_id2'] < 8 && $getSurveylist['answer_id2'] >= 5) {
                array_push($passivesArray2, $getSurveylist['answer_id2']);
            }
            if($getSurveylist['answer_id'] < 5) {
                array_push($detractorsArray1, $getSurveylist['answer_id']);
            }
            if($getSurveylist['answer_id2'] < 5) {
                array_push($detractorsArray2, $getSurveylist['answer_id2']);
            }
        } 
        if($tenantId == 1){
            $model = new CreatecontactsModel();  
            $getresponseData = $model->whereIn('user_id', $userId)->findall();   
        } else {
            $model = new TenantModel();
            $tenant = $model->where('tenant_id', $tenantId)->first();
            $dbname = "nps_".$tenant['tenant_name'];     
            //new DB creation for Tenant details
            $db = db_connect();
            $db->query('USE '.$dbname);
            $userIdlist = implode(",",$userId);  
            $multiClause ="SELECT * FROM ".$dbname.".nps_email_send_list  WHERE `nps_email_send_list`.`user_id` IN ('".$userIdlist."')";
            $externalcount = $db->query($multiClause);
            if(count($externalcount->getResultArray()) >0) {
                $getresponseData = $externalcount->getResultArray();
            }
            $db->close();    
        }
        $promoters = array_merge($promotersArray1, $promotersArray2);
        $passives = array_merge($passivesArray1, $passivesArray2);
        $detractors = array_merge($detractorsArray1, $detractorsArray2);
        $completedData = array_merge($promoters, $passives, $detractors);
        // Response Rate
        if($tenantId == 1){
            if($this->request->getGet("tenantId") == '1' || $this->request->getGet("tenantId") == '' ) {
                $model = new ExternalcontactsModel();  
                if(is_array($daterange)){
                    $model->where("CAST(created_at AS DATE) BETWEEN '$daterange[0]' AND '$daterange[1]'");
                }
                $getcontactdata = $model->whereIn('created_by', $userId)->findall();   
                $model = new SurveyResponseModel();  
                if(is_array($daterange)){
                    $model->where("CAST(created_at AS DATE) BETWEEN '$daterange[0]' AND '$daterange[1]'");
                }
                $getsurveylist = $model->whereIn('user_id', $userId)->findall(); 
            } else {
                $model = new TenantModel();
                $tenant = $model->where('tenant_id', $this->request->getGet("tenantId"))->first();
                $gettotal = $this->getTotalResponse($tenant, $userId, $daterange);
                $getcontactdata = $gettotal['getcontactdata'];
                $getsurveylist = $gettotal['getsurveylist'];
            }
        } else {
            $model = new TenantModel();
            $tenant = $model->where('tenant_id', $tenantId)->first();
            $gettotal = $this->getTotalResponse($tenant, $userId, $daterange);
            $getcontactdata = $gettotal['getcontactdata'];
            $getsurveylist = $gettotal['getsurveylist'];
        }

        $totalresponse = (is_array($getcontactdata)) ? count($getcontactdata):'';
        $getsurveyresponse = (is_array($getsurveylist)) ? count($getsurveylist):'';
        $getfullResponse = array_count_values($completedData);
        $data = [
            "promoters" => $promoters, 
            "passives" => $passives, 
            "detractors" =>  $detractors,
            "getsurveyresponse" => $getsurveyresponse,
            "totalresponse" => $totalresponse,
            "getfullResponse" => $getfullResponse,
            "getTenantdata" => $getTenantdata,
            "selectTenant" => $selectTenant
        ];
        return view("admin/dashboard", ["getdashData" => $data]);
    }
    public function getTotalResponse($tenant, $userId, $daterange)
    {

        $dbname = "nps_".$tenant['tenant_name'];     
            //new DB creation for Tenant details
            $db = db_connect();
            $db->query('USE '.$dbname);
            $getcontactdata ='';
            $getsurveylist ='';
            $userIdlist = implode(",",$userId);  
            $multiClause1 ="SELECT * FROM ".$dbname.".nps_external_contacts  WHERE `nps_external_contacts`.`created_by` IN ('".$userIdlist."')";
            if(is_array($daterange)){
                $multiClause1 .=" AND CAST(created_at AS DATE) BETWEEN '$daterange[0]' AND '$daterange[1]'";
            }
            $externalcount = $db->query($multiClause1);
            if(count($externalcount->getResultArray()) >0) {
                $getcontactdata = $externalcount->getResultArray();
            }
            $multiClause2 ="SELECT * FROM ".$dbname.".nps_survey_response  WHERE `nps_survey_response`.`user_id` IN ('".$userIdlist."')";
            $externalcount = $db->query($multiClause2);
            if(count($externalcount->getResultArray()) >0) {
                $getsurveylist = $externalcount->getResultArray();
            }
            $db->close(); 
            $data = [
                "getcontactdata" => $getcontactdata,
                "getsurveylist" => $getsurveylist
            ];
            return $data;
    }
    public function ajaxrequest(){
        echo view('ajax-request');
    }

    public function updateRole(){
        $output="Ajax request Success.";
        if ($this->request->isAJAX()) {
            $query = service('request')->getPost();
            $userId = $query['id'];
            $data = [
                "role" => $query['query']
            ];
            $model = new UserModel();
            $model->update($userId,$data);
            var_dump($this->request->getPost('query'));
            echo json_encode(['success'=> $output, 'csrf' => csrf_hash(), 'query ' => $query ]);
        }
        // echo json_encode($output);
    }
}
