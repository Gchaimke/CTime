<?php
// force_https();
$logged_in = false;
if (isset($user) && $user['logged_in'] != "") {
    $logged_in = true;
    $role = $user['role'];
}

$display_message = "none";
if (session()->getFlashdata('error') != "" || service('validation')->getErrors() || $message_text != "") {
    $display_message = "block";
}

?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<?= $this->include('/layouts/head') ?>

<body class="d-flex flex-column h-100">
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleContent" aria-controls="navbarToggleContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <a class="navbar-brand" href="<?= site_url('/') ?>"><i class="bi bi-clock-history"></i> CTime v<?= APP_VARSION ?></a>
                <span class="clock-bar">
                    <span class="date" id="date"><?= $now->toDateString() ?></span>
                    <span class="clock" id="clock"></span>
                </span>
                <div class="collapse navbar-collapse" id="navBar">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item mx-3">
                            <a class="nav-link <?= uri_string() == "/" ? "active" : "" ?> " aria-current="" href="<?= site_url('/') ?>"><i class="bi bi-house-door" style="font-size: 1.5rem;"></i></a>
                        </li>
                        <?php if ($logged_in) : ?>
                            <li class="nav-item"><a class="nav-link <?= uri_string() == "month" ? "active" : "" ?>" href="<?= site_url('month') ?>"><i class="bi bi-calendar3" style="font-size: 1.5rem;"></i></a> </li>
                            <li class="nav-item"><a class="nav-link <?= uri_string() == "projects" ? "active" : "" ?>" href="<?= site_url('projects') ?>"><i class="bi bi-card-list" style="font-size: 1.5rem;"></i></a> </li>
                        <?php endif ?>
                    </ul>
                    <ul class="navbar-nav d-flex">
                        <?php if ($role == "admin") : ?>
                            <li class="nav-item"> <a class="nav-link <?= uri_string() == "admin" ? "active" : "" ?>" href="<?= site_url('/admin') ?>"><i class="bi bi-tools" style="font-size: 1.5rem;"></i></a></li>
                        <?php endif ?>
                        <?php if ($logged_in) : ?>
                            <li class="nav-item mx-3"> <a class="nav-link <?= uri_string() == "user" ? "active" : "" ?>" href="<?= site_url('/user') ?>"><i class="bi bi-gear" style="font-size: 1.5rem;"></i></a> </li>
                            <li class="nav-item"><a class="nav-link" href="<?= site_url('/login') ?>"><i class="bi bi-power" style="font-size: 1.5rem;"></i></a> </li>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= site_url('/login') ?>">Login</a>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="collapse" id="navbarToggleContent">
            <div class="bg-dark p-4">
                <div class="d-flex mt-5">
                    <div class="d-flex justify-content-start flex-fill">
                        <a class="nav-link <?= uri_string() == "/" ? "active" : "" ?> " aria-current="" href="<?= site_url('/') ?>"><i class="bi bi-house-door" style="font-size: 1.5rem;"></i></a>
                        <?php if ($logged_in) : ?>
                            <a class="nav-link <?= uri_string() == "month" ? "active" : "" ?>" href="<?= site_url('month') ?>"><i class="bi bi-calendar3" style="font-size: 1.5rem;"></i></a>
                            <a class="nav-link <?= uri_string() == "projects" ? "active" : "" ?>" href="<?= site_url('projects') ?>"><i class="bi bi-card-list" style="font-size: 1.5rem;"></i></a>
                        <?php endif ?>
                    </div>
                    <div class="d-flex justify-content-end">
                        <?php if ($role == "admin") : ?>
                            <a class="nav-link <?= uri_string() == "admin" ? "active" : "" ?>" href="<?= site_url('/admin') ?>"><i class="bi bi-tools" style="font-size: 1.5rem;"></i></a>
                        <?php endif ?>
                        <?php if ($logged_in) : ?>
                            <a class="nav-link <?= uri_string() == "user" ? "active" : "" ?>" href="<?= site_url('/user') ?>"><i class="bi bi-gear" style="font-size: 1.5rem;"></i></a>
                            <a class="nav-link" href="<?= site_url('/login') ?>"><i class="bi bi-power" style="font-size: 1.5rem;"></i></a>
                        <?php else : ?>
                            <a class="nav-link" href="<?= site_url('/login') ?>">Login</a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
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
            <?= $this->include('/elements/modal') ?>
        </div>
    </main>
    <?= $this->include('/layouts/footer') ?>
</body>

</html>