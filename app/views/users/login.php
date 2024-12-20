<?php include(APPROOT . '/views/inc/header.php') ?>

<div class="bg-white border-2 my-8 mx-auto rounded-lg shadow-lg p-8 w-full max-w-md">
    <h1 class="text-3xl font-bold text-center text-secondary mb-6">Welcome Back!</h1>
    <p class="text-center text-gray-500 mb-8">Log in to your account</p>

    <form id="login-form" action=<?= URLROOT . '/users/login'?> method="POST" class="flex flex-col gap-6">
        <div>
            <label for="email" class="block text-sm font-semibold text-secondary mb-1">Email Address</label>
            <input autocomplete="off" type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-primary" placeholder="Enter your email">
        </div>
        <div>
            <label for="password" class="block text-sm font-semibold text-secondary mb-1">Password</label>
            <input autocomplete="off" type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-primary" placeholder="Enter your password">
        </div>

        <div class="flex items-center justify-between">
            <a href="#" class="text-sm text-primary hover:underline">Forgot Password?</a>
        </div>

        <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg font-semibold hover:bg-opacity-90">Log In</button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-6">
        Don’t have an account?
        <a href=<?= URLROOT . '/users/signup' ?> class="text-primary hover:underline">Sign Up</a>
    </p>
</div>

<script>
    document.getElementById("login-form").addEventListener("submit", function(event) {
        event.preventDefault();

        const email = document.getElementById("email").value.trim();
        const password = document.getElementById("password").value;

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!email || !password) {
            Swal.fire("Error", "All fields are required!", "error");
            return;
        }

        if (!emailRegex.test(email)) {
            Swal.fire("Error", "Please enter a valid email address!", "error");
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

<?php include(APPROOT . '/views/inc/footer.php') ?>
