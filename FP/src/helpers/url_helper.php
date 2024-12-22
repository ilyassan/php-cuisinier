<?php
    // Page redirect
    function redirect($page, $idParam = ""){
        $location = 'location: '. URL;

        if (isLoggedIn() && user()->isChef()) {
            $location .= '/chef';
        }
        if ($idParam == "") {
            header($location .'/' . $page . '.php');
        }else{
            header($location . '/' . $page . '.php?id=' . $idParam );
        }
        exit();
    }