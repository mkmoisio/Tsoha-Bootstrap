<?php

/**
 * Description of Task
 *
 * @author mikkomo
 */
class Task extends BaseModel {

    public $id, $account_id, $title, $text, $date;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_title', 'validate_text');
    }

    private static function fetchTasks($query) {
        $tasks = array();

        foreach ($query->fetchAll() as $row) {
            $tasks[] = new Task(array(
                'id' => $row['id'],
                'account_id' => $row['account_id'],
                'title' => $row['title'],
                'text' => $row['text'],
                'date' => $row['date']
            ));
        }
        return $tasks;
    }

    /**
     *  Returns all entities
     * @return \Task
     */
    public static function findAll() {
        $query = DB::connection()->prepare('SELECT * FROM Task');
        $query->execute();
        return Task::fetchTasks($query);
    }

    /**
     * One single task by primary key
     * 
     * @param type $id
     * @return \Task
     */
    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Task WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $task = new Task(array(
                'id' => $row['id'],
                'title' => $row['title'],
                'text' => $row['text'],
                'date' => $row['date']
            ));

            return $task;
        }

        return null;
    }

    /**
     * Returns all entities having account_id = $id
     * 
     * @param type $id
     * @return \Task
     */
    public static function findAllByAccountId($account_id) {
        $query = DB::connection()->prepare('SELECT * FROM Task WHERE account_id = :id');
        $query->execute(array('id' => $account_id));
        $tasks = array();

        foreach ($query->fetchAll() as $row) {
            $tasks[] = new Task(array(
                'id' => $row['id'],
                'title' => $row['title'],
                'text' => $row['text'],
                'date' => $row['date']
            ));
        }

        return $tasks;
    }

    /**
     * 
     * Returns all task entities hooked to a classification with $classification_id
     * 
     * @param type $classification_id
     * @return \Task
     */
    public static function findAllByClassificationId($classification_id) {
        $query = DB::connection()->prepare('SELECT * FROM Task INNER JOIN TaskClassification '
                . 'ON Task.id = TaskClassification.task_id '
                . 'WHERE TaskClassification.classification_id = :id');
        $query->execute(array('id' => $classification_id));
        $tasks = array();

        foreach ($query->fetchAll() as $row) {
            $tasks[] = new Task(array(
                'id' => $row['id'],
                'title' => $row['title'],
                'text' => $row['text'],
                'date' => $row['date']
            ));
        }

        return $tasks;
    }

    /**
     * Saves the object to the Task table
     * @return type
     */
    public function save() {
        /// !!!!!!!!!! HUOM ACCOUNT IDKSI TULEE AINA 1 !!!!!!!!!!
        $query = DB::connection()->prepare('INSERT INTO Task(account_id, title, text, date) VALUES (:account_id, :title, :text, NOW())');
        $query->execute(array('account_id' => $this->account_id, 'title' => $this->title, 'text' => $this->text));

//        $row = $query->fetch();
//        $this->id = $row['id'];
//        return $this->id;
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Task SET title = :title, text = :text WHERE Task.id = :id');
        $query->execute(array('title' => $this->title, 'text' => $this->text, 'id' => $this->id));
    }

    public static function delete($id) {
        $query = DB::connection()->prepare('DELETE FROM Task WHERE Task.id = :id');
        // Huom delete ei toimi jos poistettava entiteetti on viimeinen, johon viitataan TaskClassificationissa
        $query->execute(array('id' => $id));
    }

    public function validate_title() {
        $errors = array();

        if (!parent::validate_string_length($this->title, 1)) {
            $errors[] = 'Title is empty!';
        }
        return $errors;
    }

    public function validate_text() {
        $errors = array();

        if (!parent::validate_string_length($this->text, 1)) {
            $errors[] = 'Text field is empty!';
        }
        return $errors;
    }

}
