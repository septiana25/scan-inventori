<?php
class Users_model extends MY_Model
{

    protected $table = 'user';

    public function getDefaultValues()
    {
        return [
            'password'    => '',
        ];
    }

    public function getValidationRules()
    {
        $validationRules = [
            [
                'field' => 'new_password',
                'label' => 'Password Baru',
                'rules' => 'required|min_length[6]',
            ],
            [
                'field' => 'confirm_password',
                'label' => 'Konfirmasi Password',
                'rules' => 'required|matches[new_password]',
            ]
        ];

        return $validationRules;
    }

    public function changeRole($input)
    {
        $data = [
            'role' => $input->role,
        ];

        $user = $this->where('id_user', $input->id_user)->update($data);
        if ($user) {
            return true;
        }

        return false;
    }

    public function resetPassword($input)
    {
        $data = [
            'password' => hashEncrypt($input->new_password),
        ];

        $user = $this->where('id_user', $input->id_user)->update($data);
        if ($user) {
            return true;
        }

        return false;
    }

    public function fetchAll()
    {
        return $this->select(
            [
                'id_user',
                'username',
                'name',
                'role',
                'is_active',
            ]
        )
            ->get();
    }

    public function getUserById($id_user)
    {
        return $this->select(
            [
                'id_user',
                'username',
                'name',
                'role',
                'is_active',
            ]
        )
            ->where('id_user', $id_user)
            ->first();
    }
}

/* End of file Users_model.php */