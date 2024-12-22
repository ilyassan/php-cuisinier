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

        public function getFullReservationById($id) {
            $this->db->query(
                "SELECT
                    reservations.*,
                    menus.name as menu_name,
                    menus.price as price,
                    CONCAT(users.first_name, ' ' ,users.last_name) as client_name
                FROM reservations
                JOIN menus ON reservations.menu_id = menus.id
                JOIN users ON reservations.client_id = users.id
                WHERE reservations.id = ?
                "
                );

            $this->db->bind('i', $id);
            $reservation = $this->db->single();

            return $reservation;
        }

        public function create($menuId, $clientId, $guestsNumber, $reservationDatetime) {
            $this->db->query(
                "INSERT INTO reservations (menu_id, client_id, number_of_guests, reservation_date)
                VALUES (?, ?, ?, ?)"
            );

            $this->db->bind('iiis', $menuId, $clientId, $guestsNumber, $reservationDatetime);

            if ($this->db->execute()) {
                return true;
            }else{
                return false;
            }
        }

        public function update($id, $menuId, $guestsNumber, $reservationDatetime) {
            $this->db->query(
                "UPDATE reservations
                SET menu_id = ?, number_of_guests = ?, reservation_date = ?
                WHERE id = ?"
            );

            $this->db->bind('iisi', $menuId, $guestsNumber, $reservationDatetime, $id);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
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

        public function getReservationsOfUser($userId) {
            $this->db->query(
                "SELECT
                    reservations.*,
                    menus.name as menu_name,
                    menus.price as price
                FROM reservations
                JOIN menus ON reservations.menu_id = menus.id
                WHERE reservations.client_id = ?"
            );

            $this->db->bind('i', $userId);

            $reservations = $this->db->results();

            return $reservations;
        }

        public function delete($id) {
            $this->db->query("DELETE FROM reservations WHERE id = ?");
            $this->db->bind('i', $id);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function accept($id) {
            $this->db->query("UPDATE reservations SET status = 'approved' WHERE id = ?");
            $this->db->bind('i', $id);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function refuse($id) {
            $this->db->query("UPDATE reservations SET status = 'declined' WHERE id = ?");
            $this->db->bind('i', $id);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function getReservationsCountWithStatus($status) {
            $this->db->query("SELECT COUNT(*) as count FROM reservations WHERE status = ?");
            $this->db->bind('s', $status);

            $count = $this->db->single();

            return $count->count;
        }

        public function getConfirmedReservationsCountOfDate($date) {
            $this->db->query("SELECT COUNT(*) as count FROM reservations WHERE status = 'approved' AND reservation_date = ?");
            $this->db->bind('s', $date);

            $count = $this->db->single();

            return $count->count;
        }

        public function getNextConfirmedReservation() {
            $this->db->query(
                "SELECT
                    reservations.*,
                    menus.name as menu_name,
                    menus.price as price,
                    CONCAT(users.first_name, ' ' ,users.last_name) as client_name
                FROM reservations
                JOIN menus ON reservations.menu_id = menus.id
                JOIN users ON reservations.client_id = users.id
                WHERE reservations.reservation_date >= ? AND reservations.status = 'approved'
                ORDER BY reservations.reservation_date ASC
                LIMIT 1"
            );

            $this->db->bind('s', date('Y-m-d'));

            $reservation = $this->db->single();

            return $reservation;
        }

        public function getLastWeekReservationsCountGrouped() {
            $this->db->query(
                "SELECT
                    DATE(reservation_date) as date,
                    COUNT(*) as count
                FROM reservations
                WHERE reservation_date >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)
                GROUP BY DATE(reservation_date)"
            );

            $reservations = $this->db->results();

            return $reservations;
        }
    }
