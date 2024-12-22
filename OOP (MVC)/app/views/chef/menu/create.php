<?php include(APPROOT . '/views/inc/header.php')?>

<section class="pt-10 pb-20">
    <h1 class="text-3xl font-bold text-center mb-10">Create Menu</h1>
    <div class="container flex flex-col sm:flex-row justify-center gap-20 sm:gap-14">
        <div class="flex relative justify-center h-96 w-96">
            <img id="menu-image" class="border-[6px] border-secondary rounded-lg" src="../../assets/images/dishes/23808324.jpg" alt="Menu">
            <label for="image" class="cursor-pointer border-[6px] border-secondary rounded-lg absolute w-full h-full bg-[#eee] text-gray-500 flex justify-center items-center">Upload an Image</label>
            <input type="file" id="image" class="hidden" accept="image/gif, image/jpeg, image/png">
        </div>
        <form id="menu-form" action="<?= htmlspecialchars(URLROOT . '/menus/create') ?>" method="POST" class="sm:w-1/2">
            <div class="flex flex-col gap-3">
                <div class="flex flex-col gap-1">
                    <label for="name" class="font-bold">Menu Name:</label>
                    <input autocomplete="off" id="name" type="text" placeholder="Enter the menu name" name="name" class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="price" class="font-bold">Price:</label>
                    <input autocomplete="off" name="price" min="0" step="0.1" id="price" type="number" placeholder="Enter the menu price" class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary">
                </div>
                <div id="dishes" class="flex flex-col gap-3">
                    <div class="relative flex flex-col gap-1">
                        <div class="flex justify-between">
                            <label for="dish1" class="font-bold">Dish 1:</label>
                            <div class="flex gap-5 text-tertiary text-2xl">
                                <i id="remove-dish" class="cursor-pointer fa-solid fa-minus"></i>
                                <i id="add-dish" class="cursor-pointer fa-solid fa-plus"></i>
                            </div>
                        </div>
                        <input autocomplete="off" id="dish1" class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary" placeholder="Select the dish">
                        <input type="hidden" id="dish1-id" name="dish1">
                        <div id="dish1-options" class="hidden overflow-hidden absolute top-[110%] z-10 bg-[#eee] rounded-lg w-full flex-col">
                        </div>
                    </div>
                </div>
            </div>

            <button class="flex mt-6 w-fit items-center gap-3 bg-secondary px-2 py-1 rounded-lg text-based">Create Menu</button>
        </form>
    </div>
</section>

<script>
    const label = document.querySelector("[for='image']");
    const imageInput = document.getElementById("image");
    const imageElement = document.getElementById("menu-image");

    imageInput.onchange = () => {
        if (imageInput.files && imageInput.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                imageElement.src = e.target.result;
                label.classList.add("opacity-0");
            };

            reader.readAsDataURL(imageInput.files[0]);
        }
    };

    const dishes = <?= json_encode($data) ?>;
    
    const dishesElementsContainer = document.getElementById("dishes");

    for (let element of dishesElementsContainer.children) {
        inputEvents(element.querySelector("input").id);
    }

    function inputEvents(inputId) {
        const dishInput = document.getElementById(inputId);
        const dishIdInput = document.getElementById(`${inputId}-id`);
        const dishesOptionsContainer = document.getElementById(`${inputId}-options`);

        dishInput.onblur = () => closeOptionsContainer(dishesOptionsContainer, searchDish);
        dishInput.onfocus = () => openOptionsContainer(dishesOptionsContainer, searchDish);
        dishInput.onkeyup = searchDish;

        filterDishesOptions(dishes);
        
        function searchDish(){
            let filteredArray = dishes.filter(dish => dish["name"].toLowerCase().search(dishInput.value.toLowerCase()) != -1);
            filterDishesOptions(filteredArray);
        }

        function filterDishesOptions(array){
            dishesOptionsContainer.innerHTML = "";

            if (array != 0) {
                let lastDish = array[array.length - 1];

                for (let dish of array) {
                    let style = dish == lastDish ? "": "border-b";
                    dishesOptionsContainer.innerHTML += `<span data-id='${dish["id"]}' class='cursor-pointer hover:bg-slate-200 px-2 py-1 ${style} border-b-black'>${htmlspecialchars(dish["name"])}</span>`;
                }
            } else {
                dishesOptionsContainer.innerHTML = "<span class='px-2 py-1 text-gray-500'>No dishes available</span>";
            }

            const dishesOptions = Array.from(dishesOptionsContainer.children);
            dishesOptions.forEach(option => {
                let dishId = option.getAttribute("data-id");
                let dishName = option.textContent;
                if (!dishId) return;

                option.onmousedown = function(){
                    dishInput.value = dishName;
                    dishInput.setAttribute("data-id", dishId);
                    dishIdInput.value = dishId;
                }
            });
        }
    }

    function closeOptionsContainer(element, func) {
        func();
        element.classList.add("hidden");
        element.classList.remove("flex");
    }
    function openOptionsContainer(element, func) {
        func();
        element.classList.remove("hidden");
        element.classList.add("flex");
    }
    
    document.getElementById("add-dish").onclick = function(){
        let inputNumber = dishesElementsContainer.children.length + 1;
        dishesElementsContainer.appendChild(dishInputElement(inputNumber));
        inputEvents("dish" + inputNumber);
    }
    document.getElementById("remove-dish").onclick = function(){
        let inputNumber = dishesElementsContainer.children.length;
        if (inputNumber == 1) return;
        dishesElementsContainer.removeChild(dishesElementsContainer.lastChild);
    }


    function dishInputElement(num) {
        let tempDiv = document.createElement("div");
        tempDiv.innerHTML = `
                    <div class="relative flex flex-col gap-1">
                        <label for="dish${num}" class="font-bold">Dish ${num}:</label>
                        <input autocomplete="off" id="dish${num}" class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary" placeholder="Select the dish">
                        <input type="hidden" name="dish${num}" id="dish${num}-id">
                        <div id="dish${num}-options" class="hidden overflow-hidden absolute top-[110%] z-10 bg-[#eee] rounded-lg w-full flex-col">
                        </div>
                    </div>`;

        return tempDiv.firstElementChild;
    }


    document.getElementById("menu-form").addEventListener("submit", function(e) {
        e.preventDefault();

        const menuName = document.getElementById("name").value.trim();
        const menuPrice = document.getElementById("price").value.trim();
        
        const dishesIds = Array.from(dishesElementsContainer.querySelectorAll("input[type='hidden']")).map(input => input.value);

        const menuNameRegex = /^[A-Za-z]+$/; // No special characters
        const minPrice = 0;

        if (!menuName || !menuPrice) {
            Swal.fire("Error", "All fields are required!", "error");
            return;
        }

        for (let dishId of dishesIds) {
            if (!dishId) {
                Swal.fire("Error", "Please select the menu dishes!", "error");
                return;
            }   
        }

        if (!menuNameRegex.test(menuName)) {
            Swal.fire("Error", "Menu name must only contain letters!", "error");
            return;
        }

        if (!parseFloat(menuPrice)) {
            Swal.fire("Error", "Please enter a valid price!", "error");
            return;
        }

        if (parseFloat(menuPrice) < minPrice) {
            Swal.fire("Error", "Price must be at positive number!", "error");
            return;
        }

        this.submit();
    });
</script>

<?php include(APPROOT . '/views/inc/footer.php')?>