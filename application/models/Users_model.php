<?php
class Users_model extends MY_Model
{

    protected $table = 'user';

    public function getDefaultValues()
    {
        return [
            'username'        => '',
            'password'    => '',
        ];
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
}

/* End of file Users_model.php */