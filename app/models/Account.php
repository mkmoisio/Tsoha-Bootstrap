<?php

/**
 * Description of Account
 *
 * @author mikkomo
 */
class Account extends BaseModel {

    public $id, $username, $password;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    /**
     * Returns all entities
     * @param type $id
     * @return \Account
     */
    public static function findOne($id) {
        $query = DB::connection()->prepare('SELECT * FROM Account WHERE id = :id LIMIT 1');
        $query->execute(array('id' => $id));
        $row = $query->fetch();

        if ($row) {
            $account = new Account(array(
                'id' => $row['id'],
                'username' => $row['username']
            ));
            return $account;
        }

        return null;
    }

    //put your code here
}
