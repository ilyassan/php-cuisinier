<?php include("./inc/header.html")?>

<section class="pt-10 pb-20">
    <h1 class="text-3xl font-bold text-center mb-10">Conor Rassbery</h1>
    <div class="container flex flex-col sm:flex-row justify-center gap-20 sm:gap-14">
        <div class="flex justify-center">
            <img class="border-[6px] border-secondary rounded-lg w-96" src="../assets/images/dishes/23808324.jpg" alt="Menu">
        </div>
        <form action="" class="sm:w-1/2">
            <div class="flex flex-col gap-6">
                <div class="flex flex-col gap-1">
                    <label for="dish1" class="font-bold">Dish 1:</label>
                    <div class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary">Wagyu Beef Steak, BBC Sauce, Roasted Vegetables</div>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="dish2" class="font-bold">Dish 2:</label>
                    <div class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary">Salad , Grilled Chicken, Balsamic Vinaigrette</div>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="dish3" class="font-bold">Dish 3:</label>
                    <div class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary">Dessert , Chocolate Mousse, Fresh Fruit</div>
                </div>
            </div>


            <button class="flex mt-8 w-fit items-center gap-3 bg-secondary px-2 py-1 rounded-lg text-based">Reservate Now <i class="fa-solid fa-check-to-slot"></i></button>
        </form>
    </div>
</section>

<?php include("./inc/footer.html")?>