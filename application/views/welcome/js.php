<!-- Chartjs -->
	<script type="text/javascript" src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/chartjs/Chart.bundle.min.js'); ?>"></script>
	<?php
	if (isset($summary)) {
		if (count($summary->result()) > 0) { ?>
		<script type="text/javascript">
			new Chart(document.getElementById("chart"), {
				type: 'bar',
				data: {
					labels: [
						<?php $x = 0;
						foreach ($summary->result() as $chartdata) {
							$x++;
							echo "'".$chartdata->desc_status."'";
							if ($x < count($summary->result())) {
								echo ",";
							}
						} ?>
					],
		      datasets: [{
		        label: "Total Data ",
		        data: [ <?php $x = 0;
							foreach ($summary->result() as $chartdata) {
								$x++;
								echo $chartdata->total;
								if ($x < count($summary->result())) {
									echo ",";
								}
							} ?> ],
						backgroundColor: [ <?php $y = 0;
							foreach ($summary->result() as $chartdata) {
								$y++;
								echo '"rgb('.rand(80, 230).', '.rand(80, 230).', '.rand(80, 230).')"';
								echo ($y < count($summary->result())) ? "," : "";
							} ?> ]
		      }]
				},
				options: {
					title: {
	            display: true,
	            text: 'Total Ticket Per Status'
	        },
					legend : {
						display:true,
						position: 'bottom'
					},
		    }
			});
		</script>
	<?php }
	} ?>
<!-- / Chartjs -->
