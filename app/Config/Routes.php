<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

# Home
$routes->get('/', 'Home');
$routes->get('/register', 'Home::register');

# Login
$routes->get('/login', 'Login');
$routes->post('/login', 'Login::try_login');

# User
$routes->get('/user', 'User');
$routes->post('/register', 'User::register');
$routes->post('/user/delete', 'User::delete', ['filter' => 'admin']);
$routes->match(['get', 'post'], '/user/edit/(:any)', 'User::edit/$1');

# Projects
$routes->get('/projects', 'Projects');
$routes->post('/projects/action_project', 'Projects::action_project');

# Month
$routes->get('/month', 'Month');
$routes->post('/month/add_date', 'Month::add_date');
$routes->post('/month/action', 'Month::action');
$routes->match(['get', 'post'], '/month/edit_date', 'Month::edit_date');

# Admin
$routes->get('/admin', 'Admin', ['filter' => 'admin']);