<?php

/**
 * Description of Classification
 *
 * @author mikkomo
 */
class Classification extends BaseModel {

    public $id, $title, $text;

    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validate_title');
    }

    private static function fetchClassifications($query) {
        $classifications = array();

        foreach ($query->fetchAll() as $row) {
            $classifications[] = new Classification(array(
                'id' => $row['id'],
                'title' => $row['title'],
                'text' => $row['text'],
            ));
        }
        return $classifications;
    }

    /**
     * Returns all entities
     * @return \Classification
     */
    public static function findAll() {
        $query = DB::connection()->prepare('SELECT * FROM Classification');
        $query->execute();

        $classifications = array();


        foreach ($query->fetchAll() as $row) {
            $classifications[] = new Classification(array(
                'id' => $row['id'],
                'title' => $row['title'],
                'text' => $row['text'],
            ));
        }
        return $classifications;
    }

    /**
     * One single classification by primary key
     * @param type $id
     * @return \Classification
     */
    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Classification WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $classification = new Classification(array(
                'id' => $row['id'],
                'title' => $row['title'],
                'text' => $row['text'],
            ));
            return $classification;
        }

        return null;
    }

//    public static function findAllByAccountId($account_id) {
//        $query = DB::connection()->prepare('SELECT Classification.id, Classification.title FROM Classification );
//    }

    public function save() {
        $connection = DB::connection();
        $query = $connection->prepare('INSERT INTO Classification(title, text) VALUES (:title, :text)');
        $query->execute(array('title' => $this->title, 'text' => $this->text));
        /**
          $classification_id = $connection->lastInsertId('classification_id_seq');


          $query2 = $connection->prepare('INSERT INTO AccountClassification(account_id, classification_id) VALUES (:account_id, :classification_id)');
          $query2->execute(array('account_id' => $account_id, 'classification_id' => $classification_id));
         */
    }

    public static function delete($id) {
        $query2 = DB::connection()->prepare('Delete FROM AccountClassification WHERE AccountClassification.classification_id = :classification_id');
        $query2->execute(array('classification_id'=> $id));
        $query3 = DB::connection()->prepare('DELETE FROM Classification WHERE Classification.id = :id');
        $query3->execute(array('id' => $id));
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Classification SET title = :title, text = :text WHERE Classification.id = :id');
        $query->execute(array('title' => $this->title, 'text' => $this->text, 'id' => $this->id));
    }

    public static function findAllByAccountId($account_id) {
        $query = DB::connection()->prepare('SELECT Classification.id, Classification.title, Classification.text FROM'
                . ' Classification INNER JOIN AccountClassification ON Classification.id = AccountClassification.classification_id WHERE AccountClassification.account_id = :account_id');


        $query->execute(array('account_id' => $account_id));

        return Classification::fetchClassifications($query);
    }

    public function validate_title() {
        $errors = array();

        if (!parent::validate_string_length($this->title, 1)) {
            $errors[] = 'Title is empty!';
        }
        return $errors;
    }

    /* Ei validoida tekstiä - saa olla myös tyhjä
      public function validate_text() {
      $errors = array();

      if (!parent::validate_string_length($this->text, 0)) {
      $errors[] = 'Text field is empty!';
      }
      return $errors;
      }
     */
}
