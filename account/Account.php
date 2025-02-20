<?php include("../helper/path.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Accounts - Finance Tracker</title>
    <link rel="stylesheet" href="Account.css">
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
        <div class="content">
            <!-- Section Assets & Liabilities -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card asset-card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Assets</h5>
                            <p class="card-text fs-4" id="assets">Rp 0</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card liability-card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Liabilities</h5>
                            <p class="card-text fs-4" id="liabilities">Rp 0</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card total-card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Total</h5>
                            <p class="card-text fs-4" id="total">Rp 0</p>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Tabel Penyimpanan Uang -->
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Penyimpanan Uang</h5>
                    <button class="btn btn-light option-button" data-bs-toggle="modal" data-bs-target="#addSavingsModal">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Tabungan</th>
                                <th>Nominal (Rp)</th>
                            </tr>
                        </thead>
                        <tbody id="accountsTableBody">
                    </table>
                </div>
            </div>
        </div>
    </main>


    <!-- Modal Tambah Jenis Tabungan -->
    <div class="modal fade" id="addSavingsModal" tabindex="-1" aria-labelledby="addSavingsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSavingsModalLabel">Tambah Jenis Tabungan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="savingsType" class="form-label">Jenis Tabungan</label>
                            <input type="text" class="form-control" id="savingsType" placeholder="Contoh: Tabungan Bank">
                        </div>
                        <div class="mb-3">
                            <label for="savingsAmount" class="form-label">Nominal (Rp)</label>
                            <input type="number" class="form-control" id="savingsAmount" placeholder="Contoh: 5000000">
                        </div>
                        <button type="submit" class="btn btn-secondary w-100">Tambah</button>
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
            // Function untuk membaca data
            function loadAccounts() {
                $.ajax({
                    url: "ReadAccount.php",
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        let rows = "";
                        $.each(data, function(index, account) {
                            let formattedNominal = new Intl.NumberFormat("id-ID", {
                                style: "currency",
                                currency: "IDR"
                            }).format(account.nominal);
                            rows += `<tr>
                            <td>${index + 1}</td>
                            <td>${account.jenis_tabungan}</td>
                            <td>${formattedNominal}</td>
                            </tr>`;
                        });
                        $("tbody").html(rows);
                    }

                });
            }

            // Panggil function saat halaman pertama kali dimuat
            loadAccounts();

            // Function untuk menambahkan data
            $("#addSavingsModal form").submit(function(e) {
                e.preventDefault(); // Mencegah refresh halaman

                let savingsType = $("#savingsType").val();
                let savingsAmount = $("#savingsAmount").val();

                $.ajax({
                    url: "CreateAccount.php",
                    type: "POST",
                    data: {
                        savingsType: savingsType,
                        savingsAmount: savingsAmount
                    },
                    success: function(response) {
                        if (response === "success") {
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil!",
                                text: "Data berhasil ditambahkan.",
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                $("#addSavingsModal").modal("hide"); // Tutup modal
                                $("#addSavingsModal form")[0].reset(); // Reset form
                                loadAccounts(); // Refresh data tabel
                            });
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Gagal!",
                                text: "Gagal menambahkan data.",
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    }
                });
            });
        });
    </script>

    <script>
        // Function untuk menghitung Assets, Liabilities dan Total
        $(document).ready(function() {
            function loadFinancials() {
                $.ajax({
                    url: "CalculateTotal.php",
                    method: "GET",
                    dataType: "json",
                    success: function(data) {
                        $("#assets").text(formatRupiah(data.assets));
                        $("#liabilities").text(formatRupiah(data.liabilities));
                        $("#total").text(formatRupiah(data.total));
                    },
                    error: function(xhr, status, error) {
                        console.error("Gagal mengambil data: " + error);
                    }
                });
            }

            function formatRupiah(angka) {
                return new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0
                }).format(angka);
            }

            loadFinancials(); // Panggil fungsi saat halaman dimuat
        });
    </script>
</body>

</html>