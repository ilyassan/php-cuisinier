<?php
    include(APPROOT . '/views/inc/header.php');
    $pendingReservationsCount = $data['pendingReservationsCount'];
    $todayConfirmedReservationsCount = $data['todayConfirmedReservationsCount'];
    $tommorowConfirmedReservationsCount = $data['tommorowConfirmedReservationsCount'];
    $clientsCount = $data['clientsCount'];
    $nextReservation = $data['nextReservation'];
    $reservationsRecievedInLastWeek = $data['reservationsRecievedInLastWeek'];
?>


<section class="bg-gray-100 min-h-screen pt-10 pb-20">
    <h1 class="text-3xl font-bold text-center mb-10">Dashboard</h1>

    <div class="container grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mx-auto">
        <div class="flex w-full flex-col gap-2 border rounded-lg border-gray-500 text-gray-600 p-5 bg-yellow-50">
            <div class="flex w-full text-xl items-center gap-3">
                <i class="fa-solid fa-calendar-days text-yellow-500"></i>
                <span><?= $pendingReservationsCount ?></span>
            </div>
            <p class="text-xs">Number of the pending reservations</p>
        </div>
        <div class="flex w-full flex-col gap-2 border rounded-lg border-gray-500 text-gray-600 p-5 bg-green-50">
            <div class="flex w-full text-xl items-center gap-3">
                <i class="fa-solid fa-check text-green-600"></i>
                <span><?= $todayConfirmedReservationsCount ?></span>
            </div>
            <p class="text-xs">Number of the confirmed reservations of today</p>
        </div>
        <div class="flex w-full flex-col gap-2 border rounded-lg border-gray-500 text-gray-600 p-5 bg-red-50">
            <div class="flex w-full text-xl items-center gap-3">
                <i class="fa-solid fa-check-double text-red-600"></i>
                <span><?= $tommorowConfirmedReservationsCount ?></span>
            </div>
            <p class="text-xs">Number of the confirmed reservations of tommorow</p>
        </div>
        <div class="flex w-full flex-col gap-2 border rounded-lg border-gray-500 text-gray-600 p-5 bg-blue-50">
            <div class="flex w-full text-xl items-center gap-3">
                <i class="fa-solid fa-users text-blue-600"></i>
                <span><?= $clientsCount ?></span>
            </div>
            <p class="text-xs">Number of the clients</p>
        </div>
    </div>

    <div class="container flex flex-col lg:flex-row items-center lg:items-start justify-between gap-6 mx-auto my-6 px-4">
        <div>
            <h3 class="text-gray-700 text-xl font-semibold mb-4 flex items-center">
                Next Client <i class="fa-solid fa-arrow-right ml-2"></i>
            </h3>
            
            <div class="w-fit items-center bg-white shadow-lg rounded-lg p-6 flex flex-col gap-6">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center text-2xl text-gray-600">
                        <i class="fa-solid fa-user"></i>
                    </div>
                </div>

                <div class="flex-1 text-center md:text-left">
                    <h4 class="text-lg font-semibold text-gray-800 mb-2"><?= htmlspecialchars($nextReservation->client_name) ?></h4>
                    <p class="text-sm text-gray-600 mb-1 flex items-center justify-center md:justify-start">
                        <span>Menu:</span> <span class="font-medium ml-1"><?= htmlspecialchars($nextReservation->menu_name) ?></span>
                    </p>
                    <p class="text-sm text-gray-600 mb-1 flex items-center justify-center md:justify-start">
                        <span>Guests:</span> <span class="font-medium ml-1"><?= htmlspecialchars($nextReservation->number_of_guests) ?></span>
                    </p>
                    <p class="text-sm text-gray-600 flex items-center justify-center md:justify-start">
                        <span>Price:</span> <span class="font-medium ml-1">$<?= htmlspecialchars($nextReservation->price) ?></span>
                    </p>
                </div>

                <div class="flex-shrink-0 mt-4 md:mt-0">
                    <a href=<?= URLROOT. "/reservations/show/". $nextReservation->id ?> class="bg-tertiary text-white font-semibold py-1 px-4 rounded-lg shadow">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        <div class="flex justify-end flex-1 w-11/12">
            <canvas id="ordersChart" class="w-full h-64"></canvas>
        </div>
    </div>

</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ordersChart').getContext('2d');
    const ordersChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            datasets: [{
                label: 'Number of Orders',
                data: [...<?= json_encode(array_values($reservationsRecievedInLastWeek)) ?>].map(day => day.count),
                backgroundColor: [
                    '#f87171', '#fb923c', '#facc15', '#4ade80', '#2dd4bf', '#60a5fa', '#818cf8'
                ],
                borderWidth: 1,
                borderColor: '#ddd'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Orders Received in the Last Week',
                    font: { size: 16 }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 5 }
                },
                x: {
                    ticks: { font: { size: 12 } }
                }
            }
        }
    });
</script>

<?php include(APPROOT . '/views/inc/footer.php')?>
