<?php

class ClassificationController extends BaseController {

    public static function create() {
        View::make('classification/create_classification.html');
    }

    public static function store() {
        $params = $_POST;

        $attributes = array(
            'title' => $params['title'],
            'text' => $params['text']
        );

        $classification = new Classification($attributes);

        $errors = $classification->errors();

        if (count($errors) == 0) {
            $classification->save();
            Redirect::to('/');
        } else {
            View::make('classification/create_classification.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }

    public static function edit($id) {
        $classification = Classification::findOne($id);
        Kint::dump($classification);

        View::make('classification/edit_classification.html', array('classification' => $classification));
    }

    public static function classification($id) {
        $classification = Classification::findOne($id);
        Kint::dump($classification);
        View::make('classification/classification.html', array('classification' => $classification));
    }

    public static function delete($id) {
        Classification::delete($id);
        Redirect::to('/');
    }

    public static function update($id) {
        $params = $_POST;
        $classification = Classification::findOne($id);

        if (strlen(trim($params['title'])) > 0) {
            $classification->title = $params['title'];
        }
  
        $classification->text = $params['text'];
        $errors = $classification->errors();


        Kint::dump($classification);
        Kint::dump($errors);
        if (count($errors) == 0) {
            $classification->update();
            Redirect::to('/classification/' . $classification->id);
        } else {
            View::make('classification/edit_classification.html', array('errors' => $errors, 'classification' => $classification));
        }
    }

}
