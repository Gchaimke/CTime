<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

# Home
$routes->get('/', 'Dashboard');
$routes->get('/register', 'Dashboard::register');

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
$routes->post('/projects/add_project', 'Projects::add_project');
$routes->post('/projects/edit_project', 'Projects::edit_project');
$routes->post('/projects/delete', 'Projects::delete');
$routes->post('/projects/delete_timer', 'Projects::delete_timer');
$routes->post('/projects/change_timer', 'Projects::change_timer');
$routes->post('/projects/update_total_payed', 'Projects::update_total_payed');

# Month
$routes->get('/month', 'Month');
$routes->post('/month/add_date', 'Month::add_date');
$routes->post('/month/action', 'Month::action');
$routes->match(['get', 'post'], '/month/edit_date', 'Month::edit_date');

# Admin
$routes->get('/admin', 'Admin', ['filter' => 'admin']);
