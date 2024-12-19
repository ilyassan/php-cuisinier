<?php
    class Users extends Controller {
        public function __construct(){
            if (isLoggedIn()) {
                redirect("/");
            }
           $this->userModel = $this->model('User'); 
        }

        public function index() {
            redirect("auth/signup");
        }

        public function signup(){
            $this->view("auth/signup");
        }

        public function login(){
            $this->view("auth/login");
        }

        public function register(){
            // Check if Post
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init data
                $data = [
                    'first_name' => trim($_POST['firstname']),
                    'last_name' => trim($_POST['lastname']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm-password']),
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => '',
                ];

            }
        }
    }