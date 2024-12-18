<?php
    session_start();

    // Flash message helper
    function flash($name = '', $message = '', $class = 'alert alert-success'){
        if(!empty($name)){

            if(!empty($message) && empty($_SESSION[$name])){

                $_SESSION[$name] = $message;
                $_SESSION[$name. '_class'] = $class;

            }elseif(empty($message) && !empty($_SESSION[$name])){

                $class = !empty($_SESSION[$name. '_class']) ? $_SESSION[$name. '_class'] : '';
                $message = $_SESSION[$name];
                unset($_SESSION[$name]);
                unset($_SESSION[$name. '_class']);
                
                return "<div class='$class' id='msg-flash'>$message</div>";
            }

        }
    }

    function isLoggedIn(){
        if(isset($_SESSION['user_id'])){
            return true;
        }
        return false;
    }