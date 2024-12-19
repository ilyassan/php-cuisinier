<?php
    class User {
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        // Register user
        public function register($data){
            $this->db->query("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            // Bind values
            $this->db->bind('ssi', $data['name'], $data['email'], $data['password']); // "s" indicates string

            // Execute
            if($this->db->execute()){
                return true;
            }
            return false;
        }

        // Login user
        public function login($email, $password){
            $this->db->query("SELECT * FROM users WHERE email = ?");
            $this->db->bind('s', $email);

            $row = $this->db->single();

            if ($row) {
                $hashed_password = $row->password;
                if (password_verify($password, $hashed_password)) {
                    return $row;
                }
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
