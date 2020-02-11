<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	http://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller']			= 'home';
$route['authentication-failure']		= 'custom/authentication_failure';
$route['404_override']					= 'custom404';
$route['translate_uri_dashes']			= false;

### product ###
$route['products/(:any)']				= 'product/front_view/$1';

### general ###
$route['weekly-offer']					= 'general/weekly_offer';

### account ###
$route['logout']						= 'account/logout';

### checkout ###
$route['checkout/thank-you']			= 'checkout/thank_you';

### inquiry ###
$route['admin/inquiry/view/(:num)']		= 'admin/inquiry_view/$1';

### feedback ###
$route['admin/feedback/view/(:num)']	= 'admin/feedback_view/$1';

### service ###
$route['servicing']						= 'service';
$route['servicing/(:any)/(:any)']		= 'service/front_view/$1';

### news ###
$route['news/(:any)/(:any)']			= 'news/front_view/$1';

### blog ###
$route['blog/(:any)/(:any)']			= 'blog/front_view/$1';

### offer ###
$route['offer/(:any)/(:any)']			= 'offer/front_view/$1';
$route['coupon-offer']	= 'offer/coupon_offer';


### SSLCOMMERZ ###
$route['sslcommerz/request']			= 'SslcommerPaymentController/requestssl';
$route['sslcommerz/validate']			= 'SslcommerPaymentController/validateresponse';
$route['sslcommerz/failed']				= 'SslcommerPaymentController/fail';
$route['sslcommerz/cancled']			= 'SslcommerPaymentController/cancel';
$route['sslcommerz/ipnssl']				= 'SslcommerPaymentController/ipn';