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
	<h1 class="text-center"><?= $monthName ?></h1>
	<div class="d-flex">
		<div class="flex-fill">
			<?php if ($last_action["action"] == "none") : ?>
				<h2>Click <i class="bi bi-play" style="font-size: 1.5rem;"></i> to start.</h2>

			<?php else : ?>
				<h2><?= "Today {$last_action["action"]} {$last_action["time"]}" ?></h2>
			<?php endif ?>
		</div>
		<div class="text-end">
			<?php if ($last_action["action"] != "holiday" && $last_action["action"] != "sickday") : ?>
				<button class="btn btn-success action_btn <?= $in ?>" data-action="in"><i class="bi bi-play" style="font-size: 1.5rem;"></i></button>
				<button class="btn btn-danger action_btn <?= $out ?>" data-action="out"><i class="bi bi-stop" style="font-size: 1.5rem;"></i></button>
			<?php endif ?>
		</div>
	</div>
	<div class="d-flex">
		<?php if ($last_action["action"] == "none") : ?>
			<button class="btn btn-warning action_btn mb-2" data-action="holiday">Holiday</button>
			<button class="btn btn-dark action_btn mx-2 mb-2" data-action="sickday">Sickday</button><br>
		<?php endif ?>

	</div>
	<div class="input-group my-2">
		<div class="form-floating flex-fill">
			<input type="date" class="form-control" id="new_date" placeholder="awsome date">
			<label class="text-nowrap" for="new_date">Add new date</label>
		</div>
		<button class="btn btn-success add_new_date"><i class="bi bi-plus-circle"></i></button>
	</div>
	<div class="table-responsive">
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th scope="col">Date</th>
					<th scope="col">Status</th>
					<th scope="col">In</th>
					<th scope="col">Out</th>
					<th scope="col">Total</th>
					<th scope="col">Edit</th>
				</tr>
			</thead>
			<?php
			if (isset($timers) && $timers !== false) {
				foreach ($timers as $day => $date) {
					$day_status = "regular";
					$in = "";
					$out = "";
					$total = "";
					if (!$date) continue;
					echo "<tr><th scope='row'>$day</th>";

					foreach ($date as $status => $time) {
						if ($status == "holiday" && $time) {
							$day_status = "holiday";
							continue;
						}
						if ($status == "sickday" && $time) {
							$day_status = "sickday";
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
					echo "<td>$day_status</td>";
					echo "<td>$in</td>";
					echo "<td>$out</td>";
					echo "<td>" . convertToHoursMins($total) . "</td>";
					$data_in = implode(",", $date["in"]);
					$data_out = implode(",", $date["out"]);
					echo "<td>
				<span class='col-1 btn edit-date' data-bs-toggle='modal' data-bs-target='#staticBackdrop' 
				data-date-id='$day' data-date-in='$data_in' data-date-out='$data_out' data-date-status='$day_status'>
				<i class='bi bi-pencil-square'></i>
				</span>";

					echo "</tr>";
				}
			}
			?>
		</table>
	</div>
	<?= $this->include('/elements/date_form') ?>

<?php endif ?>
<script>
	$(".add_new_date").on("click", function() {
		let date = $("#new_date").val();
		$.post("<?= site_url('/month/add_date') ?>", {
			date: date,
			user_id: "<?= $user["id"] ?>",
			csrf_test_name: "<?= csrf_hash() ?>",
		}).done(function(o) {
			location.reload();
		});
	});

	$(".action_btn").on("click", function() {
		let action = $(this).attr("data-action");
		$.post("<?= site_url('/month/action') ?>", {
			action: action,
			csrf_test_name: "<?= csrf_hash() ?>",
		}).done(function(o) {
			location.reload();
		});
	});

	$(document).on("click", ".edit-date", function() {
		let date_id = $(this).attr("data-date-id");
		let date_status = $(this).attr("data-date-status");
		let data_in = $(this).attr("data-date-in").split(",");
		let data_out = $(this).attr("data-date-out").split(",");
		$(".form-date-id").val(date_id);
		$(".form-date-id-title").text(date_id);
		$("#timers_feilds_in").empty();
		$("#timers_feilds_out").empty();
		data_in.forEach(function(index) {
			$tr = $(".timers_in_tmp").clone().attr("class", "input-group m-2");
			$("input", $tr).attr("value", index);
			$tr.appendTo("#timers_feilds_in");
		});
		data_out.forEach(function(index) {
			$tr = $(".timers_out_tmp").clone().attr("class", "input-group m-2");
			$("input", $tr).attr("value", index);
			$tr.appendTo("#timers_feilds_out");
		});
		$("#timers_feilds_in").find(".delete-timer-row").first().hide()
		$("#timers_feilds_out").find(".delete-timer-row").first().hide()
	});

	$(document).on("click", ".delete-timer-row", function() {
		$(this).parent().detach();
	});

	$(document).on("click", ".plus_timer_row", function() {
		$tr = $(".timers_in_tmp").clone().attr("class", "input-group m-2");
		$tr.appendTo("#timers_feilds_in");
		$tr = $(".timers_out_tmp").clone().attr("class", "input-group m-2");
		$tr.appendTo("#timers_feilds_out");
	});
</script>
<?= $this->endSection() ?>