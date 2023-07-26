<?php

namespace App\Validation;
use App\Models\UserModel;
use App\Models\TenantModel;
class Userrules
{
    public function validateUser(string $str, string $fields, array $data)
    {
        $model = new TenantModel();
        $tenant = $model->where('tenant_name', $data['tenantname'])->first();

        $model = new UserModel();
        $multiClause = array('email' => $data['email'],'tenant_id' => $tenant['tenant_id']);
        $user = $model->where($multiClause)->first();
        
        if (!$user) {
            return false;
        }

        return password_verify($data['password'], $user['password']);
    }
    public function validateTenant(string $str, string $fields, array $data)
    {
        $model = new TenantModel();
        $tenant = $model->where('tenant_name', $data['tenantname'])
        ->first();

        if (!$tenant) {
            return true;
        }
    return false;
    }
    public function passwordchecker(string $str, string $fields, array $data)
    {
        $model = new UserModel();
        $user = $model->where('id', session()->get('id'))
            ->first();

        if (!$user) {
            return false;
        }
        print_r(password_verify($data['password'], $user['password']));
        if(password_verify($data['password'], $user['password'])) {
            return false;
        }else {
            return true;
        }
    }
}
