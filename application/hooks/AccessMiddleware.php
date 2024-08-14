<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @date : 2024-03-15
 * @description : Middleware untuk mengatur akses pengguna
 * @property CI_Controller $CI
 */
class AccessMiddleware
{
    protected $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function run()
    {
        $this->checkLogin();
        $this->checkAccess();
    }

    private function checkLogin()
    {
        $excluded_uris = ['login', 'register', 'forgot_password'];
        $current_uri = $this->CI->uri->segment(1);

        if (!in_array($current_uri, $excluded_uris) && !$this->CI->session->userdata('is_login')) {
            redirect('login');
        }
    }

    private function checkAccess()
    {
        $controller = $this->CI->router->fetch_class();
        $method = $this->CI->router->fetch_method();
        $role = $this->CI->session->userdata('role');

        $access_map = [
            'users' => [
                'allowed_roles' => ['superadmin', 'admin'],
                'methods' => ['index', 'create', 'edit', 'delete']
            ],
            // Tambahkan controller lain dan aturan aksesnya di sini
        ];

        if (isset($access_map[$controller])) {
            if (
                !in_array($role, $access_map[$controller]['allowed_roles']) ||
                !in_array($method, $access_map[$controller]['methods'])
            ) {
                $this->CI->session->set_flashdata('error', 'Anda tidak memiliki akses ke halaman ini');
                redirect('home');
            }
        }
    }
}
