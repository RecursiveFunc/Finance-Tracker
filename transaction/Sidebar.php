<div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 250px; height: 100%;">
    <a href="<?php echo BASE_URL . 'dashboard/index.php' ?>" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <img src="../image/logo.png" alt="Finance Tracker Logo" width="40" height="32" class="me-2">
        <span class="fs-4">Finance Tracker</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="<?php echo BASE_URL . 'dashboard/Index.php' ?>" class="nav-link link-body-emphasis">
                <svg class="bi pe-none me-2" width="16" height="16">
                    <use xlink:href="#home" />
                </svg>
                Dashboard
            </a>
        </li>
        <li>
            <a href="<?php echo BASE_URL . 'transaction/Transaction.php' ?>" class="nav-link active" aria-current="page">
                <svg class="bi pe-none me-2" width="16" height="16">
                    <use xlink:href="#transaction" />
                </svg>
                Transactions
            </a>
        </li>
        <li>
            <a href="<?php echo BASE_URL . 'statistic/Statistic.php' ?>" class="nav-link link-body-emphasis">
                <svg class="bi pe-none me-2" width="16" height="16">
                    <use xlink:href="#statistic" />
                </svg>
                Statistics
            </a>
        </li>
        <li>
            <a href="<?php echo BASE_URL . 'account/Account.php' ?>" class="nav-link link-body-emphasis">
                <svg class="bi pe-none me-2" width="16" height="16">
                    <use xlink:href="#wallet" />
                </svg>
                Accounts
            </a>
        </li>
        <li>
            <a href="<?php echo BASE_URL . 'setting/Setting.php' ?>" class="nav-link link-body-emphasis">
                <svg class="bi pe-none me-2" width="16" height="16">
                    <use xlink:href="#setting" />
                </svg>
                Settings
            </a>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong>mdo</strong>
        </a>
        <ul class="dropdown-menu text-small shadow">
            <li><a class="dropdown-item" href="#">New project...</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><a class="dropdown-item" href="#">Profile</a></li>
            <li>
                <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
    </div>
</div>