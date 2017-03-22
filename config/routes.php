<?php


/*
 * HelloWorld
 */
$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

/*
 * !
 */

$routes->get('/', function() {
    Controller::index();
});

$routes->get('/task', function() {
    Controller::task();
});

$routes->get('/login', function() {
    Controller::login();
});