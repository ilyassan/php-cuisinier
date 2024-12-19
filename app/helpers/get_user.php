<?php

class AuthenticatedUser {
    private $id;
    private $first_name;
    private $last_name;
    private $email;
    private $role_id;

    public static $clientRoleId = 1;
    public static $admineRoleId = 2;

    public function __construct($id, $first_name, $last_name, $email, $role) {
        $this->id = $id;
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->email = $email;
        $this->role = $role;
    }

    // Getters
    public function getId() {
        return $this->id;
    }

    public function getFirstName() {
        return $this->first_name;
    }
    public function getLastName() {
        return $this->last_name;
    }
    public function getFullName() {
        return $this->getFirstName() . " " . $this->getLastName();
    }

    public function getEmail() {
        return $this->email;
    }

    public function getRole() {
        return $this->isAdmin() ? "chef": "client";
    }

    // Role checks
    public function isAdmin() {
        return $this->role === self::$admineRoleId;
    }

    public function isClient() {
        return $this->role === self::$clientRoleId;
    }
}

function user() {
    static $cachedUser = null;

    // Return cached user if available
    if ($cachedUser !== null) {
        return $cachedUser;
    }

    // Check if user ID is in session
    if (isset($_SESSION["user_id"])) {
        $userId = $_SESSION["user_id"];

        // Load the User model
        require_once(APPROOT . "/models/User.php");
        $userModel = new User();

        // Fetch user data
        $userData = $userModel->getUserById($userId);

        if ($userData) {
            // Create and cache the AuthenticatedUser object
            $cachedUser = new AuthenticatedUser(
                $userData->id,
                $userData->first_name,
                $userData->last_name,
                $userData->email,
                $userData->role_id
            );
            return $cachedUser;
        }
    }

    return null; // Return null if no user is logged in
}

