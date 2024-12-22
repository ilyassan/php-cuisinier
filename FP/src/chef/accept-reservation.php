<?php
    include('../inc/header.php');

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $id = $_GET["id"];
        if (user()->isClient() || !$id) {
            redirect("reservations");
        }
    
        $reservation = getFullReservationById($id);
    
        if ($reservation["status"] != "pending") {
            flash("warning", "You cannot accept a reservation has been ". $reservation["status"]);
            redirect("reservations");
        }
    
        if (acceptReservation($id)) {
            flash("success", "Reservation has been accepted successfully.");
            redirect("reservations");
        } else {
            die("Something went wrong.");
        }
    }