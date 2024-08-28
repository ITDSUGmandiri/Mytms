	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
			Fasilitas
				<small>Master Data / Fasilitas</small>
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-map-pin"></i>&nbsp;&nbsp;&nbsp;Master Data</li>
				<li class="active"></i>Fasilitas</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Update Location Data box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Edit Fasilitas
					</h3>

					<div class="box-tools pull-right">
						<!-- <button class="btn btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
					</div>
				</div>
				<div class="box-body">

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

						<?php echo $message;?>

						<?php foreach ($data_list->result() as $data){
								$curr_area_id      		= $data->area_id;
								$curr_code      		= $data->code;
								$curr_nama_fasilitas	= $data->nama_fasilitas;
								$curr_jenis_fasilitas	= $data->jenis_fasilitas;
								$curr_detail    		= $data->detail;
								$curr_photo     		= $data->photo;
								$curr_thumbnail 		= $data->thumbnail;
						} ?>

						<form action="<?php echo base_url('fasilitas/edit/').$id ?>" method="post" autocomplete="off" class="form form-horizontal" enctype="multipart/form-data">

							<div class="form-group">
								<label for="area_id" class="control-label col-md-2">* Area</label>
								<div class="col-md-8 <?php if (form_error('area_id')) {echo "has-error";} ?>">
								
									<select name="area_id" id="area_id" class="form-control" required>
										<option value="0">- Pilih Area -</option>

										<?php foreach ($data_list_area->result() as $val){

											if ($curr_area_id == $val->id){
												echo '<option selected="selected" value = "' . $val->id . '">' . $val->nama_lokasi . '</option>';
											}else{
												echo '<option value = "' . $val->id . '">' . $val->nama_lokasi . '</option>';
											}

										} ?>

									</select>

								</div>
							</div>

							<div class="form-group">
								<label for="nama_fasilitas" class="control-label col-md-2">* Nama Fasilitas</label>
								<div class="col-md-8 <?php if (form_error('nama_fasilitas')) {echo "has-error";} ?>">
									<input type="text" name="nama_fasilitas" id="nama_fasilitas" class="form-control" value="<?php echo $curr_nama_fasilitas ?>" placeholder="Nama Fasilitas" required>
								</div>
							</div>

							<div class="form-group">
								<label for="detail" class="control-label col-md-2">Detail</label>
								<div class="col-md-8">
									<textarea name="detail" id="detail" class="form-control text_editor" rows="4" style="resize:vertical; min-height:100px; max-height:200px;"><?php echo $curr_detail ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="photo" class="control-label col-md-2">Photo</label>
								<div class="col-md-8">
									<?php if ($curr_thumbnail!=""): ?>
									<img src="<?php echo base_url('assets/uploads/images/fasilitas/').$curr_thumbnail ?>" alt="Current Fasilitas Photo">
									<?php endif ?>
									<input type="hidden" name="curr_photo" value="<?php echo $curr_photo ?>">
									<input type="hidden" name="curr_thumbnail" value="<?php echo $curr_thumbnail ?>">
									<input type="file" name="photo" id="photo" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
									<button onclick="return confirm('Save your data?')" name="submit" id = "submit" type="submit" class="peringatan btn btn-default"><i class="fa fa-save"></i> Submit</button>
									<button type="button" onClick="window.location='<?php echo site_url();?>fasilitas';" class="btn btn-default"><i class="fa fa-undo"></i> Cancel</button>
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
