<?php include("../inc/header.php")?>


<section class="pt-10 pb-20">
    <h1 class="text-3xl font-bold text-center mb-10">Your Reservations</h1>

    <div class="container">
        <div class="text-lg mb-2">Filter:</div>
        <input id="search" type="text" class="bg-[#eee] rounded-lg mb-10 py-1 outline-none px-3" placeholder="Search by menu, date, state">
    </div>
    <div class="container relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-secondary dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Menu Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Reservation Time
                    </th>
                    <th scope="col" class="px-6 py-3">
                        State
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Price
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Steak RassberyPi
                    </th>
                    <td class="px-6 py-4">
                        12/5/2022 At 18:00
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded-lg">Pending</span>
                    </td>
                    <td class="px-6 py-4">
                        $2999
                    </td>
                    <td class="flex px-6 py-4">
                        <span class="bg-tertiary text-based px-2 py-1 rounded-lg cursor-pointer mr-5">Edit</span>
                        <span class="bg-gray-400 text-based px-2 py-1 rounded-lg cursor-pointer">Cacel</span>
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Steak RassberyPi
                    </th>
                    <td class="px-6 py-4">
                        12/5/2022 At 19:00
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded-lg">Pending</span>
                    </td>
                    <td class="px-6 py-4">
                        $2999
                    </td>
                    <td class="flex px-6 py-4">
                        <span class="bg-tertiary text-based px-2 py-1 rounded-lg cursor-pointer mr-5">Edit</span>
                        <span class="bg-gray-400 text-based px-2 py-1 rounded-lg cursor-pointer">Cacel</span>
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Steak RassberyPi
                    </th>
                    <td class="px-6 py-4">
                        12/5/2023 At 18:00
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded-lg">Pending</span>
                    </td>
                    <td class="px-6 py-4">
                        $2999
                    </td>
                    <td class="flex px-6 py-4">
                        <span class="bg-tertiary text-based px-2 py-1 rounded-lg cursor-pointer mr-5">Edit</span>
                        <span class="bg-gray-400 text-based px-2 py-1 rounded-lg cursor-pointer">Cacel</span>
                    </td>
                </tr>
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        Steak RassberyPi
                    </th>
                    <td class="px-6 py-4">
                        2/5/2022 At 18:00
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded-lg">Pending</span>
                    </td>
                    <td class="px-6 py-4">
                        $2999
                    </td>
                    <td class="flex px-6 py-4">
                        <span class="bg-tertiary text-based px-2 py-1 rounded-lg cursor-pointer mr-5">Edit</span>
                        <span class="bg-gray-400 text-based px-2 py-1 rounded-lg cursor-pointer">Cacel</span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<script>
    const searchInput = document.getElementById("search");
    const reservationsElements = Array.from(document.querySelector("tbody").children);

    reservationsElements.sort((a, b) => {
        const dateA = a.querySelector("td").textContent.trim();
        const dateB = b.querySelector("td").textContent.trim();

        const parsedDateA = new Date(formatDateToISO(dateA));
        const parsedDateB = new Date(formatDateToISO(dateB));

        return parsedDateA - parsedDateB;
    });

    const tbody = document.querySelector("tbody");
    tbody.innerHTML = "";
    reservationsElements.forEach(row => tbody.appendChild(row));

    function formatDateToISO(dateStr) {
        const [datePart, timePart] = dateStr.split(" At ");
        const [month, day, year] = datePart.split("/").map(Number);
        return `${year}-${month.toString().padStart(2, "0")}-${day.toString().padStart(2, "0")}T${timePart}`;
    }


    searchInput.onkeyup = function() {
        reservationsElements.forEach(ele => {
            if(ele.querySelector("th").textContent.toLowerCase().search(searchInput.value.toLowerCase()) != -1){
                ele.classList.remove("hidden");
            }else{
                ele.classList.add("hidden");
            }
        });
    };
</script>

<?php include("../inc/footer.php")?>
