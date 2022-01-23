<?= $this->extend('default_layout') ?>
<?= $this->section('content') ?>
<h1>Home <?= CodeIgniter\CodeIgniter::CI_VERSION ?></h1>
<?php

if (isset($user)) : ?>
	<h1>Hello <?= $user['view_name'] . " you are " . $user['role'] ?></h1>
<?php endif ?>
<?php
// print_r($timers);
?>

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
<?= $this->endSection() ?>