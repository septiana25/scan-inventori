<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller']        = 'home';
$route['404_override']              = '';
$route['translate_uri_dashes']      = FALSE;

$route['masuk/(:num)']              = 'masuk/index/$1';
$route['detailmasuk/(:any)/(:num)'] = 'detailmasuk/index/$1/$2';
$route['rakmasuk/(:any)']           = 'rakmasuk/index/$1';

$route['managemasuk']               = 'managebarangmasuk/index';
$route['barangkerak/(:num)']        = 'barangkerak/index/$1';

$route['keluar']                    = 'keluar/index/';
$route['keluar/report']             = 'keluar/report';
$route['keluar/print/(:any)']       = 'keluar/print/$1';
$route['detailkeluar/(:any)']       = 'detailkeluar/index/$1';

$route['pickerso']                  = 'pickerso/index';
$route['pickerso/(:num)']           = 'pickerso/index/$1';
$route['pickerso/detail/(:any)']    = 'pickersodetail/index/$1';
$route['pickerso/detail/(:any)/(:num)'] = 'pickersodetail/index/$1/$2';
$route['pickerso/save']             = 'pickersodetail/save';

$route['checkerso']                 = 'checkerso/index';
$route['checkerso/detail/(:any)']   = 'checkerso/detail/$1';
$route['checkerso/detail/(:any)/(:num)'] = 'checkersodetail/index/$1/$2';
$route['checkerso/save']            = 'checkersodetail/save';

$route['returns']                   = 'returns/index';
$route['returns/detail/(:num)/(:any)'] = 'returns/detail/$1/$2';
$route['returns/save']              = 'returns/save';

$route['mutasi']                    = 'mutasi/index';
$route['mutasi/detail/(:num)'] = 'mutasi/detail/$1';
$route['mutasi/save']               = 'mutasi/save';

$route['checksaldo']                = 'checksaldo/index';
$route['saldorak']                  = 'saldorak/index';
$route['saldoitem']                 = 'saldoitem/index';
$route['approved']                  = 'approved/index';

$route['users']                     = 'users/index';
$route['users/lock/(:num)']         = 'users/lock/$1';
$route['users/resetdefault/(:num)'] = 'users/resetdefault/$1';
$route['users/changerole']          = 'users/changerole';

$route['profile']                   = 'profile/index';
$route['profile/reset/(:num)']      = 'profile/reset/$1';

/* $route['api/(:any)']	= 'api/index/$1'; */
