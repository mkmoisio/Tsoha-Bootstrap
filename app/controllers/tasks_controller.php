<?php

/**
 * Description of tasks_controller
 *
 * @author mikkomo
 */
class TaskController extends BaseController {

    public static function index() {
        $tasks = Task::findAll();
        Kint::dump($tasks);
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('index.html', array('tasks' => $tasks));
    }

    public static function task($id) {
        $task = Task::findOne($id);
        Kint::dump($task);
        View::make('task.html', array('task' => $task));
    }

    public static function create() {
        View::make('create.html');
    }

    public static function store() {
        $params = $_POST;

        $task = new Task(array(
            'title' => $params['title'],
            'text' => $params['text']
        ));

        $task->save();
        Redirect::to('/');
    }

    public static function edit($id) {
        $task = Task::findOne($id);
        Kint::dump($task);

        View::make('edit.html', array('task' => $task));
    }

}
