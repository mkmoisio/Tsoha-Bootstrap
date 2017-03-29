<?php

class Task extends BaseModel {

    public $id, $title, $text, $due;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    /**
     *  Returns all entities
     * @return \Task
     */
    public static function all() {
        $query = DB::connection()->prepare('SELECT * FROM Task');
        $query->execute();

        $tasks = array();

        foreach ($query->fetchAll() as $row) {
            $tasks[] = new Task(array(
                'id' => $row['id'],
                'title' => $row['title'],
                'text' => $row['text'],
                'due' => $row['due']
            ));
        }
        return $tasks;
    }

    /**
     * One single task by primary key
     * 
     * @param type $id
     * @return \Task
     */
    public static function find($id) {
        $query = DB::connection()->prepare('SELECT * FROM Task WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $task = new Task(array(
                'id' => $row['id'],
                'title' => $row['title'],
                'text' => $row['text'],
                'due' => $row['due']
            ));
            return $task;
        }

        return null;
    }
    
//    public static function findByAccount($account_id) {
//        
//        
//    }

}
