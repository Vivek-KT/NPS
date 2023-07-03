<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\TenantModel;


class UserController extends BaseController
{
    
    public function login()
    {
        $data = [];

        if ($this->request->getMethod() == 'post') {

            $rules = [
                'tenantname' => 'required|min_length[2]|max_length[50]',
                'email' => 'required|min_length[6]|max_length[50]|valid_email',
                'password' => 'required|min_length[4]|max_length[255]|validateUser[email,password]',
            ];

            $errors = [
                'password' => [
                    'validateUser' => "Email or Password didn't match",
                ],
            ];

            if (!$this->validate($rules, $errors)) {

                return view('login', [
                    "validation" => $this->validator,
                ]);

            } else {
                $model = new UserModel();

                $user = $model->where('email', $this->request->getVar('email'))->first();
                $model = new TenantModel();
                $tenant = $model->where('tenant_name', $this->request->getVar('tenantname'))->first();

                // Stroing session values
                $this->setUserSession($user, $tenant);
                // Redirecting to dashboard after login
                if($user['role'] == "admin"){

                    return redirect()->to(base_url('admin'));

                }elseif($user['role'] == "user"){

                    return redirect()->to(base_url('user'));
                }
            }
        }
        return view('login');
    }

    private function setUserSession($user, $tenant)
    {
        $data = [
            'id' => $user['id'],
            'firstname' => $user['firstname'],
            'lastname' => $user['lastname'],
            'username' => $user['username'],
            'status' => $user['status'],
            'phone_no' => $user['phone_no'],
            'email' => $user['email'],
            'isLoggedIn' => true,
            "role" => $user['role'],
            "tenant_id" => $tenant['tenant_id'],
            "tenant_name" => $tenant['tenant_name'],
            "db_name" => $tenant['database_name'],
            "db_host" => $tenant['host'],
            "db_username" => $tenant['username'],
            "db_password" => $tenant['password']
        ];

        session()->set($data);
        return true;
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('login');
    }
    public function signup()
    {
        $data = [];

        if ($this->request->getMethod() == 'post') {
            $rules = [
                'firstname' => 'required|alpha',
                'lastname' => 'required|alpha',
                'username' => 'required|min_length[6]|max_length[50]',
                'tenantname' => 'required|min_length[2]|max_length[50]',
                'email' => 'required|min_length[6]|max_length[50]|valid_email',
                'phone_no' => 'required|numeric|exact_length[10]',
                'password' => 'required|min_length[4]|max_length[255]',
                'confirmpassword' => 'required|min_length[4]|max_length[255]|matches[password]',
            ];
            $errors = [
                'username' => [
                    'required' => 'You must choose a username.',
                ],
                'email' => [
                    'valid_email' => 'Please check the Email field. It does not appear to be valid.',
                ],
                
            ];
            if (!$this->validate($rules, $errors)) {
                return view('signup', [
                    "validation" => $this->validator,
                ]);
            } else {
                $model = new TenantModel();
                $tenant = $model->where('tenant_name', $this->request->getVar('tenantname'))->first();
                $userId = $this->insertUser($this->request->getPost(),$tenant);
                if($tenant['tenant_id'] > 1) {
                    $this->tenantInsertUser($this->request->getPost(),$tenant,$userId);
                }
                session()->setFlashdata('response',"New User Created");
                return redirect()->to(base_url('validatepage/'.$userId));

            }
        }
        return view('signup');
    }
    public function insertUser($postdata, $tenantdata) {
        $model = new UserModel();
        $data = [
            "firstname" => $postdata['firstname'],
            "lastname" => $postdata['lastname'],
            "username" => $postdata['username'],
            "tenant_id" => $tenantdata['tenant_id'],
            "email" =>  $postdata['email'],
            "phone_no" =>  $postdata['phone_no'],
            "role" => "user",
            "password" => password_hash($postdata['password'], PASSWORD_DEFAULT),
            "status" => "0"
        ];
        $result = $model->insertBatch([$data]);
        $db = db_connect();        
        $userId = $db->insertID();
        return $userId;
    }
    public function tenantInsertUser($postdata, $tenantdata, $userId){

        $dbname = "nps_".$tenantdata['tenant_name'];

        //new DB creation for Tenant details
        $db = db_connect();
        $db->query('USE '.$dbname);
        $data = [
            "id" => $userId,
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
        $key = array_keys($data); 
        $values = array_values($data); 
        $new_db_insert_user ="INSERT INTO ".$dbname.".nps_users ( ". implode(',' , $key) .") VALUES('". implode("','" , $values) ."')";
        $db->query($new_db_insert_user);
    }

    public function getprofile() {
        if(!session()->get('email')) {
            return redirect()->to(base_url('login'));
        } else {
            $model = new UserModel();
            $userdata = $model->where('email', session()->get('email'))->first();            
            return view('update_profile', ["userdata" => $userdata]);
        }
    }
    public function updateprofile(){
        $data = [];
        if ($this->request->getMethod() == 'post') {
            $this->updateuser($this->request->getPost());
            session()->setFlashdata('response',"Data updated Successfully");
            return redirect()->to(base_url('userprofile'));
        }
    } 
    public function updateuser($postdata) {
        $model = new UserModel();
        $model->upsertBatch([
            [
				"firstname" => $postdata['firstname'],
				"lastname" => $postdata['lastname'],
				"email" =>  $postdata['email'],
				"phone_no" =>  $postdata['phone_no']
			]
        ]);
    } 
    public function changepassword()
    {
        return view('changepassword');
    } 
    public function updatepassword()
    {
        $data = [];
        if ($this->request->getMethod() == 'post') {
            // $rules = [
            //     'password' => 'required|min_length[4]|max_length[255]|passwordchecker[password]',
            //     'confirmpassword' => 'required|min_length[4]|max_length[255]|matches[password]',
            // ];
            // $errors = [
            //     'password' => [
            //         'passwordchecker' => "Current password is not same as old password",
            //     ],
            // ];
            // if (!$this->validate($rules, $errors)) {
            //     return view('changepassword', [
            //         "validation" => $this->validator,
            //     ]);
            // } else {
                $data = [
                    "password" => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                ];
         
                $updateId = session()->get('id');
                $tenantId = session()->get('tenant_id');
                $model = new UserModel();
                $model->update($updateId,$data);
                if($tenantId > 1){
                    $this->tenantUserPasswordUpdate($data,$tenantId,$updateId);
                }
                session()->setFlashdata('response',"Password Updated Successfully");
                return redirect()->to(base_url('changepassword'));
            // }
            return view('changepassword');
        }
    }

    public function tenantUserPasswordUpdate($data, $tenantId, $updateId) {
        $dbname = "nps_".session()->get('tenant_name');
        //new DB updation for Tenant details
        $db = db_connect();
        $db->query('USE '.$dbname);
        $key = array_keys($data); 
        $values = array_values($data); 
        $new_db_update_user ="UPDATE  ".$dbname.".`nps_users` SET `password` = '".$data["password"]."' WHERE `nps_users`.`id` = ".$updateId;
        $db->query($new_db_update_user);
    }
    public function validatepage($id){
        return view('validatepage', ["userId" => $id]);
    }

    public function validateoption($id){
        $model = new UserModel();    
        $usersvalidate = $model->where('id', $id)->first();
        $updateId = $usersvalidate['id'];
        $data = [ "status" => 1 ];
        $statusupdate = $model->update($updateId,$data);
        session()->setFlashdata('response',"Your account is activated.");
        return redirect()->to(base_url('login'));   
    }

    public function forget()
    {
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'email' => 'required|min_length[6]|max_length[50]|valid_email'
            ];

            $errors = [
                'email' => [
                    'valid_email' => 'Please check the Email field. It does not appear to be valid.'
                ],
            ];
            if (!$this->validate($rules, $errors)) {
                return view('forgetpassword', [
                    "validation" => $this->validator,
                ]);
            } else {
                $model = new UserModel();
                $userData = $model->where('email', $this->request->getPost("email"))->first();
                if(!$userData) {
                    return view('forgetpassword', [
                        "valid" => 'Given Email is not available in Database.',
                    ]);
                }
                $updateId = $userData["id"];
                $newpassword = "123456";
                $tenantId = $userData["tenant_id"];
                $data = [
                    "password" => password_hash($newpassword, PASSWORD_DEFAULT),
                ];  
                $model = new UserModel();
                $model->update($updateId,$data);
                if($tenantId > 1){
                    $this->tenantUserForget($data,$tenantId,$updateId);
                }
                session()->setFlashdata('response',"Password Updated Successfully");
                return redirect()->to(base_url('forget'));
            }
        }
        return view("forgetpassword");
    }
    public function tenantUserForget($data, $tenantId, $updateId) {
        $model = new TenantModel();
        $tenant = $model->where('tenant_id', $tenantId)->first();
        $dbname = "nps_".$tenant['tenant_name'];
        //new DB updation for Tenant details
        $db = db_connect();
        $db->query('USE '.$dbname);
        $key = array_keys($data); 
        $values = array_values($data); 
        $new_db_update_user ="UPDATE  ".$dbname.".`nps_users` SET `password` = '".$data["password"]."' WHERE `nps_users`.`id` = ".$updateId;
        $db->query($new_db_update_user);
    }
}