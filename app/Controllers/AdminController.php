<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

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

        $user = $model->where('email', session()->get('email'))
                    ->first();
        return view("admin/dashboard");
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
