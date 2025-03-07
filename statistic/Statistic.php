<?php include("../helper/path.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Statistic - Finance Tracker</title>
    <link rel="stylesheet" href="Statistic.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        .chart-container {
            width: 100%;
            /* Lebar penuh */
            max-width: 780px;
            /* Batasi lebar agar tidak terlalu besar */
            height: auto;
            /* Pastikan proporsi tetap */
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        canvas {
            max-width: 100% !important;
            /* Pastikan tidak lebih lebar dari container */
            max-height: 250px !important;
            /* Batasi tinggi agar tidak memanjang terus */
            margin-right: 70px !important;
        }

        .category-table {
            width: 80%;
            margin: 20px auto;
            background: #fff;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        h4.text-center {
            margin-left: 250px;
        }
    </style>
</head>

<body>
    <main class="container-fluid d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <?php include("Svg.php");
            include("Sidebar.php"); ?>
        </div>

        <!-- Main Content -->
        <div class="content p-4 w-100">
            <h2 class="text-center mb-4">Finance Statistics</h2>

            <!-- Tab Navigation -->
            <ul class="nav nav-tabs mb-4" id="financeTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="income-tab" data-bs-toggle="tab" data-bs-target="#income" type="button" role="tab">Income</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="expense-tab" data-bs-toggle="tab" data-bs-target="#expense" type="button" role="tab">Expense</button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="financeTabsContent">
                <!-- Income Tab -->
                <div class="tab-pane fade show active" id="income" role="tabpanel">
                    <div class="chart-container">
                        <h4 class="text-center">Income by Category</h4>
                        <canvas id="incomeChart"></canvas>
                    </div>

                    <!-- Income Category Table -->
                    <div class="category-table">
                        <h5 class="text-center">Income Breakdown</h5>
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Percentage</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody id="incomeTableBody"></tbody>
                        </table>
                    </div>
                </div>

                <!-- Expense Tab -->
                <div class="tab-pane fade show active" id="expense" role="tabpanel">
                    <div class="chart-container">
                        <h4 class="text-center">Expense by Category</h4>
                        <canvas id="expenseChart"></canvas>
                    </div>

                    <!-- Expense Category Table -->
                    <div class="category-table">
                        <h5 class="text-center">Expense Breakdown</h5>
                        <table class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Percentage</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody id="expenseTableBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Simpan referensi chart agar tidak duplikasi
        let chartInstances = {};

        // Data Sample (Bisa diganti dengan data dari PHP)
        const incomeData = [{
                category: "Salary",
                amount: 5000000
            },
            {
                category: "Freelance",
                amount: 2000000
            },
            {
                category: "Investments",
                amount: 1500000
            }
        ];

        const expenseData = [{
                category: "Food",
                amount: 1200000
            },
            {
                category: "Transport",
                amount: 800000
            },
            {
                category: "Entertainment",
                amount: 500000
            },
            {
                category: "Bills",
                amount: 700000
            }
        ];

        // Menghitung persentase setiap kategori
        function calculatePercentage(data) {
            let total = data.reduce((sum, item) => sum + item.amount, 0);
            return data.map(item => ({
                category: item.category,
                amount: item.amount,
                percentage: ((item.amount / total) * 100).toFixed(1) + "%"
            }));
        }

        // Menampilkan data di tabel
        function populateTable(tableId, data) {
            let tableBody = document.getElementById(tableId);
            if (!tableBody) return; // Cegah error jika elemen tidak ditemukan

            tableBody.innerHTML = "";
            data.forEach(item => {
                let row = `<tr>
            <td>${item.percentage}</td>
            <td>${item.category}</td>
            <td>Rp ${item.amount.toLocaleString()}</td>
        </tr>`;
                tableBody.innerHTML += row;
            });
        }

        // Membuat grafik pie
        function createPieChart(chartId, data) {
            let ctx = document.getElementById(chartId)?.getContext('2d');
            if (!ctx) return; // Cegah error jika elemen tidak ditemukan

            // Hapus grafik lama jika ada
            if (chartInstances[chartId]) {
                chartInstances[chartId].destroy();
            }

            // Buat grafik baru
            chartInstances[chartId] = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: data.map(item => item.category),
                    datasets: [{
                        data: data.map(item => item.amount),
                        backgroundColor: ['#36a2eb', '#ff6384', '#ffce56', '#4bc0c0', '#9966ff']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true, // ✅ Fix agar tinggi tetap proporsional
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    }
                }
            });
        }

        // Jalankan setelah halaman selesai dimuat
        window.onload = function() {
            const incomePercentages = calculatePercentage(incomeData);
            const expensePercentages = calculatePercentage(expenseData);

            populateTable('incomeTableBody', incomePercentages);
            populateTable('expenseTableBody', expensePercentages);

            createPieChart('incomeChart', incomeData);
            createPieChart('expenseChart', expenseData);
        };
    </script>
</body>

</html>