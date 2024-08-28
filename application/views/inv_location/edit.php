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

			<!-- Update Location Data box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Ubah Area
					</h3>

					<div class="box-tools pull-right">
						<!-- <button class="btn btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
					</div>
				</div>
				<div class="box-body">

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php echo $message;?>
						<form action="<?php echo base_url('locations/edit/').$id ?>" method="post" autocomplete="off" class="form form-horizontal" enctype="multipart/form-data">
							<?php foreach ($data_list->result() as $data){
								$curr_id      		= $data->id;
								$curr_code      	= $data->kode;
								$curr_name      	= $data->nama_lokasi;
								$curr_lat      		= $data->lat;
								$curr_long      	= $data->long;
								$curr_detail    	= $data->keterangan;
								$curr_alamat_lengkap= $data->alamat_lengkap;
								$curr_photo     	= $data->photo;
								$curr_thumbnail 	= $data->thumbnail;
							} ?>
							<div class="form-group">
								<label for="code" class="control-label col-md-2">Area Code</label>
								<div class="col-md-8">
									<p class="form-control-static"><?php echo $curr_code ?></p>
									<input type="hidden" name="code" value="<?php echo $curr_code ?>">
									<input type="hidden" name="id" value="<?php echo $curr_id ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="name" class="control-label col-md-2">* Nama Area</label>
								<div class="col-md-8 <?php if (form_error('name')) {echo "has-error";} ?>">
									<input type="text" name="name" id="name" class="form-control" value="<?php echo $curr_name ?>" placeholder="Nama Area" required>
								</div>
							</div>
							<div class="form-group">
								<label for="lat" class="control-label col-md-2">Latitude</label>
								<div class="col-md-8 <?php if (form_error('lat')) {echo "has-error";} ?>">
									<input type="text" name="lat" id="lat" class="form-control" value="<?php echo $curr_lat ?>" placeholder="Latitude" required>
								</div>
							</div>
							<div class="form-group">
								<label for="long" class="control-label col-md-2">Longitude</label>
								<div class="col-md-8 <?php if (form_error('long')) {echo "has-error";} ?>">
									<input type="text" name="long" id="long" class="form-control" value="<?php echo $curr_long ?>" placeholder="Longitude" required>
								</div>
							</div>
							<div class="form-group">
								<label for="detail" class="control-label col-md-2">Detail</label>
								<div class="col-md-8">
									<textarea name="detail" id="detail" class="form-control text_editor" rows="4" style="resize:vertical; min-height:100px; max-height:200px;"><?php echo $curr_detail ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="alamat_lengkap" class="control-label col-md-2">Alamat</label>
								<div class="col-md-8">
									<textarea name="alamat_lengkap" id="alamat_lengkap" class="form-control text_editor" rows="4" style="resize:vertical; min-height:100px; max-height:200px;"><?php echo $curr_alamat_lengkap ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="photo" class="control-label col-md-2">Photo</label>
								<div class="col-md-8">
									<?php if ($curr_thumbnail!=""): ?>
									<img src="<?php echo base_url('assets/uploads/images/locations/').$curr_thumbnail ?>" alt="Current Location Photo">
									<?php endif ?>
									<input type="hidden" name="curr_photo" value="<?php echo $curr_photo ?>">
									<input type="hidden" name="curr_thumbnail" value="<?php echo $curr_thumbnail ?>">
									<input type="file" name="photo" id="photo" class="form-control">
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
