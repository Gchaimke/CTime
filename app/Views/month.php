<?= $this->extend('/layouts/default_layout') ?>
<?= $this->section('content') ?>
<?php
$month = isset($_GET['month']) ? $_GET['month'] : $now->getMonth();
$dateObj   = DateTime::createFromFormat('!m', $month);
$monthName = $dateObj->format('F');
$in = "";
$out = "";
if ($last_action["action"] == "in") {
	$in = "hidden";
} else {
	$out = "hidden";
}
if (isset($user)) : ?>
	<div class="row">
		<h1 class="col"><?= $monthName ?></h1>
		<div class="col text-center">
			<?php if ($last_action["action"] == "none") : ?>

				<h2>Click <i class="bi bi-play" style="font-size: 1.5rem;"></i> to start.</h2>
				<button class="btn btn-warning action_btn mb-3" data-action="holiday">Holiday</button>
				<button class="btn btn-dark action_btn mb-3" data-action="sickday">Sickday</button><br>
			<?php else : ?>
				<h2><?= "Today {$last_action["action"]} {$last_action["time"]}" ?></h2>
			<?php endif ?>
		</div>
		<div class="col text-end">

			<?php if ($last_action["action"] != "holiday" && $last_action["action"] != "sickday") : ?>
				<button class="btn btn-success action_btn <?= $in ?>" data-action="in"><i class="bi bi-play" style="font-size: 1.5rem;"></i></button>
				<button class="btn btn-danger action_btn <?= $out ?>" data-action="out"><i class="bi bi-stop" style="font-size: 1.5rem;"></i></button>
			<?php endif ?>
		</div>

	</div>
	<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th scope="col">Date</th>
				<th scope="col">in</th>
				<th scope="col">out</th>
				<th scope="col">total</th>
			</tr>
		</thead>
		<?php
		if (isset($timers) && $timers !== false) {
			foreach ($timers as $day => $date) {
				$in = "";
				$out = "";
				$total = "";
				echo "<tr><th scope='row'>$day</th>";
				foreach ($date as $status => $time) {
					if ($status == "holiday" && $time) {
						$in = "holiday";
						continue;
					}
					if ($status == "sickday" && $time) {
						$in = "sickday";
						continue;
					}

					if ($status == "in") {
						foreach ($time as $key => $value) {
							$in .= "<p>$value</p>";
						}
					}
					if ($status == "out") {
						foreach ($time as $key => $value) {
							$out .= "<p>$value</p>";
						}
					}
					if ($status == "total") {
						$total = $time;
					}
				}
				echo "<td>$in</td>";
				echo "<td>$out</td>";
				echo "<td>" . convertToHoursMins($total) . "</td>";
				echo "</tr>";
			}
		}
		?>
	</table>
<?php endif ?>
<script>
	$(".action_btn").on("click", function() {
		let action = $(this).attr("data-action");
		$.post("<?= site_url('/month/action') ?>", {
			action: action,
			csrf_test_name: "<?= csrf_hash() ?>",
		}).done(function(o) {
			location.reload();
		});
	});
</script>
<?= $this->endSection() ?>