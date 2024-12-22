<?php
    include(APPROOT . '/views/inc/header.php');
    $menu = $data["menu"];
    $dishes = $data["dishes"];
?>

<section class="pt-10 pb-20">
    <h1 class="text-3xl font-bold text-center mb-10"><?= htmlspecialchars($menu["name"]) ?></h1>
    <div class="container flex flex-col sm:flex-row justify-center gap-20 sm:gap-14">
        <div class="flex justify-center">
            <img class="border-[6px] border-secondary rounded-lg h-96 w-96" src=<?= URLROOT . "/images/dishes/23808324.jpg" ?> alt="Menu">
        </div>
        <form action="" class="sm:w-1/2">
            <div class="flex flex-col gap-6">
                <div class="flex flex-col gap-1">
                    <label for="dish1" class="font-bold">Price:</label>
                    <div class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary"><?= htmlspecialchars($menu["price"]) ?></div>
                </div>
                <?php
                    foreach($dishes as $i => $dish){
                ?>
                    <div class="flex flex-col gap-1">
                        <label for="dish1" class="font-bold">Dish <?= $i + 1 ?>:</label>
                        <div class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary"><?= htmlspecialchars($dish["name"]) ?></div>
                    </div>
                <?php
                    }
                ?>
            </div>

            <button class="flex mt-8 w-fit items-center gap-3 bg-secondary px-2 py-1 rounded-lg text-based">Reservate Now</button>
        </form>
    </div>
</section>

<?php include(APPROOT . '/views/inc/footer.php') ?>
