<?php
    class Users extends Controller {
        public function __construct(){
           $this->userModel = $this->model('User'); 
        }

        public function index(){
            redirect('auth/signup');
        }

        public function signup(){
            // Check if Post
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init data
                $data = [
                    'name' => trim($_POST['name']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm_password']),
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => '',
                ];

                // Validate Name
                if(empty($data['name'])){
                    $data['name_err'] = 'Please enter name';
                }
                
                // Validate Email
                if(empty($data['email'])){
                    $data['email_err'] = 'Please enter email';
                }elseif($this->userModel->findUserByEmail($data['email'])){
                    $data['email_err'] = 'Email is already used';
                }

                // Validate Password
                if(empty($data['password'])){
                    $data['password_err'] = 'Please enter password';
                }elseif(strlen($data['password']) < 6){
                    $data['password_err'] = 'Password must be at least 6 characters';
                }

                // Validate Confirm Password
                if(empty($data['confirm_password'])){
                    $data['confirm_password_err'] = 'Please confirm password';
                }elseif($data['password'] != $data['confirm_password']){
                    $data['confirm_password_err'] = 'Passwords do not match';
                }

                // Make sure errors are empty (There's no errors)
                if(empty($data['name_err']) && empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])){
                    // Validated
                    
                    // Hash Password
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                    // Register user
                    if($this->userModel->register($data)){
                        // Register success
                        flash('register_success', 'You are registered and can log in');
                        redirect('users/login');
                    }else{
                        die('Something went wrong');
                    }

                }else{
                    // Load view with errors
                    $this->view("/users/register", $data);
                }


            }else{
                // Load form
                $data = [
                    'name' => '',
                    'email' => '',
                    'password' => '',
                    'confirm_password' => '',
                    'name_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => '',
                ];
                $this->view('users/register', $data);
            }
        }

        public function login(){
            // Check if Post
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Process form

                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // Init data
                $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'email_err' => '',
                    'password_err' => '',
                ];

                // Validate Email
                if(empty($data['email'])){
                    $data['email_err'] = 'Please enter your email';
                }elseif(!$this->userModel->findUserByEmail($data['email'])){
                    // if user not found
                    $data['email_err'] = 'No user found';
                }

                // Validate Password
                if(empty($data['password'])){
                    $data['password_err'] = 'Please enter your password';
                }


                // Make sure errors are empty (There's no errors)
                if(empty($data['email_err']) && empty($data['password_err'])){
                    // Validated
                    // Check and set logged in user
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                    if($loggedInUser){
                        // Create Session
                        $this->createUserSession($loggedInUser);
                    }else{
                        $data['password_err'] = 'Password incorrect';
                        $this->view("/users/login", $data);
                    }
                }else{
                    // Load view with errors
                    $this->view("/users/login", $data);
                }

            }else{
                // Load form
                $data = [
                    'email' => '',
                    'password' => '',
                    'email_err' => '',
                    'password_err' => '',
                ];
                $this->view('users/login', $data);
            }
        }
    }