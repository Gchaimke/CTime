<?php
$logged_in = false;
if (isset($user) && $user['logged_in'] != "") {
    $logged_in = true;
    $role = $user['role'];
}

$display_message = "none";
if (session()->getFlashdata('error') != "" || service('validation')->listErrors() != "" || $message_text != "") {
    $display_message = "block";
}
?>
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="UTF-8">
    <title>CTime <?= APP_VARSION ?></title>
    <meta name="description" content="CTime System">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/assets/css/main.css?<?= APP_VARSION ?>">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
</head>

<body class="d-flex flex-column h-100">
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <a class="navbar-brand" href="/"><i class="bi bi-clock-history"></i> CTime v<?= APP_VARSION ?></a>
                <span class="clock-bar">
                    <span class="date" id="date"><?= $now->toDateString() ?></span>
                    <span class="clock" id="clock"></span>
                </span>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item mx-3">
                            <a class="nav-link <?= uri_string() == "/" ? "active" : "" ?> " aria-current="" href="/"><i class="bi bi-house-door" style="font-size: 1.5rem;"></i></a>
                        </li>
                        <?php if ($logged_in) : ?>
                            <li class="nav-item"><a class="nav-link <?= uri_string() == "user/timers" ? "active" : "" ?>" href="/user/timers"><i class="bi bi-calendar3" style="font-size: 1.5rem;"></i></a> </li>
                        <?php endif ?>
                    </ul>
                    <ul class="navbar-nav d-flex">
                        <?php if ($role == "admin") : ?>
                            <li class="nav-item"> <a class="nav-link <?= uri_string() == "admin" ? "active" : "" ?>" href="/admin"><i class="bi bi-tools" style="font-size: 1.5rem;"></i></a></li>
                        <?php endif ?>
                        <?php if ($logged_in) : ?>
                            <li class="nav-item mx-3"> <a class="nav-link <?= uri_string() == "user" ? "active" : "" ?>" href="/user"><i class="bi bi-gear" style="font-size: 1.5rem;"></i></a> </li>
                            <li class="nav-item"><a class="nav-link" href="/login"><i class="bi bi-power" style="font-size: 1.5rem;"></i></a> </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/login">Login</a>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="flex-shrink-0 mt-5">
        <div class="container mt-5">
            <div class="alert alert-<?= $message_type ?> messages" style="display:<?= $display_message ?>;">
                <?= session()->getFlashdata('error') ?>
                <?= service('validation')->listErrors() ?>
                <?= $message_text ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?= $this->renderSection('content') ?>
            <?= $this->include('modal') ?>

        </div>
    </main>
    <footer class="footer mt-auto py-3 bg-light">
        <div class="container">
            <div class="row">
                <div class="col copyrights">
                    <span>CTime&copy; <?= date('Y') ?> Chaim Gorbov</span>
                    <span>&nbsp; ENV: <?= ENVIRONMENT ?></p>
                </div>
                <div class="col environment">
                    <p>rendered time {elapsed_time}s</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="/assets/js/clock.js?<?= APP_VARSION ?>" crossorigin="anonymous"></script>
</body>

</html>