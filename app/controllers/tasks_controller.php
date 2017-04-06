<?php

/**
 * Description of tasks_controller
 *
 * @author mikkomo
 */
class TaskController extends BaseController {

    public static function task($id) {
        $task = Task::findOne($id);
        Kint::dump($task);
        View::make('task.html', array('task' => $task));
    }

    public static function create() {
        self::check_logged_in();
        View::make('task/create_task.html');
    }

    public static function store() {
        self::check_logged_in();
        $params = $_POST;

        $attributes = array(
            'title' => $params['title'],
            'text' => $params['text']
        );

        $task = new Task($attributes);

        $errors = $task->errors();

        if (count($errors) == 0) {
            $task->save();
            Redirect::to('/');
        } else {
            View::make('task/create_task.html', array('errors' => $errors, 'attributes' => $attributes));
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
            $task->update();
            Redirect::to('/task/' . $task->id);
        } else {
            View::make('task/edit_task.html', array('errors' => $errors, 'task' => $task));
        }
    }

    public static function delete($id) {
        self::check_logged_in();
        Task::delete($id);
        Redirect::to('/');
    }

}
