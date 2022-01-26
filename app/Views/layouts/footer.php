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
<?= script_tag("assets/js/clock.js?" . APP_VARSION) ?>