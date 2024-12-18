<?php include("../inc/header.html")?>

<div class="bg-white border-2 my-8 mx-auto rounded-lg shadow-lg p-8 w-full max-w-md">
    <h1 class="text-3xl font-bold text-center text-secondary mb-6">Welcome Back!</h1>
    <p class="text-center text-gray-500 mb-8">Log in to your account</p>

    <form action="#" method="POST" class="flex flex-col gap-6">
        <div>
            <label for="email" class="block text-sm font-semibold text-secondary mb-1">Email Address</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-primary" placeholder="Enter your email" required>
        </div>
        <div>
            <label for="password" class="block text-sm font-semibold text-secondary mb-1">Password</label>
            <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-primary" placeholder="Enter your password" required>
        </div>

        <div class="flex items-center justify-between">
            <a href="#" class="text-sm text-primary hover:underline">Forgot Password?</a>
        </div>

        <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg font-semibold hover:bg-opacity-90">Log In</button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-6">
        Don’t have an account?
        <a href="#" class="text-primary hover:underline">Sign Up</a>
    </p>
</div>


<?php include("../inc/footer.html")?>