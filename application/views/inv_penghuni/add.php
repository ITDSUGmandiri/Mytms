	<!-- =========================== CONTENT =========================== -->

	<style>
	input:focus, textarea:focus {
		outline-color: dodgerblue;
	}

	.invalid {
		border: 2px solid rgb(153, 16, 16);
	}

	.invalid::placeholder {
		color: rgb(153, 16, 16);
	}

	.invalid-feedback:empty {
		display: none;
	}
	.invalid-feedback {
		font-size: smaller;
		color: rgb(153, 16, 16);
	}

	/* Button */
	.button {
		background-color: #e7e7e7;
		border: 2px solid transparent;
		border-radius: 8px;
		color: black;
		padding: 8px 32px;
		text-align: center;
		text-decoration: none;
		display: inline-block;
		font-size: 1rem;
		font-family: sans-serif;
	}

	.button:hover {
		opacity: 0.8;
	}

	.button:active {
		border: 2px solid rgba(0, 0, 0, 0.5);
	}

	.button-success {
		background-color: #4caf50;
		color: white;
	}
	.button-primary {
		background-color: #008cba;
		color: white;
	}
	.button-danger {
		background-color: #f44336;
		color: white;
	}

	.button-small {
		font-size: 0.7rem;
	}
	</style>

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Penghuni
				<small>Master Data / Penghuni</small>
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-map-pin"></i>&nbsp;&nbsp;&nbsp;Master Data</li>
				<li class="active">Penghuni</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

		<?php //echo $message; ?>

			<!-- Insert New Data box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Tambah Penghuni
					</h3>

					<div class="box-tools pull-right">
						<!--<button class="btn btn-default btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button>-->
					</div>
				</div>

				<div class="box-body <?php if (!isset($open_form)){ echo "hide";} ?>" id="add_new">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

						<form action="<?php echo base_url('penghuni/save_add') ?>" method="post" autocomplete="off" class="form form-horizontal" enctype="multipart/form-data">
							
							<div class="form-group">
								<label for="nama_penghuni" class="control-label col-md-2">* Nama Penghuni</label>
								<div class="col-md-8 <?php if (form_error('nama_penghuni')) {echo "has-error";} ?>">
									<input type="text" name="nama_penghuni" id="nama_penghuni" class="form-control" value="<?php echo set_value('nama_penghuni'); ?>" placeholder="Nama Penghuni">
									<div class="invalid-feedback"><?= form_error('nama_penghuni', '<div class="error">', '</div>') ?></div>
								</div>
							</div>

							<div class="form-group">
								<label for="jk" class="control-label col-md-2">* Jenis Kelamin</label>
								<div class="col-md-8 <?php if (form_error('jk')) {echo "has-error";} ?>">

									<select name="jk" id="jk" class="form-control">
										<option value="0">- Jenis Kelamin -</option>
										<option value="male" <?php echo set_select('jk', 'male'); ?>>Laki-Laki</option>
										<option value="female" <?php echo set_select('jk', 'female'); ?>>Perempuan</option>
									</select>

									<div class="invalid-feedback"><?= form_error('jk', '<div class="error">', '</div>') ?></div>

								</div>
							</div>

							<div class="form-group">
								<label for="jabatan" class="control-label col-md-2">Jabatan</label>
								<div class="col-md-8 <?php if (form_error('jabatan')) {echo "has-error";} ?>">
									<input type="text" name="jabatan" id="jabatan" class="form-control" value="<?php echo set_value('jabatan'); ?>" placeholder="Jabatan">
									<div class="invalid-feedback"><?= form_error('jabatan', '<div class="error">', '</div>') ?></div>
								</div>
							</div>

							<div class="form-group">
								<label for="unit_kerja" class="control-label col-md-2">Unit Kerja</label>
								<div class="col-md-8 <?php if (form_error('unit_kerja')) {echo "has-error";} ?>">
									<input type="text" name="unit_kerja" id="unit_kerja" class="form-control" value="<?php echo set_value('unit_kerja'); ?>" placeholder="Unit Kerja">
									<div class="invalid-feedback"><?= form_error('unit_kerja', '<div class="error">', '</div>') ?></div>
								</div>
							</div>

							<div class="form-group">
								<label for="pasangan" class="control-label col-md-2">Pasangan</label>
								<div class="col-md-8 <?php if (form_error('pasangan')) {echo "has-error";} ?>">
									<input type="text" name="pasangan" id="pasangan" class="form-control" value="<?php echo set_value('pasangan'); ?>" placeholder="Pasangan">
									<div class="invalid-feedback"><?= form_error('pasangan', '<div class="error">', '</div>') ?></div>
								</div>
							</div>

							<div class="form-group">
								<label for="hubungan" class="control-label col-md-2">* Hubungan</label>
								<div class="col-md-8 <?php if (form_error('hubungan')) {echo "has-error";} ?>">

									<select name="hubungan" id="hubungan" class="form-control">
										<option value="0">- Hubungan -</option>
										<option value="Suami" <?php echo set_select('hubungan', 'Suami'); ?>>Suami</option>
										<option value="Istri" <?php echo set_select('hubungan', 'Istri'); ?>>Istri</option>
									</select>

									<div class="invalid-feedback"><?= form_error('hubungan', '<div class="error">', '</div>') ?></div>

								</div>
							</div>

							<hr>

							<h4 class="box-title">Data Anak</h4>

							<div class="form-group">
								<label for="anak1" class="control-label col-md-2">Anak 1</label>
								<div class="col-md-8 <?php if (form_error('anak1')) {echo "has-error";} ?>">
									<input type="text" name="anak1" id="anak1" class="form-control" value="<?php echo set_value('anak1'); ?>" placeholder="Anak 1">
								</div>
							</div>

							<div class="form-group">
								<label for="anak2" class="control-label col-md-2">Anak 2</label>
								<div class="col-md-8 <?php if (form_error('anak2')) {echo "has-error";} ?>">
									<input type="text" name="anak2" id="anak2" class="form-control" value="<?php echo set_value('anak2'); ?>" placeholder="Anak 2">
								</div>
							</div>

							<div class="form-group">
								<label for="anak3" class="control-label col-md-2">Anak 3</label>
								<div class="col-md-8 <?php if (form_error('anak3')) {echo "has-error";} ?>">
									<input type="text" name="anak3" id="anak3" class="form-control" value="<?php echo set_value('anak3'); ?>" placeholder="Anak 3">
								</div>
							</div>

							<div class="form-group">
								<label for="anak4" class="control-label col-md-2">Anak 4</label>
								<div class="col-md-8 <?php if (form_error('anak4')) {echo "has-error";} ?>">
									<input type="text" name="anak4" id="anak4" class="form-control" value="<?php echo set_value('anak4'); ?>" placeholder="Anak 4">
								</div>
							</div>

							<div class="form-group">
								<label for="anak5" class="control-label col-md-2">Anak 5</label>
								<div class="col-md-8 <?php if (form_error('anak5')) {echo "has-error";} ?>">
									<input type="text" name="anak5" id="anak5" class="form-control" value="<?php echo set_value('anak5'); ?>" placeholder="Anak 5">
								</div>
							</div>

							<div class="form-group">
								<label for="lama_menetap" class="control-label col-md-2">Lama Tinggal Sejak</label>
								
								<div class="col-md-8 <?php if (form_error('lama_menetap')) {echo "has-error";} ?>">
									
									<div class="input-group date" id="datepicker_tgl_sprd">
                                                
                                    	<input type="text" class="form-control" id="lama_menetap" name="lama_menetap" value="<?php echo set_value('lama_menetap'); ?>" placeholder="Lama Tinggal Sejak" />

                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar">
                                            </span>
                            	        </span>

                                    </div>
									<small style="color:red;">(format : tgl/bln/thn)</small>
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
									<button onclick="return confirm('Save your data?')" name="submit" id = "submit" type="submit" class="peringatan btn btn-default"><i class="fa fa-save"></i> Submit</button>
									<button type="button" onClick="window.location='<?php echo site_url();?>penghuni';" class="btn btn-default"><i class="fa fa-undo"></i> Cancel</button>
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

				<!-- /.box-body -->
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

	<script src="<?php echo base_url(); ?>assets/templates/adminlte-2-3-11/dist/js/functions.js" type="text/javascript"></script>

	<script src="<?php echo base_url(); ?>assets/templates/adminlte-2-3-11/dist/js/toastr.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/templates/adminlte-2-3-11/dist/css/toastr.min.css">

	<script type="text/javascript">

		<?php //echo $message; ?>

		<?php if($this->session->flashdata('success')){ ?>
			toastr.success("<?php echo $this->session->flashdata('success'); ?>");
		<?php }else if($this->session->flashdata('error')){  ?>
			toastr.error("<?php echo $this->session->flashdata('error'); ?>");
		<?php }else if($this->session->flashdata('warning')){  ?>
			toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
		<?php }else if($this->session->flashdata('info')){  ?>
			toastr.info("<?php echo $this->session->flashdata('info'); ?>");
		<?php } ?>

	</script>

	<script type="text/javascript">

	$(document).ready(function(){

		$('#lama_menetap').datepicker({
			format: 'dd/mm/yyyy',
			viewMode: 'years',
			autoclose: true,
			todayHighlight: true,
			//startDate: new Date(),
			//endDate: new Date()
		});

	});
	</script>