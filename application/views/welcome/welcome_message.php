<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Home
				<!-- <small>it all starts here</small> -->
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-map-pin"></i>&nbsp;&nbsp;&nbsp;Home</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Default box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Dashboard</h3>

					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
						<button class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="row">
							
							<div class="col-lg-6 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-red">
									<div class="inner">
										<h3><?php echo $total_location ?></h3>

										<p>Area</p>
									</div>
									<div class="icon">
										<i class="ion ion-compass"></i>
									</div>
									<a href="<?php echo base_url('locations') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<!-- ./col -->
							<div class="col-lg-6 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-yellow">
									<div class="inner">
										<h3><?php echo $total_unit ?></h3>

										<p>Unit</p>
									</div>
									<div class="icon">
										<i class="ion ion-compass"></i>
									</div>
									<a href="<?php echo base_url('unit') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<!-- ./col -->
							<div class="col-lg-6 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-blue">
									<div class="inner">
										<h3><?php echo $total_type_incident ?></h3>

										<p>Type Incident</p>
									</div>
									<div class="icon">
										<i class="ion ion-laptop"></i>
									</div>
									<a href="<?php echo base_url('type_incident') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<!-- ./col -->

							<div class="col-lg-6 col-xs-6">
								<!-- small box -->
								<div class="small-box bg-green">
									<div class="inner">
										<h3><?php echo $total_engineer ?></h3>

										<p>Engineer</p>
									</div>
									<div class="icon">
										<i class="ion ion-star"></i>
									</div>
									<a href="<?php echo base_url('categories') ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								</div>
							</div>
							<!-- ./col -->
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<!-- Inventory by category chart -->
						<canvas id="chart" class="chartjs" width="100%"></canvas>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
					<!-- Footer -->
				</div>
				<!-- /.box-footer-->
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