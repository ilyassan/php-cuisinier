<?php
    include('./inc/header.php');
    if (!isLoggedIn()) {
        redirect("auth/login");
        return;
    }

    $data = [];

    if (user()->isChef()) {
        $data = getAllReservationsWithMenuAndClient();
    }else{
        $data = getReservationsOfUser(user()->getId());
    }
?>


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
                <?php
                    foreach ($data as $reservation) {
                ?>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                           <?= htmlspecialchars($reservation["menu_name"]) ?>
                        </th>
                        <td class="px-6 py-4">
                            <?= htmlspecialchars($reservation["reservation_date"]) ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php
                                $class = "px-2 py-1 rounded-lg ";
                                if ($reservation["status"] == "pending") {
                                    $class .= "bg-yellow-100 text-yellow-600";
                                }elseif($reservation["status"] == "declined"){
                                    $class .= "bg-red-100 text-red-600";
                                }else{
                                    $class .= "bg-green-100 text-green-600";
                                }
                                ?>
                            <span class="<?= $class ?>">
                                <?= htmlspecialchars(ucfirst($reservation["status"])) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            $<?= htmlspecialchars($reservation["price"]) ?>
                        </td>
                        <td class="flex items-center px-6 py-4">
                            <a href=<?= URL . '/edit-reservation.php?id='. $reservation["id"]?> class="bg-tertiary text-based px-2 py-1 rounded-lg cursor-pointer mr-5">Edit</a>
                            <form class="m-0" action=<?= URL. "/delete-reservation.php?id=" . $reservation["id"] ?> method="POST">
                                <button class="bg-gray-400 text-based px-2 py-1 rounded-lg cursor-pointer">Cancel</button>
                            </form>
                        </td>
                    </tr>
                <?php
                    }
                ?>
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

        const parsedDateA = new Date(dateA.replace(/-/g, '/'));
        const parsedDateB = new Date(dateB.replace(/-/g, '/'));

        return parsedDateA - parsedDateB;
    });

    const tbody = document.querySelector("tbody");
    tbody.innerHTML = "";
    reservationsElements.forEach(row => tbody.appendChild(row));

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

<?php include(APPROOT . './inc/footer.php')?>
