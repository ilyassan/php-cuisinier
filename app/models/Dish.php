<?php
    class Dish {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function getAll() {
            $this->db->query("SELECT * FROM dishes");

            $dishes = $this->db->results();

            return $dishes;
        }     
    }
