	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Inventory
				<small>All your items data</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo base_url("inventory") ?>"><i class="fa fa-archive"></i> Inventory</a></li>
				<li class="active">Location</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Insert New Data box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">By Location
					</h3>

					<div class="box-tools pull-right">
						<!-- <button class="btn btn-default btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
					</div>
				</div>
				<div class="box-body">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php echo $message;?>

						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							  <!-- List of location -->
								<?php
								if (count($summary->result()) > 0) { ?>
								<table class="table table-striped table-hover table-bordered">
									<thead>
										<tr>
											<th>#</th>
											<th>Code</th>
											<th>Location</th>
											<th>Total</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
									<?php $no = 0;
									foreach ($summary->result() as $summ): $no++; ?>
										<tr>
											<td><?php echo $no; ?></td>
											<td><?php echo $summ->code; ?></td>
											<td><?php echo $summ->name; ?></td>
											<td><?php echo $summ->total; ?> Data</td>
											<td><a class="btn btn-primary btn-xs" href="<?php echo base_url("inventory/by_location/".$summ->code); ?>">Detail</a></td>
										</tr>
									<?php endforeach; ?>
									</tbody>
								</table>
								<?php }
								else {
									echo "<p class='text-center'>No Inventory Data Found!</p>";
								}
								?>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<!-- Inventory by location chart -->
							  <div class="well well-sm">
							    <canvas id="chart" class="chartjs" width="100%"></canvas>
							  </div>
							</div>
						</div>
					</div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->

		</section>
		<!-- /.content -->
	</div>
	<!-- /.content-wrapper -->

	<!-- =========================== / CONTENT =========================== -->

	<!-- jQuery 2.2.3 -->
    <script src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>

    <!-- Bootstrap 3.3.6 -->
    <script src="<?php echo base_url('assets/templates/adminlte-2-3-11/bootstrap/js/bootstrap.min.js'); ?>"></script>

    <!-- SlimScroll -->
    <script src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/fastclick/fastclick.js'); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url('assets/templates/adminlte-2-3-11/dist/js/app.min.js'); ?>"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url('assets/templates/adminlte-2-3-11/dist/js/demo.js'); ?>"></script>

    <script src="<?php echo base_url(); ?>assets/templates/adminlte-2-3-11/dist/js/myclass.js" type="text/javascript"></script>