<?php
    include('../inc/header.php');
    
    if (!isLoggedIn()) {
        redirect("auth/login");
        return;
    }
    
    $data = getAllMenus();
?>

<section class="relative">
    <img class="max-h-[80vh] min-h-[35vh] object-cover w-full" src="<?= htmlspecialchars(URLROOT . "/images/steak.webp", ENT_QUOTES, 'UTF-8') ?>" alt="Steak">
    <div class="flex justify-center items-center absolute w-full h-full left-0 top-0 bg-secondary bg-opacity-80">
        <div class="container flex mb-6 mx-auto flex-col gap-6 justify-center items-center">
            <h1 class="text-primary font-lux text-4xl">DINOUS</h1>
            <p class="text-based text-center text-lg">Chef Ilyass brings gourmet cuisine and unforgettable flavors straight to your table. With personalized menus and exceptional quality, every dish tells a story of passion, precision, and elegance.</p>
        </div>
    </div>
</section>

<section class="py-8">
    <h1 class="text-3xl font-bold text-center mb-12">Menus</h1>
    <div class="container flex justify-end">
        <a href="<?= './create-menu.php' ?>" class="block w-fit mb-6 bg-tertiary px-4 py-1 text-based rounded-lg">Create New Menu <i class="fa-regular fa-plus"></i></a>
        </div>
        <div class="container grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-10 gap-y-4 place-items-center">
        <?php
            foreach ($data as $menu) {
        ?>
            <a href="<?= './show-menu.php?id=' . $menu["id"] ?>" class="bg-tertiary rounded-lg pb-3 px-2 pt-2 max-w-80">
            <img class="border-tertiary rounded-xl" src="<?= URLROOT . "/images/dishes/23808324.jpg" ?>" alt="Dish">
            <p class="text-2xl text-center mb-1 mt-2.5 font-bold text-based"><?= htmlspecialchars($menu["name"]) ?></p>
            <div class="flex text-2xl lg:text-xl justify-between">
            <span class="text-based"><?= htmlspecialchars($menu["price"]) ?>$</span>
            <span class="text-primary cursor-pointer"><i class="fa-solid fa-check-to-slot"></i></span>
            </div>
            </a>
        <?php
            }
            ?>
        </div>

        <a href="<?= './create-menu.php' ?>" class="block w-fit mt-10 mx-auto bg-tertiary px-4 py-1 text-based rounded-lg">Create New Menu <i class="fa-regular fa-plus"></i></a>
</section>

<?php include(APPROOT . './inc/footer.php')?>