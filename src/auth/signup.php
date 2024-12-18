<?php include("../inc/header.html")?>

<div class="bg-white border-2 my-8 mx-auto rounded-lg shadow-lg p-8 w-full max-w-md">
    <h1 class="text-3xl font-bold text-center text-secondary mb-6">Create an Account</h1>
    <p class="text-center text-gray-500 mb-8">Sign up to get started</p>

    <form action="#" method="POST" class="flex flex-col gap-6">
        <div>
            <label for="firstname" class="block text-sm font-semibold text-secondary mb-1">First Name</label>
            <input type="text" id="firstname" name="firstname" class="w-full px-4 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-primary" placeholder="Enter your first name" required>
        </div>
        <div>
            <label for="lastname" class="block text-sm font-semibold text-secondary mb-1">Last Name</label>
            <input type="text" id="lastname" name="lastname" class="w-full px-4 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-primary" placeholder="Enter your last name" required>
        </div>
        <div>
            <label for="email" class="block text-sm font-semibold text-secondary mb-1">Email Address</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-primary" placeholder="Enter your email" required>
        </div>
        <div>
            <label for="password" class="block text-sm font-semibold text-secondary mb-1">Password</label>
            <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-primary" placeholder="Enter your password" required>
        </div>
        <div>
            <label for="confirm-password" class="block text-sm font-semibold text-secondary mb-1">Confirm Password</label>
            <input type="password" id="confirm-password" name="confirm-password" class="w-full px-4 py-2 border rounded-lg outline-none focus:ring-2 focus:ring-primary" placeholder="Confirm your password" required>
        </div>

        <button type="submit" class="w-full bg-primary text-white py-2 rounded-lg font-semibold hover:bg-opacity-90">Sign Up</button>
    </form>

    <p class="text-center text-sm text-gray-500 mt-6">
        Already have an account?
        <a href="#" class="text-primary hover:underline">Sign Up</a>
    </p>
</div>

<?php include("../inc/footer.html")?>