<?php
    class Menu {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function getAll() {
            $this->db->query("SELECT * FROM menus");

            $menus = $this->db->results();

            return $menus;
        }

        public function getMenuById($id) {
            $this->db->query("SELECT * FROM menus WHERE id = ?");
            $this->db->bind('i', $id);

            $menu = $this->db->single();

            return $menu;
        }

        public function getMenuWithDishes($id) {
            $this->db->query("
                SELECT 
                    menus.id AS menu_id, 
                    menus.name AS menu_name, 
                    menus.price, 
                    menus.description, 
                    dishes.id AS dish_id, 
                    dishes.name AS dish_name
                FROM 
                    menus
                LEFT JOIN 
                    menu_dishes ON menus.id = menu_dishes.menu_id
                LEFT JOIN 
                    dishes ON menu_dishes.dish_id = dishes.id
                WHERE 
                    menus.id = ?
            ");
            $this->db->bind('i', $id);
        
            return $this->db->results();
        }        
    }
