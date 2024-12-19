<?php
    class User {
        private $db;
        public static $clientRoleId = 1;
        public static $admineRoleId = 2;

        public function __construct(){
            $this->db = new Database;
        }

        // Register user
        public function register($data){
            $this->db->query("INSERT INTO users (first_name, last_name, email, password_hash, role_id) VALUES (?, ?, ?, ?, ?)");
            // Bind values
            $this->db->bind('ssssi', $data['first_name'], $data['last_name'], $data['email'], $data['password'], self::$clientRoleId);

            // Execute
            if($this->db->execute()){
                return true;
            }
            return false;
        }

        // Verify if using exist
        public function login($email, $password) {
            $this->db->query("SELECT * FROM users WHERE email = ?");
            // Bind values
            $this->db->bind('s', $email);

            $user = $this->db->single();
            $hashed_password = $user->password_hash;
            
            if(password_verify($password, $hashed_password)){
                return $user;
            }
            return false;
        }

        // Find user by email
        public function findUserByEmail($email){
            $this->db->query("SELECT * FROM users WHERE email = ?");
            // Bind values
            $this->db->bind('s', $email);

            $row = $this->db->single();

            // Check row 
            return $row ? true : false;
        }
    }
