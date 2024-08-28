	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Monitoring
				<small> Aset, Penghuni</small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url() ?>inventory/by_area"><i class="fa fa-map-pin"></i>&nbsp;&nbsp;&nbsp;Monitoring</a></li>
				<li class="active">Aset, Penghuni</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Insert New Data box -->
			<div class="box">
				
				<div class="box-header with-border">
					<h3 class="box-title">List Data Area</h3>

					<div class="box-tools pull-right">
						<!-- <button class="btn btn-default btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
					</div>
				</div>

				<div class="box-body">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php echo $message;?>

						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							  <!-- List of category -->
								<?php
								if (count($summary->result()) > 0) { ?>
								<table class="table table-striped table-hover table-bordered">
									<thead>
										<tr>
											<th style="text-align:center">#</th>
											<th style="text-align:center">Nama Area</th>
											<th style="text-align:center">Total</th>
											<th style="text-align:center">#</th>
										</tr>
									</thead>
									<tbody>
									<?php $no = 0;
									foreach ($summary->result() as $summ): $no++; ?>
										<tr>
											<td style="text-align:center"><?php echo $no; ?></td>
											<td style="text-align:left"><?php echo $summ->nama_lokasi; ?></td>
											<td style="text-align:center"><?php echo $summ->total; ?> Data</td>
											<td style="text-align:center">
												<i class="ui-tooltip fa fa-book" title="Lihat Detail Area" style="font-size: 22px;color:#2222aa; cursor:pointer;" data-original-title="Detail Data Area" onclick="detail(<?php echo $summ->id_lok ?>)"></i>&nbsp;&nbsp;
												<i class="ui-tooltip fa fa-eye" title="Lihat Data Aset dan Penghuni" style="font-size: 22px;color:#2222aa; cursor:pointer;" data-original-title="Lihat Data Aset dan Penghuni" onclick="lihat(<?php echo $summ->id_lok ?>)"></i>
											</td>
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
								<!-- Inventory by category chart -->
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

	<script type="text/javascript">
	function detail(id_lok){
		window.location='<?php echo site_url(); ?>'+'inventory/detail_area/'+id_lok;
	}

	function lihat(id_lok){
		window.location='<?php echo site_url(); ?>'+'inventory/by_unit/'+id_lok;
	}
	</script>