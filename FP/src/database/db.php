<?php
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS,DB_NAME);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $clientRoleId;
    $admineRoleId;

    function getAllMenus() {
        global $conn;
        $query = "SELECT * FROM menus";
        $result = mysqli_query($conn, $query);
    
        $menus = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $menus[] = $row;
        }
    
        return $menus;
    }

    function getMenuWithDishes($id) {
        global $conn;
        $query = "
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
        ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = $result->fetch_all(MYSQLI_ASSOC);

        // Group dishes under the menu
        $menu = null;
        $dishes = [];
        foreach ($data as $row) {
            if (!$menu) {
                $menu = [
                    'id' => $row["menu_id"],
                    'name' => $row["menu_name"],
                    'price' => $row["price"],
                    'description' => $row["description"],
                ];
            }
            if ($row["dish_id"]) {
                $dishes[] = [
                    'id' => $row["dish_id"],
                    'name' => $row["dish_name"],
                ];
            }
        }

        return [
            'menu' => $menu,
            'dishes' => $dishes
        ];
    }

    function createMenu($name, $price) {
        global $conn;
        $query = "INSERT INTO menus (name, price) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param('si', $name, $price);

        if ($stmt->execute()) {
            return $stmt->insert_id;
        } else {
            return false;
        }
    }

    function updateMenu($id, $name, $price) {
        global $conn;
        $query = "UPDATE menus SET name = ?, price = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param('sii', $name, $price, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function removeAttachedDishesFromMenu($menuId) {
        global $conn;
        $query = "DELETE FROM menu_dishes WHERE menu_id = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param('i', $menuId);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function attachDishesToMenu($menuId, $dishesIds) {
        global $conn;
        $conn->begin_transaction();

        try {
            foreach ($dishesIds as $dishId) {
                $query = "INSERT INTO menu_dishes (menu_id, dish_id) VALUES (?, ?)";
                $stmt = $conn->prepare($query);
                
                if ($stmt === false) {
                    throw new Exception('Prepare failed: ' . $conn->error);
                }

                $stmt->bind_param('ii', $menuId, $dishId);
                $stmt->execute();
            }

            $conn->commit();
            return true;
        } catch (Exception $e) {
            $conn->rollback();
            echo "Error in attaching the dishes: " . $e->getMessage();
            return false;
        }
    }

    function deleteMenu($id) {
        global $conn;
        $query = "DELETE FROM menus WHERE id = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            die('Execute failed: ' . $stmt->error);
            return false;
        }
    }

    function createReservation($menu_id, $client_id, $guests, $reservation_datetime) {
        global $conn;
        $query = "INSERT INTO reservations (menu_id, client_id, number_of_guests, reservation_date) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
    
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }
    
        $stmt->bind_param('iiis', $menu_id, $client_id, $guests, $reservation_datetime);
        return $stmt->execute();
    }

    function getAllReservationsWithMenuAndClient() {
        global $conn;
        $query = "
            SELECT
                reservations.*,
                menus.name as menu_name,
                menus.price as price,
                CONCAT(users.first_name, ' ', users.last_name) as client_name
            FROM reservations
            JOIN menus ON reservations.menu_id = menus.id
            JOIN users ON reservations.client_id = users.id
        ";

        $result = $conn->query($query);

        if ($result === false) {
            die('Query failed: ' . $conn->error);
        }

        $reservations = [];
        while ($row = $result->fetch_assoc()) {
            $reservations[] = $row;
        }

        return $reservations;
    }

    function getReservationsOfUser($userId) {
        global $conn;
        $query = "
            SELECT
                reservations.*,
                menus.name as menu_name,
                menus.price as price
            FROM reservations
            JOIN menus ON reservations.menu_id = menus.id
            WHERE reservations.client_id = ?
        ";

        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $reservations = [];
        while ($row = $result->fetch_assoc()) {
            $reservations[] = $row;
        }

        return $reservations;
    }

    function getFullReservationById($id) {
        global $conn;
        $query = "
            SELECT
                reservations.*,
                menus.name as menu_name,
                menus.price as price,
                CONCAT(users.first_name, ' ', users.last_name) as client_name
            FROM reservations
            JOIN menus ON reservations.menu_id = menus.id
            JOIN users ON reservations.client_id = users.id
            WHERE reservations.id = ?
        ";

        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        $reservation = $result->fetch_assoc();

        return $reservation;
    }

    function updateReservation($id, $menuId, $guestsNumber, $reservationDatetime) {
        global $conn;
        $query = "
            UPDATE reservations
            SET menu_id = ?, number_of_guests = ?, reservation_date = ?
            WHERE id = ?
        ";

        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param('iisi', $menuId, $guestsNumber, $reservationDatetime, $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function acceptReservation($id) {
        global $conn;
        $query = "UPDATE reservations SET status = 'approved' WHERE id = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function refuseReservation($id) {
        global $conn;
        $query = "UPDATE reservations SET status = 'declined' WHERE id = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param('i', $id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function deleteReservation($id) {
        global $conn;
        $query = "DELETE FROM reservations WHERE id = ?";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }
    
        $stmt->bind_param('i', $id);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    function registerUser($data) {
        global $conn;
        global $clientRoleId;
        $query = "INSERT INTO users (first_name, last_name, email, password_hash, role_id) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssi', $data['first_name'], $data['last_name'], $data['email'], $data['password'], $clientRoleId);

        // Execute
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function findUserByEmail($email) {
        global $conn;
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $row = $result->fetch_assoc();
    
        // Check row 
        return $row ? true : false;
    }

    function loginUser($email, $password) {
        global $conn;
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        $user = $result->fetch_assoc();
        if ($user) {
            $hashed_password = $user['password_hash'];
            if (password_verify($password, $hashed_password)) {
                return $user;
            }
        }
        return false;
    }

    function getUserById($id) {
        global $conn;
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $user = $result->fetch_assoc();
    
        return $user;
    }

    function getAllDishes() {
        global $conn;
        $query = "SELECT * FROM dishes";
        $result = mysqli_query($conn, $query);
    
        $dishes = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $dishes[] = $row;
        }
    
        return $dishes;
    }

    function getReservationsCountWithStatus($status) {
        global $conn;
        $query = "SELECT COUNT(*) as count FROM reservations WHERE status = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param('s', $status);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_assoc();

        return $count['count'];
    }

    function getConfirmedReservationsCountOfDate($date) {
        global $conn;
        $query = "SELECT COUNT(*) as count FROM reservations WHERE status = 'approved' AND reservation_date = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param('s', $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_assoc();

        return $count['count'];
    }

    function getNextConfirmedReservation() {
        global $conn;
        $query = "
            SELECT
                reservations.*,
                menus.name as menu_name,
                menus.price as price,
                CONCAT(users.first_name, ' ', users.last_name) as client_name
            FROM reservations
            JOIN menus ON reservations.menu_id = menus.id
            JOIN users ON reservations.client_id = users.id
            WHERE reservations.reservation_date >= ? AND reservations.status = 'approved'
            ORDER BY reservations.reservation_date ASC
            LIMIT 1
        ";

        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $currentDate = date('Y-m-d');
        $stmt->bind_param('s', $currentDate);
        $stmt->execute();
        $result = $stmt->get_result();
        $reservation = $result->fetch_assoc();

        return $reservation;
    }

    function getLastWeekReservationsCountGrouped() {
        global $conn;
        $query = "
            SELECT
                DATE(reservation_date) as date,
                COUNT(*) as count
            FROM reservations
            WHERE reservation_date >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK)
            GROUP BY DATE(reservation_date)
        ";

        $result = $conn->query($query);

        if ($result === false) {
            die('Query failed: ' . $conn->error);
        }

        $reservations = [];
        while ($row = $result->fetch_assoc()) {
            $reservations[] = $row;
        }

        return $reservations;
    }

    function getUsersCountByRole($role) {
        global $conn;
        global $clientRoleId;
        global $admineRoleId;

        $roleId = ($role == "client") ? $clientRoleId : $admineRoleId;
        $query = "SELECT COUNT(*) as count FROM users WHERE role_id = ?";
        $stmt = $conn->prepare($query);
        
        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param('i', $roleId);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_assoc();

        return $count['count'];
    }