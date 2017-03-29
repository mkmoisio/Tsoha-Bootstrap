<?php

class Classification extends BaseModel {

    public $id, $title, $text;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    /**
     * Returns all entities
     * @return \Classification
     */
    public static function all() {
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
    public static function find($id) {
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

}
