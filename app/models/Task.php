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
                'account_id' => $row['account_id'],
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
        $query = DB::connection()->prepare('SELECT * FROM Task WHERE account_id = :account_id');
        $query->execute(array('account_id' => $account_id));
        return Task::fetchTasks($query);
    }

    /**
     * 
     * Returns all task entities hooked to a classification with $classification_id
     * 
     * @param type $classification_id
     * @return \Task
     */
    public static function findAllByClassificationId($classification_id) {
        $query = DB::connection()->prepare('SELECT Task.id, Task.account_id, Task.title, Task.text, Task.date FROM Task INNER JOIN TaskClassification '
                . 'ON Task.id = TaskClassification.task_id '
                . 'WHERE TaskClassification.classification_id = :classification_id');
        $query->execute(array('classification_id' => $classification_id));
        return Task::fetchTasks($query);
    }

    /**
     * Saves the object to the Task table
     * @return type
     */
    public function save($classifications) {

        $connection = DB::connection();
        $query = $connection->prepare('INSERT INTO Task(account_id, title, text, date) VALUES (:account_id, :title, :text, NOW())');
        $query->execute(array('account_id' => $this->account_id, 'title' => $this->title, 'text' => $this->text));
        $task_id = $connection->lastInsertId('task_id_seq');

        foreach ($classifications as $classification_id) {
            $query2 = DB::connection()->prepare('INSERT INTO TaskClassification(task_id, classification_id) VALUES (:task_id, :classification_id)');
            $query2->execute(array('task_id' => $task_id, 'classification_id' => $classification_id));
        }
    }

    public function update($account_id) {
        $query = DB::connection()->prepare('UPDATE Task SET title = :title, text = :text WHERE Task.id = :id AND Task.account_id = :account_id');
        $query->execute(array('title' => $this->title, 'text' => $this->text, 'id' => $this->id, 'account_id' => $account_id));
    }

    public static function delete($id, $account_id) {

        // Tarkistetaan että kirjautunut käyttäjä omistaa taskin
        if (Task::findOne($id)->account_id == $account_id) {

            // Poistetaan ko. taskia kokevat liitostaulun rivit
            $query1 = DB::connection()->prepare('DELETE FROM TaskClassification WHERE TaskClassification.task_id = :id');
            $query1->execute(array('id' => $id));

            // Poistetaan itse task
            $query2 = DB::connection()->prepare('DELETE FROM Task WHERE Task.id = :id AND Task.account_id = :account_id');
            $query2->execute(array('id' => $id, 'account_id' => $account_id));
        }
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
