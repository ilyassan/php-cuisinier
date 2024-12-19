<?php
    class Menu {
        private $db;

        public function __construct(){
            $this->db = new Database;
        }

        public function getAll(){
            $this->db->query("SELECT * FROM menus");

            $menus = $this->db->results();

            return $menus;
        }
    }
