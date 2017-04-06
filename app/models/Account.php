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

    public static function authenticate($username, $password) {
        $query = DB::connection()->prepare('SELECT * FROM Account WHERE username = :username AND password = :password');
        $query->execute(array('username' => $username, 'password' => $password));

        $row = $query->fetch();

        if ($row) {
            return new Account(array(
                'id' => $row['id'],
                'username' => $row['username']
            ));
        } else {
            return null;
        }
    }

    public static function register($username, $password) {
        $query = DB::connection()->prepare('SELECT Username FROM Account WHERE username = :username ');
        $query->execute(array('username' => $username));
        $row = $query->fetch();
        if ($row) {
            return null;
        } else {
            $query = DB::connection()->prepare('INSERT INTO Account(username, password) VALUES (:username, :password)');
            $query->execute(array('username' => $username, 'password' => $password));

            if ($query->fetch()) {
                $query = DB::connection()->prepare('SELECT * FROM Account WHERE username = :username');
                $query->execute(array('username' => $username));
                $row = $query->fetch();

                return new Account(array(
                    'id' => $row['id'],
                    'username' => $row['username']
                ));
            } else {
                return null;
            }
        }
    }

    //put your code here
}
