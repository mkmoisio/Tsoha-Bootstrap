<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserController extends BaseController {

    public static function login() {
        View::make('login.html');
    }

    public static function handle_login() {

        $params = $_POST;
        Kint::dump($params);
        $user = Account::authenticate($params['username'], $params['password']);
        Kint::dump($user);
        if (!$user) {
            View::make('login.html', array('errors' => array('Väärä käyttäjätunnus tai salasana!')));
        } else {
            $_SESSION['user'] = $user->id;

            Redirect::to('/', array('message' => 'Kirjautuminen ok - ' . $user->username . '.'));
        }
    }

    public static function register() {
        View::make('register.html');
    }

    public static function handle_registration() {
        $params = $_POST;

        Kint::dump($params);

        $user = Account::register($params['username'], $params['password']);

        Kint::dump($user);
        if (!$user) {
            View::make('register.html', array('errors' => array('Username already taken')));
        } else {
            $_SESSION['user'] = $user->id;
            Redirect::to('/', array('message' => 'Registered user ' . $user->username . '.'));
        }
    }

    public static function logout() {
        $_SESSION['user'] = null;
        Redirect::to('/', array('message' => 'Uloskirjautuminen ok.'));
    }

}
