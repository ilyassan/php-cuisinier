<?php
    class Reservations extends Controller {

        private $reservationModel;
        private $menuModel;

        public function __construct(){
            if (!isLoggedIn()) {
                redirect("/users/login");
            }
           $this->reservationModel = $this->model('Reservation'); 
           $this->menuModel = $this->model('Menu'); 
        }

        public function index() {
            if (user()->isChef()) {
                $reservations = $this->reservationModel->getAllWithMenuAndClient();

                $this->view("reservation/index", $reservations);
            }elseif (user()->isClient()){
                $reservations = $this->reservationModel->getReservationsOfUser(user()->getId());
                
                $this->view("reservation/index", $reservations);
            }
        }

        public function create() {
            if (user()->isChef()) {
                redirect("reservations");
            }
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $reservation = [
                    'menu_id' => $_POST['menu_id'],
                    'client_id' => user()->getId(),
                    'guests' => $_POST['guests'],
                    'reservation_datetime' => $_POST['date'] . ' ' . $_POST['time']
                ];

                $errors = [
                    'menu_id_err' => '',
                    'reservation_date_err' => ''
                ];

                // Validate Menu ID
                if(empty($reservation['menu_id'])){
                    $errors['menu_id_err'] = 'Please select a menu.';
                }

                // Validate Reservation Date
                if(empty($reservation['reservation_datetime'])){
                    $errors['reservation_datetime_err'] = 'Please select a reservation date.';
                }

                if (empty($errors['menu_id_err']) && empty($errors['reservation_datetime_err'])) {
                    if ($this->reservationModel->create($reservation["menu_id"], $reservation["client_id"], $reservation["guests"], $reservation["reservation_datetime"])) {
                        flash("success", "Reservation has been created successfully.");
                        redirect("reservations");
                    }else{
                        die("Something went wrong.");
                    }
                }else{
                    flash("error", "Please fill in all fields.");
                    $menus = $this->menuModel->getAll();

                    $this->view("reservation/create", $menus);
                }
            }else{
                $menus = $this->menuModel->getAll();

                $this->view("reservation/create", $menus);
            }
        }
    }