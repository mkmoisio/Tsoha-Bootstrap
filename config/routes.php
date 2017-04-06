<?php

/*
 * TaskController
 */


$routes->get('/new_task', function() {
    TaskController::create();
});

$routes->post('/new_task', function() {
    TaskController::store();
});

$routes->get('/task/:id/edit', function($id) {
    TaskController::edit($id);
});

$routes->post('/task/:id/edit', function($id) {
    TaskController::update($id);
});

$routes->post('/task/:id/delete', function($id) {
    TaskController::delete($id);
});

$routes->get('/task/:id', function($id) {
    TaskController::task($id);
});


/**
 * ClassificationController
 */
$routes->get('/new_classification', function() {
    ClassificationController::create();
});

$routes->post('/new_classification', function() {
    ClassificationController::store();
});

$routes->get('/classification/:id', function($id) {
    ClassificationController::classification($id);
});

$routes->get('/classification/:id/edit', function($id) {
    ClassificationController::edit($id);
});

$routes->post('/classification/:id/edit', function($id) {
    ClassificationController::update($id);
});

$routes->post('/classification/:id/delete', function($id) {
    ClassificationController::delete($id);
});

/**
 * UserController
 * 
 */
$routes->get('/login', function() {
    UserController::login();
});

$routes->post('/login', function() {
    UserController::handle_login();
});

$routes->get('/register', function() {
    UserController::register();
});

$routes->post('/register', function() {
    UserController::handle_register();
});


/**
 * Other
 */
$routes->get('/', function() {
    Controller::index();
});





