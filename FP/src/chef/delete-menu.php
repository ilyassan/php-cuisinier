<?php
    include('../inc/header.php');

    if (user()->isClient()) {
        redirect("menu");
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $menuId = $_POST['menu_id'];
        if (deleteMenu($menuId)) {
            flash("success", "Menu has been deleted successfully.");
        }else {
            die("Something went wrong");
        }
    }
    redirect("menus");