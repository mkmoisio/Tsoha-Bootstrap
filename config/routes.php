<?php

/*
 * !
 */

$routes->get('/', function() {
    TaskController::index();
});

$routes->get('/new', function() {
    TaskController::create();
});

$routes->post('/new', function() {
    TaskController::store();
});

$routes->get('/task/:id/edit', function($id) {
    TaskController::edit($id);
});

$routes->get('/task/:id', function($id) {
    TaskController::task($id);
});


$routes->get('/login', function() {
    Controller::login();
});


