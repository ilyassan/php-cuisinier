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
        
        public function createMenu($name, $price) {
            $this->db->query("INSERT INTO menus (name, price) VALUES (?, ?)");
            // Bind values
            $this->db->bind('si', $name, $price);

            // Execute
            if($this->db->execute()){
                return $this->db->getLastInsertId();
            }
            return false;
        }

        public function attachDishes($menuId, $dishesIds){
            try {
                $this->db->beginTransaction();
    
                foreach ($dishesIds as $dishId) {
                    $this->db->query("INSERT INTO menu_dishes (menu_id, dish_id) VALUES (?, ?)");
                    $this->db->bind("ii", $menuId, $dishId);
                    $this->db->execute();
                }
    
                $this->db->commit();
                return true;
            } catch (Exception $e) {
                echo "Error in attaching the dishes: " . $e->getMessage();
                return false;
            }
        }
    }
