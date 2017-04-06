<?php

class BaseController {

    public static function get_user_logged_in() {

        if (isset($_SESSION['user'])) {
            $user_id = $_SESSION['user'];

            $user = Account::findOne($user_id);
            return $user;
        }

        // Toteuta kirjautuneen käyttäjän haku tähän
        return null;
    }

    public static function check_logged_in() {
        if (!isset($_SESSION['user'])) {
            Redirect::to('/login', array('message' => 'Kirjaudu ensin sisään!'));
        }
// Toteuta kirjautumisen tarkistus tähän.
        // Jos käyttäjä ei ole kirjautunut sisään, ohjaa hänet toiselle sivulle (esim. kirjautumissivulle).
    }

}
