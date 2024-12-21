<?php
    class Reservations extends Controller {

        private $reservationModel;
        private $menuModel;

        public function __construct(){
            if (!isLoggedIn()) {
                redirect("users/login");
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
                return;
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

        public function show($id) {
            $reservation = $this->reservationModel->getFullReservationById($id);
        
            if (!$reservation) {
                redirect("reservations");
            }
        
            // Pass data to the view
            $this->view('reservation/show', $reservation);
        }

        public function edit($id) {
            if (user()->isChef() || !$id) {
                redirect("reservations");
                return;
            }

            $reservation = $this->reservationModel->getFullReservationById($id);
            if($reservation->status != "pending") {
                flash("warning", "You cannot edit a reservation has been ". $reservation->status);
                redirect("reservations");
            }

            elseif($_SERVER['REQUEST_METHOD'] == 'POST'){           
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $reservation = [
                    'menu_id' => $_POST['menu_id'],
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
                    if ($this->reservationModel->update($id ,$reservation["menu_id"], $reservation["guests"], $reservation["reservation_datetime"])) {
                        flash("success", "Reservation has been updated successfully.");
                        redirect("reservations/show/". $id);
                    }else{
                        die("Something went wrong.");
                    }
                }else{
                    flash("error", "Please fill in all fields.");
                    $menus = $this->menuModel->getAll();
        
                    if (!$reservation || !$menus) {
                        redirect("reservations");
                    }
    
                    $data = [
                        "reservation" => $reservation,
                        "menus" => $menus
                    ];

                    $this->view("reservation/create", $data);
                }
            }
            else{
                $menus = $this->menuModel->getAll();
        
                if (!$reservation || !$menus) {
                    redirect("reservations");
                }

                $data = [
                    "reservation" => $reservation,
                    "menus" => $menus
                ];

                // Pass data to the view
                $this->view("reservation/edit", $data);
            }
        }


        public function delete($id) {

            if (user()->isChef() || $_SERVER['REQUEST_METHOD'] != 'POST' || !$id) {
                redirect("reservations");
            }

            $reservation = $this->reservationModel->getFullReservationById($id);

            if ($reservation->client_id != user()->getId()) {
                redirect("reservations");
            }

                
            if ($this->reservationModel->delete($id)) {
                flash("success", "Reservation has been deleted successfully.");
                redirect("reservations");
            } else {
                die("Something went wrong.");
            }
        }

        public function accept($id) {
            if (user()->isClient() || !$id) {
                redirect("reservations");
            }

            $reservation = $this->reservationModel->getFullReservationById($id);

            if ($reservation->status != "pending") {
                flash("warning", "You cannot accept a reservation has been ". $reservation->status);
                redirect("reservations");
            }

            if ($this->reservationModel->accept($id)) {
                flash("success", "Reservation has been accepted successfully.");
                redirect("reservations");
            } else {
                die("Something went wrong.");
            }
        }

        public function refuse($id) {
            if (user()->isClient() || !$id) {
                redirect("reservations");
            }

            $reservation = $this->reservationModel->getFullReservationById($id);

            if ($reservation->status != "pending") {
                flash("warning", "You cannot refuse a reservation has been ". $reservation->status);
                redirect("reservations");
            }

            if ($this->reservationModel->refuse($id)) {
                flash("success", "Reservation has been refused successfully.");
                redirect("reservations");
            } else {
                die("Something went wrong.");
            }
        }
    }