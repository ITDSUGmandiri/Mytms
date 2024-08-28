	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Area
				<small>Master Data / Area</small>
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-map-pin"></i>&nbsp;&nbsp;&nbsp;Master Data</li>
				<li class="active">Area</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">
			<?php echo $message; ?>
			<!-- Insert New Data box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Tambah Area
					</h3>

					<div class="box-tools pull-right">
						<button class="btn btn-default btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button>
					</div>
				</div>
				<div class="box-body <?php if (!isset($open_form)){ echo "hide";} ?>" id="add_new">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<form action="<?php echo base_url('locations/add') ?>" method="post" autocomplete="off" class="form form-horizontal" enctype="multipart/form-data">
							
							<div class="form-group">
								<label for="name" class="control-label col-md-2">* Nama Area</label>
								<div class="col-md-8 <?php if (form_error('name')) {echo "has-error";} ?>">
									<input type="text" name="name" id="name" class="form-control" value="<?php echo set_value('name'); ?>" placeholder="Nama Area" required>
								</div>
							</div>
							<div class="form-group">
								<label for="lat" class="control-label col-md-2">Latitude</label>
								<div class="col-md-8 <?php if (form_error('lat')) {echo "has-error";} ?>">
									<input type="text" name="lat" id="lat" class="form-control" value="<?php echo set_value('lat'); ?>" placeholder="Latitude" required>
								</div>
							</div>
							<div class="form-group">
								<label for="long" class="control-label col-md-2">Longitude</label>
								<div class="col-md-8 <?php if (form_error('long')) {echo "has-error";} ?>">
									<input type="text" name="long" id="long" class="form-control" value="<?php echo set_value('long'); ?>" placeholder="Longitude" required>
								</div>
							</div>
							<div class="form-group">
								<label for="detail" class="control-label col-md-2">Catatan</label>
								<div class="col-md-8">
									<textarea name="detail" id="detail" class="form-control text_editor" rows="4" style="resize:vertical; min-height:100px; max-height:200px;"><?php echo set_value('detail'); ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="alamat_lengkap" class="control-label col-md-2">Alamat</label>
								<div class="col-md-8">
									<textarea name="alamat_lengkap" id="alamat_lengkap" class="form-control text_editor" rows="4" style="resize:vertical; min-height:100px; max-height:200px;"><?php echo set_value('alamat_lengkap'); ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="photo" class="control-label col-md-2">Photo</label>
								<div class="col-md-8 <?php if (form_error('photo')) {echo "has-error";} ?>">
									<input type="file" name="photo" id="photo" class="form-control" placeholder="Location Photo">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
									<button type="submit" class="btn btn-primary" onclick="return confirm('Save your data?')">Submit</button>
									<a class="btn btn-danger" href="<?php echo base_url('locations'); ?>" role="button">Cancel</a>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
								  <p class="help-block">(*) Mandatory</p>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->

			<!-- Default box -->
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">List Data Area
					</h3>

					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-hover table-bordered table-striped">
							<thead>
								<tr>
									<th style="text-align:center">No.</th>
									<th style="text-align:center">Code</th>
									<th style="text-align:center">Nama Area</th>
									<th style="text-align:center">Latitude</th>
									<th style="text-align:center">Longitude</th>
									<th style="text-align:center">Detail</th>
									<th style="text-align:center">Alamat Lengkap</th>
									<th style="text-align:center">Photo</th>
									<th style="text-align:center">#</th>
								</tr>
							</thead>
							<tbody>
							<?php 
							if (count($data_list->result())>0):
								$numbering = $data_page;

								foreach ($data_list->result() as $data): 
								$numbering++;	
							?>
								<tr>
									<td style="text-align:center"><?php echo $numbering; ?></td>
									<td style="text-align:center"><?php echo $data->kode; ?></td>
									<td><?php echo $data->nama_lokasi; ?></td>
									<td style="text-align:center"><?php echo $data->lat; ?></td>
									<td style="text-align:center"><?php echo $data->long; ?></td>
									<td><?php echo $data->keterangan; ?></td>
									<td><?php echo $data->alamat_lengkap; ?></td>

									<td style="text-align:center"><?php if ($data->thumbnail!="") :?><a href="<?php echo base_url('assets/uploads/images/locations/').$data->photo ?>" data-fancybox data-caption="<?php echo $data->nama_lokasi ?>">
										<img src="<?php echo base_url('assets/uploads/images/locations/').$data->thumbnail ?>" alt="<?php echo $data->nama_lokasi ?>"></a><?php endif ?></td>

									<td style="text-align:center" width="10%">

										<form action="<?php echo base_url('locations/delete/'.$data->id.'/'.(isset($data->photo)?$data->photo:'0').'/'.(isset($data->photo)?$data->thumbnail:'0')) ?>" method="post" autocomplete="off">
											<div class="btn-group-vertical">
												
												<a class="btn btn-sm btn-default" href="<?php echo base_url('locations/detail_area/'.$data->id) ?>" role="button"><i class="fa fa-eye"></i> Detail</a>
												<a class="btn btn-sm btn-primary" href="<?php echo base_url('locations/edit/'.$data->id) ?>" role="button"><i class="fa fa-pencil"></i> Edit</a>

												<input type="hidden" name="id" value="<?php echo $data->id; ?>">
												<button type="submit" class="btn btn-sm btn-danger" role="button" onclick="return confirm('Delete this data?')"><i class="fa fa-trash"></i> Delete</button>
											</div>
										</form>

									</td>
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
					<?php //echo $last_query ?>&nbsp;
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

    <script src="<?php echo base_url(); ?>assets/templates/adminlte-2-3-11/dist/js/myclass.js" type="text/javascript"></script>