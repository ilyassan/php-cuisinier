<?php
    /*
     * Base Controller
     * Load models and views
     */
    class Controller {
        // Load model
        public function model($model){
            // Require model file
            require_once '../app/models/'. $model . '.php';
            // Institiate model
            return new $model;
        }

        // Load view
        public function view($view, $data = []){
            // Check for view file
            if (isLoggedIn()) {
                $view = user()->getRole(). "/" . $view;
            }
            
            if(file_exists('../app/views/' . $view . '.php')){
                require_once '../app/views/' . $view . '.php';
            }else{
                // Not exist
                die('View does not exist');
            }
        }
    }