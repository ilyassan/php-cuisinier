<?php
    class Menus extends Controller {

        private $menuModel;

        public function __construct(){
            if (!isLoggedIn()) {
                redirect("/users/login");
            }
           $this->menuModel = $this->model('Menu'); 
        }

        public function index() {
            $menus = $this->menuModel->getAll();

            $this->view("menu/index", $menus);
        }

        public function show($id) {
            $menuWithDishes = $this->menuModel->getMenuWithDishes($id);
        
            if (!$menuWithDishes) {
                redirect("menus");
            }

            // Group dishes under the menu
            $menu = null;
            $dishes = [];
            foreach ($menuWithDishes as $row) {
                if (!$menu) {
                    $menu = [
                        'id' => $row["menu_id"],
                        'name' => $row["menu_name"],
                        'price' => $row["price"],
                        'description' => $row["description"],
                    ];
                }
                if ($row["dish_id"]) {
                    $dishes[] = [
                        'id' => $row["dish_id"],
                        'name' => $row["dish_name"],
                    ];
                }
            }
        
            $data = [
                'menu' => $menu,
                'dishes' => $dishes
            ];
        
            // Pass data to the view
            $this->view('menu/show', $data);
        }        
    }