<?php
    class Reservations extends Controller {

        private $reservationModel;

        public function __construct(){
            if (!isLoggedIn()) {
                redirect("/users/login");
            }
           $this->reservationModel = $this->model('Reservation'); 
        }

        public function index() {
            $reservations = $this->reservationModel->getAllWithMenuAndClient();

            $this->view("reservation/index", $reservations);
        }
    }