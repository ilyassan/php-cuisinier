<?php include("./inc/header.html")?>

<section class="pt-10 pb-20">
    <h1 class="text-3xl font-bold text-center mb-10">Request a Reservation</h1>
    <div class="container flex flex-col sm:flex-row justify-center gap-20 sm:gap-14">
        <div class="flex justify-center">
            <img class="border-[6px] border-secondary rounded-lg w-96" src="../assets/images/dishes/23808324.jpg" alt="Menu">
        </div>
        <form action="" class="sm:w-1/2">
            <div class="flex flex-col gap-6">
                <div class="relative flex flex-col gap-1">
                    <label for="menu-input" class="font-bold">Menu:</label>
                    <input id="menu-input" type="text" class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary" placeholder="Select a menu">
                    <div id="menus" class="hidden overflow-hidden absolute top-[110%] z-10 bg-[#eee] rounded-lg w-full flex-col">
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <label for="guests" class="font-bold">Number of guests:</label>
                    <input id="guests" type="number" class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary" min="1" placeholder="Number of guests">
                </div>
                <div class="flex flex-col gap-1">
                    <label for="date" class="font-bold">Date of feast:</label>
                    <input id="date" type="date" class="bg-[#eee] rounded-md px-2 py-1.5 outline-tertiary">
                </div>
            </div>


            <button class="flex mt-8 w-fit items-center gap-3 bg-secondary px-2 py-1 rounded-lg text-based">Reservate <i class="fa-solid fa-check-to-slot"></i></button>
        </form>
    </div>
</section>

<script>
        const menus = ["Steak RassberyPi", "Bousfour Mongoul", "Akiran Jiran", "Lmhamid weneed"];

        const menuInput = document.getElementById("menu-input");
        const menusOptionsContainer = document.getElementById("menus");

        menuInput.onblur = () => closeOptionsContainer(menusOptionsContainer, searchMenu);
        menuInput.onfocus = () => openOptionsContainer(menusOptionsContainer, searchMenu);
        menuInput.onkeyup = searchMenu;

        filterMenusOptions(menus);
        
        function searchMenu(){
            let filteredArray = menus.filter(menu => menu.toLowerCase().search(menuInput.value.toLowerCase()) != -1);
            filterMenusOptions(filteredArray);
        }

        function filterMenusOptions(array){
            menusOptionsContainer.innerHTML = "";

            if (array != 0) {
                let lastMenu = array[array.length - 1];

                for (let menu of array) {
                    let style = menu == lastMenu ? "": "border-b";
                    menusOptionsContainer.innerHTML += `<span data-id='${menu}' class='cursor-pointer hover:bg-slate-200 px-2 py-1 ${style} border-b-black'>${menu}</span>`;
                }
            } else {
                menusOptionsContainer.innerHTML = "<span class='px-2 py-1 text-gray-500'>No menus available</span>";
            }

            const menusOptions = Array.from(menusOptionsContainer.children);
            menusOptions.forEach(option => {
                let menuId = option.getAttribute("data-id");
                let menu = option.textContent;
                if (!menuId) return;

                option.onmousedown = function(){
                    menuInput.value = menu;
                    menuInput.setAttribute("data-id", menuId);
                }
            });
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
</script>

<?php include("./inc/footer.html")?>