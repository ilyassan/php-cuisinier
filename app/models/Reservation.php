<?php
    class Reservation {
        private $db;

        public function __construct() {
            $this->db = new Database;
        }

        public function getAll() {
            $this->db->query("SELECT * FROM reservations");

            $reservations = $this->db->results();

            return $reservations;
        }
        
        public function getAllWithMenuAndClient() {
            $this->db->query(
                "SELECT
                    reservations.*,
                    menus.name as menu_name,
                    menus.price as price,
                    CONCAT(users.first_name, ' ' ,users.last_name) as client_name
                FROM reservations
                JOIN menus ON reservations.menu_id = menus.id
                JOIN users ON reservations.client_id = users.id"
                );

            $reservations = $this->db->results();

            return $reservations;
        }
    }
