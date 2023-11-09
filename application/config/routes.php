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
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['user']['get'] = 'user/index';
$route['user']['post'] = 'user/create';
$route['user/new']['get'] = 'user/new';
$route['user/(:any)/edit']['get'] = 'user/edit/$1';
$route['user/(:any)']['get'] = 'user/edit/$1';
$route['user/(:any)']['post'] = 'user/update/$1';
$route['user/(:any)/delete'] = 'user/delete/$1';

$route['gantipass']['get'] = 'user/gantipass';
$route['gantipass']['post'] = 'user/prosesGantipass';

$route['profile']['get'] = 'user/profile';
$route['profile/edit']['get'] = 'user/editProfile';
$route['profile']['post'] = 'user/prosesProfile';


// $route['sanggar/paket']['get'] = 'SanggarPaket/index';
$route['sanggar/paket/(:any)']['get'] = 'SanggarPaket/index/$1';
$route['sanggar/paket']['post'] = 'SanggarPaket/create';
// $route['sanggar/paket/new']['get'] = 'SanggarPaket/new';
$route['sanggar/paket/new/(:any)']['get'] = 'SanggarPaket/new/$1';
$route['sanggar/paket/(:any)/edit']['get'] = 'SanggarPaket/edit/$1';
$route['sanggar/paket/(:any)']['post'] = 'SanggarPaket/update/$1';
$route['sanggar/paket/(:any)/delete'] = 'SanggarPaket/delete/$1';

$route['sanggar/galleri/(:any)']['get'] = 'SanggarGalleri/index/$1';
$route['sanggar/galleri']['post'] = 'SanggarGalleri/create';
// $route['sanggar/galleri/new']['get'] = 'SanggarGalleri/new';
$route['sanggar/galleri/new/(:any)']['get'] = 'SanggarGalleri/new/$1';
$route['sanggar/galleri/(:any)/edit']['get'] = 'SanggarGalleri/edit/$1';
$route['sanggar/galleri/(:any)']['post'] = 'SanggarGalleri/update/$1';
$route['sanggar/galleri/(:any)/delete'] = 'SanggarGalleri/delete/$1';

$route['sanggar']['get'] = 'sanggar/index';
$route['sanggar']['post'] = 'sanggar/create';
$route['sanggar/new']['get'] = 'sanggar/new';
$route['sanggar/(:any)/edit']['get'] = 'sanggar/edit/$1';
$route['sanggar/(:any)']['get'] = 'sanggar/edit/$1';
$route['sanggar/(:any)']['post'] = 'sanggar/update/$1';
$route['sanggar/(:any)/delete'] = 'sanggar/delete/$1';
