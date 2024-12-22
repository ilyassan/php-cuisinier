<?php
    include('./inc/header.php');

    $id = $_GET["id"];
    $reservation = getFullReservationById($id);

    if (!isset($id) || $_SERVER['REQUEST_METHOD'] != 'POST') {
        echo "Redirecting to reservations because id is not set or request method is not POST.";
        redirect("reservations");
        exit();
    }

    if (!user()->isChef() && (!$reservation || $reservation["client_id"] != user()->getId())) {
        echo "Redirecting to reservations because user is not authorized.";
        redirect("reservations");
        exit();
    }

    if (deleteReservation($id)) {
        flash("success", "Reservation has been deleted successfully.");
        echo "Redirecting to reservations after successful deletion.";
        redirect("reservations");
        exit();
    } else {
        die("Something went wrong.");
    }