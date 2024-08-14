<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Register_model extends MY_Model
{

    protected $table = 'user';

    public function getDefaultValues()
    {
        return [
            'name'      => '',
            'username'  => '',
            'password'  => '',
            'role'      => '',
            'is_active' => '',
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'name',
                'label' => 'Nama',
                'rules' => 'trim|required',
            ],
            [
                'field' => 'username',
                'label' => 'Usernama',
                'rules' => 'trim|required|is_unique[user.username]',
                'errors' => [
                    'is_unique' => 'This %s aleady exists',
                ]
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'required|min_length[6]',
            ],
            [
                'field' => 'password_confirmation',
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[password]',
            ]
        ];

        return $validationRules;
    }

    public function run($input)
    {
        $data = [
            'name' => $input->name,
            'username' => strtolower($input->username),
            'password' => hashEncrypt($input->password),
            'role' => 'member',
        ];

        $user = $this->create($data);
        if ($user) {
            return true;
        }

        return false;
    }
}
