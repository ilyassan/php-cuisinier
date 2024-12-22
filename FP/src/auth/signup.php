<?php
    include('../inc/header.php');

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        // Sanitize POST data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'first_name' => trim($_POST['firstname']),
            'last_name' => trim($_POST['lastname']),
            'email' => trim($_POST['email']),
            'password' => trim($_POST['password']),
            'confirm_password' => trim($_POST['confirm-password'])
        ];
        $errors = [
            'firstname_err' => '',
            'lastname_err' => '',
            'email_err' => '',
            'password_err' => '',
            'confirm_password_err' => ''
        ];

        // Validate First Name
        if(empty($data['first_name'])){
            $errors['firstname_err'] = 'Please enter your first name.';
        }

        // Validate Last Name
        if(empty($data['last_name'])){
            $errors['lastname_err'] = 'Please enter your last name.';
        }
        
        // Validate Email
        if(empty($data['email'])){
            $errors['email_err'] = 'Please enter email.';
        }elseif(findUserByEmail($data['email'])){
            $errors['email_err'] = 'Email is already used.';
        }

        // Validate Password
        if(empty($data['password'])){
            $errors['password_err'] = 'Please enter password.';
        }elseif(strlen($data['password']) < 6){
            $errors['password_err'] = 'Password must be at least 6 characters.';
        }

        // Validate Confirm Password
        if(empty($data['confirm_password'])){
            $errors['confirm_password_err'] = 'Please confirm password';
        }elseif($data['password'] != $data['confirm_password']){
            $errors['confirm_password_err'] = 'Passwords do not match.';
        }

        // Make sure errors are empty (There's no errors)
        if(empty($errors['firstname_err']) && empty($errors['lastname_err']) && empty($errors['email_err']) && empty($errors['password_err']) && empty($errors['confirm_password_err'])){
            // Hash Password
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            // Register user
            if(registerUser($data)){
                // Register success
                flash('success', 'You are registered and can log in.');
                redirect('auth/login');
            }else{
                die('Something went wrong');
            }
        }
        else{
            // Load view with errors
            flash("error", array_values($errors)[0]);
        }
    }
?>

<div class="bg-white border-2 my-8 mx-auto rounded-lg shadow-lg p-8 w-full max-w-md">
    <h1 class="text-3xl font-bold text-center text-secondary mb-6">Create an Account</h1>
    <p class="text-center text-gray-500 mb-8">Sign up to get started</p>

    <form id="signup-form" action="" method="POST" class="flex flex-col gap-6">

        <div>
            <label for="firstname" class="block text-sm font-semibold text-secondary mb-1">First Name</label>
            <input autocomplete="off" type="text" id="firstname" name="firstname" class="w-full px-4 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-primary" placeholder="Enter your first name">
        </div>
        
        <div>
            <label for="lastname" class="block text-sm font-semibold text-secondary mb-1">Last Name</label>
            <input autocomplete="off" type="text" id="lastname" name="lastname" class="w-full px-4 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-primary" placeholder="Enter your last name">
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-secondary mb-1">Email Address</label>
            <input autocomplete="off" type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-primary" placeholder="Enter your email">
        </div>
        
        <div>
            <label for="password" class="block text-sm font-semibold text-secondary mb-1">Password</label>
            <input autocomplete="off" type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-primary" placeholder="Enter your password">
        </div>
        
        <div>
            <label for="confirm-password" class="block text-sm font-semibold text-secondary mb-1">Confirm Password</label>
            <input autocomplete="off" type="password" id="confirm-password" name="confirm-password" class="w-full px-4 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-primary" placeholder="Confirm your password">
        </div>

        <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg font-semibold hover:bg-opacity-90">Sign Up</button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-6">
        Already have an account?
        <a href=<?= URL . '/auth/login.php' ?> class="text-primary hover:underline">Log In</a>
    </p>
</div>

<script>
    document.getElementById("signup-form").addEventListener("submit", function(event) {
        event.preventDefault();

        const firstName = document.getElementById("firstname").value.trim();
        const lastName = document.getElementById("lastname").value.trim();
        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirm-password").value;

        const nameRegex = /^[A-Za-z]+$/; // No special characters
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Vald email format
        const passwordMinLength = 8;

        if (!firstName || !lastName || !email || !password || !confirmPassword) {
            Swal.fire("Error", "All fields are required!", "error");
            return;
        }

        if (!nameRegex.test(firstName) || !nameRegex.test(lastName)) {
            Swal.fire("Error", "First name and last name must only contain letters!", "error");
            return;
        }

        if (!emailRegex.test(email)) {
            Swal.fire("Error", "Please enter a valid email address!", "error");
            return;
        }

        if (password.length < passwordMinLength) {
            Swal.fire("Error", "Password must be at least 8 characters long!", "error");
            return;
        }

        if (password !== confirmPassword) {
            Swal.fire("Error", "Passwords do not match!", "error");
            return;
        }
        
        this.submit();
    });
</script>

<script>
    let errors = <?= isset($data) ? json_encode($data) : '[]'; ?>;

    for(let errorMessage of Object.values(errors)){
        if (errorMessage != "") {
            Swal.fire("Error", errorMessage, "error");
            break;
        }
    }
</script>

<?php include(APPROOT . './inc/footer.php') ?>
