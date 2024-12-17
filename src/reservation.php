<?php include("./inc/header.html")?>

<section class="pt-10 pb-20">
    <h1 class="text-3xl font-bold text-center mb-10">Reservation Details</h1>
    <div class="container flex flex-col sm:flex-row justify-center gap-20 sm:gap-14">
        <div class="flex justify-center">
            <img class="border-[6px] border-secondary rounded-lg w-96" src="../assets/images/dishes/23808324.jpg" alt="Menu">
        </div>
        <div class="sm:w-1/2">
            <div class="flex flex-col gap-6">
                <div class="flex flex-col gap-1">
                    <label class="font-bold">Menu:</label>
                    <div class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary">Steak RassberyPi Mondoro</div>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="guests" class="font-bold">Number of guests:</label>
                    <div class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary">7</div>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="date" class="font-bold">Date of feast:</label>
                    <div class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary">5/12/2024</div>
                </div>
            </div>

            <div class="flex gap-5">
                <a class="flex cursor-pointer mt-8 w-fit items-center gap-3 bg-tertiary px-2 py-1 rounded-lg text-based">Edit</a>
                <button class="flex cursor-pointer mt-8 w-fit items-center gap-3 bg-gray-400 px-2 py-1 rounded-lg text-based">Cancel</button>
            </div>
        </div>
    </div>
</section>

<?php include("./inc/footer.html")?>