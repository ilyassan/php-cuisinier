<?php
    class Menus extends Controller {

        private $menuModel;

        public function __construct(){
            if (!isLoggedIn()) {
                redirect("/users/login");
            }
           $this->menuModel = $this->model('Menu'); 
           $this->dishModel = $this->model('Dish'); 
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
        
        public function create() {
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                // Sanitize POST data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $menu = [
                    'name' => $_POST['name'],
                    'price' => (float)$_POST['price']
                ];

                $errors = [
                    'name_err' => '',
                    'price_err' => ''
                ];

                unset($_POST["name"]);
                unset($_POST["price"]);

                $dishesIds = $_POST;

                // Validate Menu Name
                if(empty($menu['name'])){
                    $errors['name_err'] = 'Please enter the menu name.';
                }

                // Validate Menu Price
                if(empty($menu['price'])){
                    $errors['price_err'] = 'Please enter the menu price.';
                }

                // Make sure errors are empty (There's no errors)
                if(empty($errors['name_err']) && empty($errors['price_err'])){
                    
                    try{
                        $menuId = $this->menuModel->createMenu($menu["name"], $menu["price"]);
                        
                        $this->menuModel->attachDishes($menuId, $dishesIds);
                        
                        flash('success', 'The menu has been created successfully.');
                        redirect('menu');
                    }catch(Exception $e){
                        die('Something went wrong');
                    }
                }
                else{
                    // Load view with errors
                    $this->view("menu/create", $errors);
                }
            }
            else {
                if (user()->isClient()) {
                    redirect("menu");
                }
    
                $dishes = $this->dishModel->getAll();
    
                $this->view("menu/create", $dishes);
            }
        }

        public function delete() {
            if (user()->isClient()) {
                redirect("menu");
            }

            if($_SERVER['REQUEST_METHOD'] == 'POST'){
                $menuId = $_POST['menu_id'];
                $this->menuModel->deleteMenu($menuId);
                flash("success", "Menu has been deleted successfully.");
            }
            redirect("menu");
        }
    }