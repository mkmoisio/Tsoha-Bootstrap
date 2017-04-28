<?php

/**
 * Description of tasks_controller
 *
 * @author mikkomo
 */
class TaskController extends BaseController {

    public static function task($id) {
        $task = Task::findOne($id);
        if (self::get_user_logged_in() != null && $task->account_id == self::get_user_logged_in()->id) {
            $boolean = true;
        } else {
            $boolean = null;
        }
        $user = Account::findOne($task->account_id)->username;
        Kint::dump($task);
        Kint::dump($boolean);
        View::make('task/task.html', array('task' => $task, 'owner' => $boolean, 'user' => $user));
    }

    public static function create() {
        self::check_logged_in();
        $classifications = Classification::findAll();

        View::make('task/create_task.html', array('classifications' => $classifications));
    }

    public static function store() {
        self::check_logged_in();
        $params = $_POST;
        
        if (array_key_exists('classifications', $params)) {
            $classifications = $params['classifications'];
        } else {
            $classifications = array();
        }

        $attributes = array(
            'account_id' => self::get_user_logged_in()->id,
            'title' => $params['title'],
            'text' => $params['text']
        );

        $task = new Task($attributes);

        $errors = $task->errors();

        if (count($errors) == 0) {

            $task->save($classifications);

            Redirect::to('/');
        } else {
            $classifications = Classification::findAll();
            View::make('task/create_task.html', array('errors' => $errors, 'attributes' => $attributes, 'classifications' => $classifications));
        }
    }

    public static function edit($id) {
        self::check_logged_in();
        $task = Task::findOne($id);
        Kint::dump($task);

        View::make('task/edit_task.html', array('task' => $task));
    }

    public static function update($id) {
        self::check_logged_in();
        $params = $_POST;
        $task = Task::findOne($id);

        if (strlen(trim($params['title'])) > 0) {
            $task->title = $params['title'];
        }
        $task->text = $params['text'];
        $errors = $task->errors();




        Kint::dump($task);
        Kint::dump($errors);
        if (count($errors) == 0) {
            $task->update(self::get_user_logged_in()->id);
            Redirect::to('/task/' . $task->id);
        } else {
            View::make('task/edit_task.html', array('errors' => $errors, 'task' => $task));
        }
    }

    public static function delete($id) {
        self::check_logged_in();
        
        Task::delete($id, self::get_user_logged_in()->id);
        Redirect::to('/');
    }

}
