<?php
    class Menus extends Controller {
        public function __construct(){
            if (!isLoggedIn()) {
                redirect("/users/login");
            }
           $this->menuModel = $this->model('Menu'); 
        }

        public function index() {
            $this->view("menu/index");
        }
    }