<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\AnswercreateModel;
use App\Models\ExternalcontactsModel;
use App\Models\SurveyResponseModel;

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
        $model = new UserModel();
        $user = $model->where('email', session()->get('email'))->first();
        $model = new AnswercreateModel();  
        $getSurveyData = $model->where('user_id', session()->get('id'))->findall();   
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
        $promoters = array_merge($promotersArray1, $promotersArray2);
        $passives = array_merge($passivesArray1, $passivesArray2);
        $detractors = array_merge($detractorsArray1, $detractorsArray2);
        $completedData = array_merge($promoters, $passives, $detractors);
        // Response Rate
        $model = new ExternalcontactsModel();  
        $getcontactdata = $model->where('created_by', session()->get('id'))->findall(); 
        $totalresponse = count($getcontactdata);
        $model = new SurveyResponseModel();  
        $getsurveylist = $model->where('user_id', session()->get('id'))->findall(); 
        $getsurveyresponse = count($getsurveylist);
        $getfullResponse = array_count_values($completedData);
        $data = [
            "promoters" => $promoters, 
            "passives" => $passives, 
            "detractors" =>  $detractors,
            "getsurveyresponse" => $getsurveyresponse,
            "totalresponse" => $totalresponse,
            "getfullResponse" => $getfullResponse
        ];
        return view("admin/dashboard", ["getdashData" => $data]);
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
