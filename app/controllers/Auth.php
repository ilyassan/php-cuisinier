<?php
    class Auth extends Controller {
        public function __construct(){
            if (isLoggedIn()) {
                redirect("/");
            }
        }

        public function signup(){
            $this->view("auth/signup");
        }

        public function login(){
            $this->view("auth/login");
        }
    }
