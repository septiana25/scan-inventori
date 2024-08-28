<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @date : 2024-03-15
 * @description : Middleware untuk mengatur akses pengguna
 * @property CI_Controller $CI
 * @property CI_URI $CI->uri
 * @property CI_Session $CI->session
 * @property CI_Router $CI->router
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
                'allowed_roles' => ['superadmin'],
                'methods' => ['index', 'resetdefault', 'changerole', 'lock']
            ],
            'pickerso' => [
                'allowed_roles' => ['superadmin', 'admin', 'pickers'],
                'methods' => ['index']
            ],
            'pickersodetail' => [
                'allowed_roles' => ['superadmin', 'admin', 'pickers'],
                'methods' => ['index', 'save', 'update']
            ],
            'checkerso' => [
                'allowed_roles' => ['superadmin', 'admin', 'checkers'],
                'methods' => ['index', 'detail']
            ],
            'checkersodetail' => [
                'allowed_roles' => ['superadmin', 'admin', 'checkers'],
                'methods' => ['index', 'save']
            ],
            'returns' => [
                'allowed_roles' => ['superadmin', 'admin', 'pickers'],
                'methods' => ['index']
            ],
            'approved' => [
                'allowed_roles' => ['superadmin'],
                'methods' => ['index', 'upproverak', 'cancelrak']
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
