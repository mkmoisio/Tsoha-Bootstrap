<?php

class Controller extends BaseController {

    public static function index() {
        $tasks = Task::findAll();
        $classifications = Classification::findAll();
        Kint::dump($tasks);
        Kint::dump($classifications);
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja

        View::make('general/index.html', array('tasks' => $tasks, 'classifications' => $classifications));
    }

    public static function personal() {
        $tasks = Task::findAllByAccountId(self::get_user_logged_in()->id);    
        $classifications = Classification::findAllByAccountId(self::get_user_logged_in()->id);
      
        View::make('general/index.html', array('personal' => true, 'tasks' => $tasks, 'classifications' => $classifications));
    }

}
