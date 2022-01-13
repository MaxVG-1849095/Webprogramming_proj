<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Pages');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//$routes->get('news/(:segment)', 'News::view/$1');
//$routes->get('news', 'News::index');
//$routes->get('(:any)', 'Pages::view/$1');

$routes->get('/', 'Pages::homeredirect');
$routes->get('users/(:segment)', 'Pages::accountredirect/$1');
$routes->get('item/(:segment)', 'Pages::itemredirect/$1');
$routes->get('item/(:segment)/ajaxorder', 'OrderController::ajaxOrderCart');
$routes->get('profile', 'ProfileController::index');
$routes->get('profile/(:segment)', 'ProfileController::index/$1');
$routes->get('profileedit', 'ProfileController::edit');
$routes->get('messages', 'MessageController::loadMessages');
$routes->get('messages/(:segment)', 'MessageController::loadSpecificMessagesHelper/$1');
$routes->get('users', 'Pages::accountindex');
$routes->get('/login', 'LoginController::index');
$routes->get('/signup', 'LoginController::signupRedirect');
$routes->get('/itemorder', 'ItemController::orderItem');
$routes->get('/cart', 'OrderController::loadCartView');
$routes->get('/editwares', 'ItemController::editWares');
$routes->get('wareeditor/(:segment)', 'ItemController::wareEditor/$1');
$routes->get('/createitem', 'ItemController::createItemViewLoader');
$routes->get('/sellerorders', 'OrderController::loadOrdersSeller');
$routes->get('/shopperorders', 'OrderController::loadOrdersShopper');

$routes->match(['get', 'post'], 'Login/login', 'LoginController::login');
$routes->match(['get', 'post'], 'Login/signup', 'LoginController::signup');
$routes->get('/profile', 'ProfileController::index',['filter' => 'LoginFilter']);
$routes->get('/profile/edit', 'ProfileController::edit',['filter' => 'LoginFilter']);

//$routes->get('(:any)', 'Pages::view/$1');
//$routes->get('(:any)', 'BaseController::view/$1');

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}