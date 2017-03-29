<?php

class Classification extends BaseModel {

    public $id, $title, $text;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    //put your code here
}
