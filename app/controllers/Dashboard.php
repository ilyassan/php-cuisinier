<?php
    class Dashboard extends Controller {

        private $reservationModel;
        private $userModel;

        public function __construct(){
            if (!isLoggedIn()) {
                redirect("users/login");
            }
            elseif (user()->isClient()) {
                redirect("menus");
            }
           $this->reservationModel = $this->model('Reservation');
           $this->userModel = $this->model('User');
        }

        public function index() {
            $pendingReservationsCount = $this->reservationModel->getReservationsCountWithStatus("pending");
            $todayConfirmedReservationsCount = $this->reservationModel->getConfirmedReservationsCountOfDate(date('Y-m-d'));
            $tommorowConfirmedReservationsCount = $this->reservationModel->getConfirmedReservationsCountOfDate(date('Y-m-d', strtotime('+1 day')));
            $clientsCount = $this->userModel->getUsersCountByRole("client");
            $nextReservation = $this->reservationModel->getNextConfirmedReservation();
            $reservationsRecievedInLastWeek = $this->reservationModel->getLastWeekReservationsCountGrouped();
            

            $data = [
                'pendingReservationsCount' => $pendingReservationsCount,
                'todayConfirmedReservationsCount' => $todayConfirmedReservationsCount,
                'tommorowConfirmedReservationsCount' => $tommorowConfirmedReservationsCount,
                'clientsCount' => $clientsCount,
                'nextReservation' => $nextReservation,
                'reservationsRecievedInLastWeek' => $reservationsRecievedInLastWeek
            ];

            $this->view("/dashboard", $data);
        }
    }