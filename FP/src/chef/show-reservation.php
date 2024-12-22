<?php
    include('../inc/header.php');

    if (!isLoggedIn()) {
        redirect("auth/login");
        return;
    }

    $reservation = getFullReservationById($_GET["id"]);
    if (!$reservation) {
        redirect("reservations");
    }
?>

<section class="pt-10 pb-20">
    <h1 class="text-3xl font-bold text-center mb-10">Reservation Details</h1>
    <div class="container flex flex-col sm:flex-row justify-center gap-20 sm:gap-14">
        <div class="flex justify-center">
            <img class="border-[6px] border-secondary rounded-lg w-96" src=<?= URLROOT . "/images/dishes/23808324.jpg" ?> alt="Menu">
        </div>
        <div class="sm:w-1/2">
            <div class="flex flex-col gap-6">
                <div class="flex flex-col gap-1">
                    <label class="font-bold">Menu:</label>
                    <div class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary"><?= htmlspecialchars($reservation["menu_name"]) ?></div>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="guests" class="font-bold">Number of guests:</label>
                    <div class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary"><?= htmlspecialchars($reservation["number_of_guests"]) ?></div>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="date" class="font-bold">Date of feast:</label>
                    <div class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary"><?= htmlspecialchars($reservation["reservation_date"]) ?></div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include(APPROOT . './inc/footer.php') ?>