<?php include("../inc/header.html")?>

<section class="pt-10 pb-20">
    <h1 class="text-3xl font-bold text-center mb-10">Edit Menu</h1>
    <div class="container flex flex-col sm:flex-row justify-center gap-20 sm:gap-14">
        <div class="flex relative justify-center h-96 w-96">
            <img id="menu-image" class="border-[6px] border-secondary rounded-lg" src="../../assets/images/dishes/23808324.jpg" alt="Menu">
            <label for="image" class="cursor-pointer border-[6px] border-secondary rounded-lg absolute w-full h-full bg-[#eee] text-gray-500 flex justify-center items-center">Upload an Image</label>
            <input type="file" id="image" class="hidden" accept="image/gif, image/jpeg, image/png">
        </div>
        <form action="" class="sm:w-1/2">
            <div class="flex flex-col gap-3">
                <div class="flex flex-col gap-1">
                    <label for="name" class="font-bold">Menu Name:</label>
                    <input id="name" type="text" placeholder="Enter the menu name" name="name" class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="price" class="font-bold">Price:</label>
                    <input min="0" id="price" type="number" value="Dessert , Chocolate Mousse, Fresh Fruit" placeholder="Enter the menu price" class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary">
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
                        <input id="dish1" value="Bousfour" data-id="id" class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary" placeholder="Select the dish">
                        <div id="dish1-options" class="hidden overflow-hidden absolute top-[110%] z-10 bg-[#eee] rounded-lg w-full flex-col">
                        </div>
                    </div>
                    <div class="relative flex flex-col gap-1">
                        <label for="dish2" class="font-bold">Dish 2:</label>
                        <input id="dish2" value="Moundor Mong" data-id="id" class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary" placeholder="Select the dish">
                        <div id="dish2-options" class="hidden overflow-hidden absolute top-[110%] z-10 bg-[#eee] rounded-lg w-full flex-col">
                        </div>
                    </div>
                    <div class="relative flex flex-col gap-1">
                        <label for="dish3" class="font-bold">Dish 3:</label>
                        <input id="dish3" value="Maldir nao" data-id="id" class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary" placeholder="Select the dish">
                        <div id="dish3-options" class="hidden overflow-hidden absolute top-[110%] z-10 bg-[#eee] rounded-lg w-full flex-col">
                        </div>
                    </div>
                </div>
            </div>

            <button class="flex mt-6 w-fit items-center gap-3 bg-secondary px-2 py-1 rounded-lg text-based">Update Menu</button>
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

    const dishes = ["Steak RassberyPi", "Bousfour Mongoul", "Akiran Jiran", "Lmhamid weneed"];
    const dishesElementsContainer = document.getElementById("dishes");

    for (let element of dishesElementsContainer.children) {
        inputEvents(element.querySelector("input").id);
    }

    function inputEvents(inputId) {
        const dishInput = document.getElementById(inputId);
        const dishesOptionsContainer = document.getElementById(`${inputId}-options`);

        dishInput.onblur = () => closeOptionsContainer(dishesOptionsContainer, searchDish);
        dishInput.onfocus = () => openOptionsContainer(dishesOptionsContainer, searchDish);
        dishInput.onkeyup = searchDish;

        filterDishesOptions(dishes);
        
        function searchDish(){
            let filteredArray = dishes.filter(dish => dish.toLowerCase().search(dishInput.value.toLowerCase()) != -1);
            filterDishesOptions(filteredArray);
        }

        function filterDishesOptions(array){
            dishesOptionsContainer.innerHTML = "";

            if (array != 0) {
                let lastDish = array[array.length - 1];

                for (let dish of array) {
                    let style = dish == lastDish ? "": "border-b";
                    dishesOptionsContainer.innerHTML += `<span data-id='${dish}' class='cursor-pointer hover:bg-slate-200 px-2 py-1 ${style} border-b-black'>${dish}</span>`;
                }
            } else {
                dishesOptionsContainer.innerHTML = "<span class='px-2 py-1 text-gray-500'>No dishes available</span>";
            }

            const dishesOptions = Array.from(dishesOptionsContainer.children);
            dishesOptions.forEach(option => {
                let menuId = option.getAttribute("data-id");
                let menu = option.textContent;
                if (!menuId) return;

                option.onmousedown = function(){
                    dishInput.value = menu;
                    dishInput.setAttribute("data-id", menuId);
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
                        <input id="dish${num}" class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary" placeholder="Select the dish">
                        <div id="dish${num}-options" class="hidden overflow-hidden absolute top-[110%] z-10 bg-[#eee] rounded-lg w-full flex-col">
                        </div>
                    </div>`;

        return tempDiv.firstElementChild;
    }
</script>

<?php include("../inc/footer.html")?>