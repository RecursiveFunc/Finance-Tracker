<?php include("../helper/path.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Transactions - Finance Tracker</title>
    <link rel="stylesheet" href="Transaction.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <main class="container-fluid d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <?php
            include("Svg.php");
            include("Sidebar.php");
            ?>
        </div>

        <!-- Konten Utama -->
        <div class="content p-4 w-100">
            <!-- Navigasi Bulan & Tahun -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a class="left-arrow" id="prevMonth">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                    </svg>
                </a>
                <h4 id="currentMonth">February 2025</h4>
                <a class="right-arrow" id="nextMonth">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                    </svg>
                </a>
            </div>

            <!-- Section Daily Transactions -->
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Daily Transactions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Income -->
                        <div class="col-md-4">
                            <div class="card summary-card income-card shadow-sm">
                                <div class="card-body">
                                    <h6 class="card-title">Income</h6>
                                    <p class="fs-4 text-primary" id="incomeAmount">Rp 0</p>
                                </div>
                            </div>
                        </div>
                        <!-- Expenses -->
                        <div class="col-md-4">
                            <div class="card summary-card expense-card shadow-sm">
                                <div class="card-body">
                                    <h6 class="card-title">Expenses</h6>
                                    <p class="fs-4 text-danger" id="expenseAmount">Rp 0</p>
                                </div>
                            </div>
                        </div>
                        <!-- Total -->
                        <div class="col-md-4">
                            <div class="card summary-card total-card shadow-sm">
                                <div class="card-body">
                                    <h6 class="card-title">Total</h6>
                                    <p class="fs-4 text-success" id="totalAmount">Rp 0</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Section Transaction List -->
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="mb-0">Transaction History</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="transactionTable">
                            <!-- Data akan dimuat di sini menggunakan AJAX -->
                        </tbody>
                    </table>
                </div>
            </div>


            <!-- Floating Add Button -->
            <button id="addTransactionBtn" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="white" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                </svg>
            </button>
    </main>



    <!-- Modal Tambah Transaksi -->
    <div class="modal fade" id="addTransactionModal" tabindex="-1" aria-labelledby="addTransactionModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTransactionModalLabel">Tambah Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="transactionForm">
                        <div class="mb-3">
                            <label for="transactionDate" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="transactionDate" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="accountType" class="form-label">Account</label>
                            <select class="form-control" id="accountType" name="account_id" required>
                                <option value="">Pilih Dompet</option>
                                <?php
                                require_once("../database/dbconn.php");
                                $query = "SELECT id, jenis_tabungan FROM accounts";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$row['id']}'>{$row['jenis_tabungan']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="transactionType" class="form-label">Jenis Transaksi</label>
                            <select class="form-control" id="transactionType" name="type" required>
                                <option value="Income">Income</option>
                                <option value="Expense">Expense</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="transactionCategory" class="form-label">Kategori</label>
                            <select class="form-control" id="transactionCategory" name="category_id" required>
                                <option value="">Pilih Kategori</option>
                                <?php
                                require_once("../database/dbconn.php");
                                $query = "SELECT id, nama_kategori FROM categories";
                                $result = mysqli_query($conn, $query);
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='{$row['id']}'>{$row['nama_kategori']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="transactionAmount" class="form-label">Nominal (Rp)</label>
                            <input type="number" class="form-control" id="transactionAmount" name="nominal" placeholder="Contoh: 500000" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Transaction -->
    <div class="modal fade" id="editTransactionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editTransactionForm">
                        <input type="hidden" id="editTransactionId">
                        <div class="mb-3">
                            <label class="form-label">Nominal (Rp)</label>
                            <input type="number" class="form-control" id="editTransactionAmount">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            let currentDate = new Date();

            function updateMonth() {
                const options = {
                    year: "numeric",
                    month: "long"
                };
                $("#currentMonth").text(currentDate.toLocaleDateString("id-ID", options));
            }

            $("#prevMonth").click(function() {
                currentDate.setMonth(currentDate.getMonth() - 1);
                updateMonth();
            });

            $("#nextMonth").click(function() {
                currentDate.setMonth(currentDate.getMonth() + 1);
                updateMonth();
            });

            updateMonth();
        });
    </script>

    <script>
        $(document).ready(function() {
            function loadTransactions() {
                $.ajax({
                    url: "ReadTransaction.php",
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        let rows = "";
                        if (data.length === 0) {
                            rows = `<tr><td colspan="5" class="text-center">Tidak ada transaksi bulan ini</td></tr>`;
                        } else {
                            $.each(data, function(index, transaction) {
                                let typeBadge = transaction.type === "Income" ?
                                    '<span class="badge bg-primary">Income</span>' :
                                    '<span class="badge bg-danger">Expense</span>';

                                let amountColor = transaction.type === "Income" ? "text-primary" : "text-danger";

                                rows += `<tr>
                                    <td>${transaction.tanggal}</td>
                                    <td>${transaction.category}</td>
                                    <td>${typeBadge}</td>
                                    <td class="${amountColor}">Rp ${new Intl.NumberFormat("id-ID").format(transaction.nominal)}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning edit-btn" 
                                            data-id="${transaction.id}" 
                                            data-nominal="${transaction.nominal}">
                                            ✏️
                                        </button>
                                        <button class="btn btn-sm btn-danger delete-btn" 
                                            data-id="${transaction.id}" 
                                            data-nominal="${transaction.nominal}" 
                                            data-type="${transaction.type}">
                                            🗑
                                        </button>
                                    </td>
                                </tr>`;
                            });
                        }
                        $("#transactionTable").html(rows);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error:", status, error); // Debugging jika ada error
                        Swal.fire({
                            title: "Error!",
                            text: "Gagal memuat transaksi. Silakan coba lagi.",
                            icon: "error",
                            confirmButtonColor: "#d33"
                        });
                    }
                });
            }

            // Panggil saat pertama kali halaman dimuat
            loadTransactions();

            // Pastikan fungsi bisa dipanggil ulang setelah transaksi dihapus atau diedit
            window.loadTransactions = loadTransactions;
        });
    </script>

    <script>
        // Fungsi untuk simpan data transaksi
        $(document).ready(function() {
            $("#transactionForm").submit(function(e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "AddTransaction.php",
                    data: $(this).serialize(),
                    dataType: "json", // Pastikan AJAX membaca JSON
                    success: function(response) {
                        if (response.status === "success") {
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil!",
                                text: "Transaksi telah ditambahkan.",
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                $("#addTransactionModal").modal("hide");
                                $("#transactionForm")[0].reset();
                                loadTransactions(); // Refresh tabel transaksi
                                loadSummary(); // Refresh summary keuangan
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Gagal!",
                                text: response.message || "Terjadi kesalahan saat menyimpan transaksi.",
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: "Terjadi kesalahan koneksi atau server.",
                        });
                    }
                });
            });
        });
    </script>

    <script>
        // Fungsi untuk edit data transaksi
        $(document).on("click", ".edit-btn", function() {
            let id = $(this).data("id");
            let nominal = $(this).data("nominal");

            $("#editTransactionId").val(id);
            $("#editTransactionAmount").val(nominal);
            $("#editTransactionModal").modal("show");
        });

        // Submit Edit Transaction
        $("#editTransactionForm").submit(function(e) {
            e.preventDefault();
            let id = $("#editTransactionId").val();
            let newNominal = $("#editTransactionAmount").val();

            $.ajax({
                url: "EditTransaction.php",
                type: "POST",
                data: {
                    id: id,
                    nominal: newNominal
                },
                success: function(response) {
                    Swal.fire({
                        title: "Berhasil!",
                        text: "Nilai transaksi berhasil di ubah!",
                        timer: 2000,
                        icon: "success",
                        showConfirmButton: false
                    });
                    $("#editTransactionModal").modal("hide");
                    loadTransactions(); // Refresh transaksi
                    loadSummary(); // Refresh summary
                }
            });
        });
    </script>

    <script>
        // Fungsi untuk hapus data transaksi
        $(document).on("click", ".delete-btn", function() {
            let id = $(this).data("id");
            let nominal = $(this).data("nominal");
            let type = $(this).data("type");

            Swal.fire({
                title: "Anda Yakin?",
                text: "Transaksi ini tidak akan bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "DeleteTransaction.php",
                        type: "POST",
                        data: {
                            id: id,
                            nominal: nominal,
                            type: type
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Dihapus!",
                                text: "Transaksimu telah dihapus.",
                                icon: "success",
                                timer: 2000, // Otomatis hilang setelah 2 detik
                                showConfirmButton: false
                            });
                            loadTransactions(); // Refresh data transaksi
                            loadSummary(); // Refresh summary
                        },
                        error: function() {
                            Swal.fire({
                                title: "Error!",
                                text: "Gagal untuk menghapus transaksi.",
                                icon: "error",
                                confirmButtonColor: "#d33"
                            });
                        }
                    });
                }
            });
        });
    </script>

    <script>
        // Fungsi untuk load data summary transaksi
        function loadSummary() {
            $.ajax({
                url: "TotalTransaction.php",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $("#incomeAmount").text("Rp " + new Intl.NumberFormat("id-ID").format(data.total_income));
                    $("#expenseAmount").text("Rp " + new Intl.NumberFormat("id-ID").format(data.total_expense));
                    $("#totalAmount").text("Rp " + new Intl.NumberFormat("id-ID").format(data.total_balance));
                    loadTransactions(); // Fungsi untuk refresh data transaksi
                },
                error: function() {
                    console.error("Gagal mengambil data summary.");
                }
            });
        }

        // Panggil fungsi saat halaman dimuat
        $(document).ready(function() {
            loadSummary();
        });
    </script>
</body>

</html>