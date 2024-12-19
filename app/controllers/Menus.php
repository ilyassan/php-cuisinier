<?php
    class Menus extends Controller {
        public function __construct(){
            if (!isLoggedIn()) {
                redirect("/users/login");
            }
           $this->menuModel = $this->model('Menu'); 
        }

        public function index() {
            $menus = $this->menuModel->getAll();

            $this->view("menu/index", $menus);
        }
    }