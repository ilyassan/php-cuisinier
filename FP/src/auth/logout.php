<?php
    include('../inc/header.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        unset($_SESSION['user_id']);
        session_destroy();
        redirect('auth/login');
    }