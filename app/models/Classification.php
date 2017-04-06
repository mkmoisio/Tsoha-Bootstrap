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
        $query = DB::connection()->prepare('INSERT INTO Classification(title, text) VALUES (:title, :text)');
        $query->execute(array('title' => $this->title, 'text' => $this->text));
    }

    public static function delete($id) {
        $query = DB::connection()->prepare('DELETE FROM Classification WHERE Classification.id = :id');
        // Huom delete ei toimi jos poistettava entiteetti on viimeinen, johon viitataan TaskClassificationissa
        $query->execute(array('id' => $id));
    }

    public function update() {
        $query = DB::connection()->prepare('UPDATE Classification SET title = :title, text = :text WHERE Classification.id = :id');
        $query->execute(array('title' => $this->title, 'text' => $this->text, 'id' => $this->id));
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
