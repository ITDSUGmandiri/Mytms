	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Inventory
				<small>Your data sorted per area</small>
			</h1>

			<ol class="breadcrumb">
				<li><a href="<?php echo base_url("inventory") ?>"><i class="fa fa-archive"></i> Inventory</a></li>
				<li><a href="<?php echo base_url("inventory/by_category"); ?>">Area</a></li>
				<li class="active"><?php echo $nama_lokasi ?></li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Default box -->
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Area : <?php echo $nama_lokasi ?>
					</h3>

					<div class="box-tools pull-right">
						<!-- <button class="btn btn-default btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
						<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<?php echo $message;?>
					<?php echo $nama_lokasi; ?>
					<hr>

					<div class="table-responsive">
						<table class="table table-hover table-bordered table-striped">
							<thead>
								<tr>
									<th>Code</th>
									<th>Nama Unit</th>
									<th>Alamat Lengkap</th>
									<th>Blok</th>
									<th>No. Unit</th>
								</tr>
							</thead>
							<tbody>
							<?php if (count($data_list->result())>0): ?>
								<?php foreach ($data_list->result() as $data): ?>
								<tr>
									<td><?php echo $data->kode; ?></td>
									<td><?php echo $data->nama_unit; ?></td>
									<td><?php echo $data->alamat_lengkap; ?></td>
									<td><?php echo $data->blok; ?></td>
									<td><?php echo $data->no_unit; ?></td>
								</tr>
								<?php endforeach ?>
							<?php else: ?>
								<tr>
									<td class="text-center" colspan="5">No Data Found!</td>
								</tr>
							<?php endif ?>
							</tbody>
						</table>
					</div>
				</div>
				<!-- /.box-body -->
				<div class="box-footer text-center">
					<?php echo $pagination; ?>
					<br>
					<a href="<?php echo base_url('inventory/by_category'); ?>" class="btn btn-primary">Back to Inventory by Category</a>
					<?php echo (isset($last_query)) ? $last_query : ""; ?>&nbsp;
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
