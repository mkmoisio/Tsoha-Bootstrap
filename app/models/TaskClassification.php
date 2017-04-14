<?php

/**
 * 
 */
class TaskClassification extends BaseModel {

    public $id, $task_id, $classification_id;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    
    public static function findAll() {
        $query = DB::connection()->prepare('SELECT * FROM TaskClassification');
        $query->execute();

        $taskclassifications = array();


        foreach ($query->fetchAll() as $row) {
            $taskclassifications[] = new TaskClassification(array(
                'id' => $row['id'],
                'task_id' => $row['task_id'],
                'classification_id' => $row['classification_id']
            ));
        }
        return $taskclassifications;
    }

}
