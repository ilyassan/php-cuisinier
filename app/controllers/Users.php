<?php
    class Users extends Controller {

        private $userModel;

        public function __construct(){
            if (isLoggedIn()) {
                redirect("menus");
            }
           $this->userModel = $this->model('User'); 
        }

        public function index() {
            redirect("users/signup");
        }

        public function signup(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'first_name' => trim($_POST['firstname']),
                    'last_name' => trim($_POST['lastname']),
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password']),
                    'confirm_password' => trim($_POST['confirm-password'])
                ];
                $errors = [
                    'firstname_err' => '',
                    'lastname_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'confirm_password_err' => ''
                ];

                // Validate First Name
                if(empty($data['first_name'])){
                    $errors['firstname_err'] = 'Please enter your first name.';
                }

                // Validate Last Name
                if(empty($data['last_name'])){
                    $errors['lastname_err'] = 'Please enter your last name.';
                }
                
                // Validate Email
                if(empty($data['email'])){
                    $errors['email_err'] = 'Please enter email.';
                }elseif($this->userModel->findUserByEmail($data['email'])){
                    $errors['email_err'] = 'Email is already used.';
                }

                // Validate Password
                if(empty($data['password'])){
                    $errors['password_err'] = 'Please enter password.';
                }elseif(strlen($data['password']) < 6){
                    $errors['password_err'] = 'Password must be at least 6 characters.';
                }

                // Validate Confirm Password
                if(empty($data['confirm_password'])){
                    $errors['confirm_password_err'] = 'Please confirm password';
                }elseif($data['password'] != $data['confirm_password']){
                    $errors['confirm_password_err'] = 'Passwords do not match.';
                }

                // Make sure errors are empty (There's no errors)
                if(empty($errors['firstname_err']) && empty($errors['lastname_err']) && empty($errors['email_err']) && empty($errors['password_err']) && empty($errors['confirm_password_err'])){
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
                }
                else{
                    // Load view with errors
                    $this->view("/users/signup", $errors);
                }
            }
            else {
                $this->view('users/signup');
            }
        }

        public function login(){
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password'])
                ];
                $errors = [
                    'email_err' => '',
                    'password_err' => ''
                ];

                // Validate Email
                if(empty($data['email'])){
                    $errors['email_err'] = 'Please enter your email.';
                }elseif(!$this->userModel->findUserByEmail($data['email'])){
                    // if user not found
                    $errors['email_err'] = 'No user found.';
                }

                // Validate Password
                if(empty($data['password'])){
                    $errors['password_err'] = 'Please enter your password.';
                }


                // Make sure errors are empty (There's no errors)
                if(empty($errors['email_err']) && empty($errors['password_err'])){
                    // Validated
                    // Check and set logged in user
                    $loggedInUser = $this->userModel->login($data['email'], $data['password']);

                    if($loggedInUser){
                        $this->createUserSession($loggedInUser);
                    }else{
                        $errors['password_err'] = 'Password incorrect.';
                        $this->view("users/login", $errors);
                    }
                }else{
                    // Load view with errors
                    $this->view("users/login", $errors);
                }
            }
            else {
                $this->view('users/login');
            }
        }

        public function createUserSession($user){
            $_SESSION['user_id'] = $user->id;
            redirect('/');
        }

        public function logout(){
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                unset($_SESSION['user_id']);
                session_destroy();
                redirect('users/login');
            }
        }
    }