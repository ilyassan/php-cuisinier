<?php include(APPROOT . '/views/inc/header.php') ?>

<div class="bg-white border-2 my-8 mx-auto rounded-lg shadow-lg p-8 w-full max-w-md">
    <h1 class="text-3xl font-bold text-center text-secondary mb-6">Create an Account</h1>
    <p class="text-center text-gray-500 mb-8">Sign up to get started</p>

    <form id="signup-form" action=<?= URLROOT . '/users/signup'?> method="POST" class="flex flex-col gap-6">

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
        <a href=<?= URLROOT . '/auth/login' ?> class="text-primary hover:underline">Log In</a>
    </p>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById("signup-form").addEventListener("submit", function(event) {
        return;
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

        Swal.fire("Success", "Your account has been created successfully!", "success");
        setTimeout(() => {
            this.submit();
        }, 1200);
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

<?php include(APPROOT . '/views/inc/footer.php') ?>
