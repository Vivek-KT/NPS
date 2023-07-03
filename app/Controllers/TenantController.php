<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\TenantModel;


class TenantController extends BaseController
{
    public function index()
    {
       
        return view('createTenant');

    }
    public function createtenant()
    {
        $data = [];

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'tenantname' => 'required|min_length[2]|max_length[50]|validateTenant[tenantname]',
                'firstname' => 'required|alpha',
                'lastname' => 'required|alpha',
                'username' => 'required|min_length[6]|max_length[50]',
                'tenantname' => 'required|min_length[2]|max_length[50]',
                'email' => 'required|min_length[6]|max_length[50]|valid_email',
                'phone_no' => 'required|numeric|exact_length[10]',
                'password' => 'required|min_length[4]|max_length[255]',
                'confirmpassword' => 'required|min_length[4]|max_length[255]|matches[password]'
            ];
            $errors = [ 
                'username' => [
                    'required' => 'You must choose a username.',
                ],
                'email' => [
                    'valid_email' => 'Please check the Email field. It does not appear to be valid.',
                ],               
                'tenantname' => [
                    'validateTenant' => "Tenant name is already exist",
                ],
            ];
            if (!$this->validate($rules, $errors)) {
                return view('createTenant', [
                    "validation" => $this->validator,
                ]);
            } else {
                $model = new TenantModel();
                $tenant = $model->where('tenant_name', $this->request->getPost('tenantname'))->first();
                if(!$tenant){
                    $this->insertTenant($this->request->getPost());
                }else {
                    $data = $this->formData($this->request->getPost(), $tenant);
                    $tenantId = $tenant['tenant_id'];
                    $userId = $this->CreateUser($data,$tenantId);
                    $this->createUserByTenant($tenantId, $userId, $data);
                }
                session()->setFlashdata('response',"Tenant Inserted Successfully");
                return redirect()->to(base_url('createtenant'));
            }
        }
        return view('createTenant');
    }
    public function insertTenant($postdata) 
    {
        $model = new TenantModel();
        $data = [
            "tenant_name" => $postdata['tenantname']
        ];
        $model->insertBatch([$data]);
        $db = db_connect();        
        $tenantId = $db->insertID();

        $data = [
            "firstname" => $postdata['firstname'],
            "lastname" => $postdata['lastname'],
            "username" => $postdata['username'],
            "tenant_id" => $tenantId,
            "email" =>  $postdata['email'],
            "phone_no" =>  $postdata['phone_no'],
            "role" => "admin",
            "password" => password_hash($postdata['password'], PASSWORD_DEFAULT),
            "status" => "1"
        ];

        $userId = $this->CreateUser($data,$tenantId);
        $this->createUserByTenant($tenantId, $userId, $data);
    }
    public function formData($postdata, $tenantdata){
        $data = [
            "firstname" => $postdata['firstname'],
            "lastname" => $postdata['lastname'],
            "username" => $postdata['username'],
            "tenant_id" => $tenantdata['tenant_id'],
            "email" =>  $postdata['email'],
            "phone_no" =>  $postdata['phone_no'],
            "role" => "admin",
            "password" => password_hash($postdata['password'], PASSWORD_DEFAULT),
            "status" => "1"
        ];
        return $data;
    }

    public function CreateUser($data, $tenantdata) {
        $model = new UserModel();        
        $result = $model->insertBatch([$data]);
        $db = db_connect();        
        $userId = $db->insertID();        
        return $userId;
    }

    public function createUserByTenant($tenantId, $userId, $data){
        $model = new TenantModel();
        $tenant = $model->where('tenant_id', $tenantId)->first();
        $dbname = "nps_".$tenant['tenant_name'];

        $this->createnewTenantDB($dbname);
        $db = db_connect();
        $data["id"] = $userId;
        $key = array_keys($data); 
        $values = array_values($data); 
        $new_db_insert_user ="INSERT INTO ".$dbname.".nps_users ( ". implode(',' , $key) .") VALUES('". implode("','" , $values) ."')";
        $db->query($new_db_insert_user);

    }

    public function createnewTenantDB($dbname)
    {
        //new DB creation for Tenant details
        $db = db_connect();
        $db->query('CREATE DATABASE '.$dbname);
        $db->query('USE '.$dbname);

        //new Table creation for Tenant Details
        $nps_answer_table = "CREATE TABLE `nps_answers_details` (
            `answer_id` int(11) NOT NULL  AUTO_INCREMENT PRIMARY KEY,
            `answer_name` text NOT NULL,
            `description` text NOT NULL,
            `question_id` int(11) NOT NULL,
            `info_details` varchar(120) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $db->query($nps_answer_table);

        $nps_campign_details = "CREATE TABLE `nps_campign_details` (`id` int(11) NOT NULL,
            `category_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_id` int(11) NOT NULL,
            `question_id` varchar(55) NOT NULL,
            `answer_id` varchar(55) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $db->query($nps_campign_details);

        $nps_external_contacts = "CREATE TABLE `nps_external_contacts` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `created_by` int(11) NOT NULL COMMENT 'User_id',
            `name` varchar(120) NOT NULL,
            `firstname` varchar(120) NOT NULL,
            `lastname` varchar(120) NOT NULL,
            `contact_details` text NOT NULL,
            `email_id` varchar(120) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $db->query($nps_external_contacts);

        $nps_login_user_info = "CREATE TABLE `nps_login_user_info` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_id` int(11) NOT NULL,
            `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
            `logout_time` timestamp NOT NULL DEFAULT current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $db->query($nps_login_user_info);

        $nps_question_details = "CREATE TABLE `nps_question_details` (
            `question_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `question_name` text NOT NULL,
            `description` text NOT NULL,
            `info_details` varchar(120) NOT NULL,
            `user_id` int(11) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $db->query($nps_question_details);


        $nps_survey_details = "CREATE TABLE `nps_survey_details` (
            `campign_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `user_id` int(11) NOT NULL,
            `campain_name` varchar(120) NOT NULL,
            `question_id_1` int(11) NOT NULL,
            `question_id_2` int(11) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $db->query($nps_survey_details);

        $nps_survey_response = "CREATE TABLE `nps_survey_response` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `campign_id` int(11) NOT NULL,
            `user_id` int(11) NOT NULL,
            `question_id` int(11) NOT NULL,
            `answer_id` int(11) NOT NULL,
            `ip_details` varchar(120) NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $db->query($nps_survey_response);

        $nps_users = "CREATE TABLE `nps_users` (
            `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `firstname` varchar(120) DEFAULT NULL,
            `lastname` varchar(55) NOT NULL,
            `username` varchar(120) DEFAULT NULL,
            `tenant_id` int(11) NOT NULL,
            `email` varchar(120) NOT NULL,
            `phone_no` varchar(120) NOT NULL,
            `role` enum('admin','user') NOT NULL,
            `password` varchar(240) NOT NULL,
            `status` enum('1','0') NOT NULL,
            `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        $db->query($nps_users);
    }

    public function getUserDetails()
    {
        $model = new UserModel();    
        $users = $model->where('tenant_id', session()->get('tenant_id'))->find();
        
        return view('userpermission', ["users" => $users]);
    }
}