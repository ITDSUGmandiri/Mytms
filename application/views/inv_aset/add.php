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
	Master Aset
    <small>Master Aset / Tambah Aset</small>
    </h1>
    <ol class="breadcrumb">
      <li class="active"><i class="fa fa-map-pin"></i>&nbsp;&nbsp;&nbsp;Master Aset</li>
      <li class="active">Tambah Aset</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

		<!-- Insert New Data box -->
		<div class="box">
			
			<div class="box-header with-border">
				<h3 class="box-title">Isi data pada form dengan lengkap dan benar
				</h3>

				<div class="box-tools pull-right">
					<button type="button" onClick="window.location='<?php echo site_url();?>aset';" class="btn btn-default"><i class="fa fa-undo"></i> Cancel</button>
				</div>
			</div>
			
			<div class="box-body" id="add_new">

        	<?php //echo $message; ?>

				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					
					<form id="input_form" action="<?php echo base_url('aset/add') ?>" method="post" autocomplete="off" class="form form-horizontal" enctype="multipart/form-data">
							
						<h3>Basic Info</h3>

							<fieldset>

								<div class="form-group">
									<label for="nomor_aset" class="control-label col-md-2">* Code / No. Aset</label>
									<div class="col-md-4">
										<input type="text" name="nomor_aset" id="nomor_aset" class="form-control <?php if (form_error('nomor_aset')) { echo 'error'; } ?>" value="<?php echo set_value('nomor_aset') ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="nama" class="control-label col-md-2">* Nama Aset</label>
									<div class="col-md-4">
										<input type="text" name="nama" id="nama" class="form-control <?php if (form_error('nama')) { echo 'error'; } ?>" value="<?php echo set_value('nama') ?>">
										<div class="invalid-feedback"><?= form_error('nama', '<div class="error">', '</div>') ?></div>
									</div>
								</div>
								<div class="form-group">
									<label for="bagian" class="control-label col-md-2">* Bagian Penempatan</label>
									<div class="col-md-4">
										<input type="text" name="bagian" id="bagian" class="form-control <?php if (form_error('bagian')) { echo 'error'; } ?>" value="<?php echo set_value('bagian') ?>">
										<div class="invalid-feedback"><?= form_error('bagian', '<div class="error">', '</div>') ?></div>
									</div>
								</div>
								<div class="form-group">
									<label for="merek" class="control-label col-md-2">Merek / Brand</label>
									<div class="col-md-8">
										<input type="text" name="merek" id="merek" class="form-control <?php if (form_error('merek')) { echo 'error'; } ?>" value="<?php echo set_value('merek') ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="model" class="control-label col-md-2">Model</label>
									<div class="col-md-8">
										<input type="text" name="model" id="model" class="form-control <?php if (form_error('model')) { echo 'error'; } ?>" value="<?php echo set_value('model') ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="bahan" class="control-label col-md-2">Bahan</label>
									<div class="col-md-8">
										<input type="text" name="bahan" id="bahan" class="form-control <?php if (form_error('bahan')) { echo 'error'; } ?>" value="<?php echo set_value('bahan') ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="kategori" class="control-label col-md-2">Jenis Aset</label>
									<div class="col-md-8">
										<input type="text" name="kategori" id="kategori" class="form-control <?php if (form_error('kategori')) { echo 'error'; } ?>" value="<?php echo set_value('kategori') ?>">
									</div>
								</div>
								<div class="form-group">
									<label for="serial_number" class="control-label col-md-2">Serial Number</label>
									<div class="col-md-8">
										<input type="text" name="serial_number" id="serial_number" class="form-control <?php if (form_error('serial_number')) { echo 'error'; } ?>" value="<?php echo set_value('serial_number') ?>">
									</div>
								</div>
								
								<hr>

								<div class="form-group">
									<label for="category" class="control-label col-md-2">* Category</label>
									<div class="col-md-8">
										<div class="row">
											<?php if (count($cat_list->result()) > 3): ?>
												<?php
												$batas = ceil(count($cat_list->result()) / 2);
												$xs = 0;
												foreach ($cat_list->result() as $cls2):
													// Flagging untuk menentukan jumlah data kategori
													$xs++;
													// Jika 1, col 1.
													if ($xs == 1) {
														echo "<div class='col-md-6'>";
													}
													// Jika sudah batas, col 2
													elseif ($xs == $batas + 1) {
														echo '</div>';
														echo "<div class='col-md-6'>";
													}
													?>
													<div class="radio">
														<label for="category2_<?php echo $cls2->id; ?>">
															<input type="radio" name="category2" id="category2_<?php echo $cls2->id; ?>" value="<?php echo $cls2->id; ?>" <?php echo set_radio('category2', $cls2->id); ?>>
															<?php echo $cls2->name ?>
														</label>
													</div>
												<?php
												endforeach;
												echo '</div>';
																							?>
											<?php else: ?>
												<div class="col-md-12">
												<?php $xs = 0;
												foreach ($cat_list->result() as $cls2):
													$xs++; ?>
													<div class="radio">
														<label for="category2_<?php echo $cls2->id; ?>">
															<input type="radio" name="category2" id="category2_<?php echo $cls2->id; ?>" value="<?php echo $cls2->id; ?>"  <?php echo set_radio('category2', $cls2->id); ?>>
															<?php echo $cls2->name ?>
														</label>
													</div>
												<?php endforeach; ?>
												</div>
											<?php endif; ?>
										</div>
									</div>

									<?php  /* ?>
									 <!-- <div class="col-md-4">
										 <select name="category" id="category" class="form-control select2 required" style="width:100%">
											 <?php foreach ($cat_list->result() as $cls) {
												 echo "<option value='".$cls->id."'>".$cls->name."</option>";
												 } ?>
										 </select>
									 </div> --> <?php */
									?>

								</div>

								<div class="form-group">
									<label for="status" class="control-label col-md-2">* Status</label>
									<div class="col-md-8">
										<div class="row">
											<?php if (count($stat_list->result()) > 3): ?>
												<?php
												$batas = ceil(count($stat_list->result()) / 2);
												$xs = 0;
												foreach ($stat_list->result() as $sls2):
													// Flagging untuk menentukan jumlah data status
													$xs++;
													// Jika 1, col 1.
													if ($xs == 1) {
														echo "<div class='col-md-6'>";
													}
													// Jika sudah batas, col 2
													elseif ($xs == $batas + 1) {
														echo '</div>';
														echo "<div class='col-md-6'>";
													}
													?>
													<div class="radio">
														<label for="status2_<?php echo $sls2->id; ?>">
															<input type="radio" name="status2" id="status2_<?php echo $sls2->id; ?>" value="<?php echo $sls2->id; ?>" <?php echo set_radio('status2', $sls2->id); ?>>
															<?php echo $sls2->name ?>
														</label>
													</div>
												<?php
												endforeach;
												echo '</div>';
																							?>
											<?php else: ?>
												<div class="col-md-12">
												<?php $xs = 0;
												foreach ($stat_list->result() as $sls2):
													$xs++; ?>
													<div class="radio">
														<label for="status2_<?php echo $sls2->id; ?>">
															<input type="radio" name="status2" id="status2_<?php echo $sls2->id; ?>" value="<?php echo $sls2->id; ?>" <?php echo set_radio('status2', $sls2->id); ?>>
															<?php echo $sls2->name ?>
														</label>
													</div>
												<?php endforeach; ?>
												</div>
											<?php endif; ?>
										</div>
									</div>

									<?php  /* ?>
									 <div class="col-md-4">
										 <select name="status" id="status" class="form-control select2 required" style="width:100%">
											 <?php foreach ($stat_list->result() as $sls) {
												 echo "<option value='".$sls->id."'>".$sls->name."</option>";
												 } ?>
										 </select>
									 </div><?php */
									?>

								</div>
								<div class="form-group">
									<label for="location" class="control-label col-md-2">* Location</label>
									<div class="col-md-4">
										<select name="location" id="location" class="form-control select2 required" style="width:100%">
											<?php foreach ($loc_list->result() as $lls) {
												echo "<option value='" . $lls->id . "' " . set_select('location', $lls->id) . '>' . $lls->nama_lokasi . '</option>';
											} ?>
										</select>
										<input type="hidden" name="hidden_location" id="hidden_location" value="<?php echo set_value('location') ?>">
									</div>
								</div>

								<div class="form-group">
									<label for="id_unit" class="control-label col-md-2">* Unit</label>
									<div class="col-md-4">
										<select name="id_unit" id="id_unit" class="form-control select2 required" style="width:100%">
										</select>
										<input type="hidden" name="hidden_id_unit" id="hidden_id_unit" value="<?php echo set_value('id_unit'); ?>">
									</div>
								</div>
								
								<div class="form-group">
									<p class="col-md-8 col-md-offset-2">(*) Mandatory</p>
								</div>

							</fieldset>

							<h3>Specifications</h3>

							<fieldset>

								<div class="form-group">

									<label for="color" class="control-label col-md-2">Color</label>

									<div class="col-md-4">
										<div id="color_container">
											<select name="color" id="color" class="form-control select2 required" style="width:100%">
												<?php foreach ($col_list->result() as $crl) {
													echo "<option value='" . $crl->name . "' " . set_select('color', $crl->name) . '>' . $crl->name . '</option>';
												} ?>
											</select>
										</div>
										<input type="text" name="new_color" id="new_color" class="form-control" maxlength="30" placeholder="New Color" style="display:none">
									</div>

									<div class="col-md-6">
										<label for="color_switch">
											<input type="checkbox" name="color_switch" id="color_switch" value="color_switch">
											New Color
										</label>
									</div>
								</div>
								<hr>
								<div class="form-group">
									<label for="length" class="control-label col-md-2">Length</label>
									<div class="col-md-4">
										<div class="input-group">
											<input type="number" name="length" id="length" class="form-control" maxlength="12" min="0" value="<?php echo set_value('length') ?>">
											<span class="input-group-addon">Cm</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="width" class="control-label col-md-2">Width</label>
									<div class="col-md-4">
										<div class="input-group">
											<input type="number" name="width" id="width" class="form-control" maxlength="12" min="0" value="<?php echo set_value('width') ?>">
											<span class="input-group-addon">Cm</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="height" class="control-label col-md-2">Height</label>
									<div class="col-md-4">
										<div class="input-group">
											<input type="number" name="height" id="height" class="form-control" maxlength="12" min="0" value="<?php echo set_value('height') ?>">
											<span class="input-group-addon">Cm</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="weight" class="control-label col-md-2">Weight</label>
									<div class="col-md-4">
										<div class="input-group">
											<input type="number" name="weight" id="weight" class="form-control" maxlength="12" min="0" value="<?php echo set_value('weight') ?>">
											<span class="input-group-addon">Kg</span>
										</div>
									</div>
								</div>

								<hr>

								<div class="form-group">
									<label for="kondisi" class="control-label col-md-2">Kondisi</label>
									<div class="col-md-4">
										<div class="input-group">
											<input type="number" name="kondisi" id="kondisi" class="form-control" maxlength="12" min="0" value="<?php echo set_value('kondisi') ?>">
											<span class="input-group-addon">%</span>
										</div>
									</div>
								</div>

							</fieldset>

							<h3>Additional Info</h3>

							<fieldset>
								<div class="form-group">
									<label for="harga_beli" class="control-label col-md-2">Harga Beli</label>
									<div class="col-md-4">
										<div class="input-group">
											<span class="input-group-addon">Rp</span>
											<input type="text" name="harga_beli" id="harga_beli" class="form-control" value="<?php echo set_value('harga_beli') ?>">
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<label for="tgl_beli" class="control-label col-md-2">Tanggal Perolehan</label>
									<div class="col-md-4">
										<div class="input-group">
											<input type="text" name="tgl_beli" id="datepicker_tgl_beli" class="form-control" value="<?php echo set_value('tgl_beli') ?>">
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
										</div>
									</div>
								</div>
								
								<hr>

								<div class="form-group">
									<label for="deskripsi" class="control-label col-md-2">Description</label>
									<div class="col-md-10">
										<textarea name="deskripsi" id="deskripsi" class="form-control text_editor" rows="4" style="resize:vertical; min-height:100px; max-height:200px;"><?php echo set_value('deskripsi') ?></textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="photo" class="control-label col-md-2">Photo</label>
									<div class="col-md-10">
										<input type="file" name="photo" id="photo" class="form-control">
									</div>
								</div>
								<!-- <div class="form-group">
									<div class="col-md-8 col-md-offset-2">
										<button type="submit" class="btn btn-primary">Submit</button>
									</div>
								</div> -->
							</fieldset>
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

<script>
	$(document).ready(function() {

		$("#datepicker_tgl_beli").datepicker({
			format: 'dd/mm/yyyy',
			viewMode: 'years',
			autoclose: true,
			todayHighlight: true,
			//startDate: new Date(),
			endDate: new Date()
		});

	});
</script>

<script type="text/javascript">
	
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

		$('#location').on('change', function(){
			load_dropdown_nama_unit(this.value);
		});

		$('#harga_beli').keyup(function(){
			FormNum(this);
		});

		let hidden_location = $('#hidden_location').val();

		if (hidden_location != ''){
			load_dropdown_nama_unit(hidden_location);
		}

	});
	
	function load_dropdown_nama_unit(id_lok){
		
		//get a reference to the select element
		var $id_unit = $('#id_unit');
    	$("#id_unit").html('<option value="0">Loading...</option>');

		let hidden_id_unit = $("#hidden_id_unit").val();

		$.ajax({
		method: "POST",
		url:'<?php echo site_url() . 'unit/load_dropdown_nama_unit'; ?>',
		dataType: 'JSON', 
		data: {id_lok: id_lok},	
		success: function(data){

			if (data.is_data_ada){

				//clear the current content of the select
				$id_unit.html('');
				$id_unit.append('<option value = "0">- Silahkan Pilih -</option>');

				//iterate over the data and append a select option

				$.each(data.list_data, function (key, val){

					if (hidden_id_unit == val.id){
						$id_unit.append('<option selected="selected" value = "' + val.id + '">' + val.nama_unit + '</option>');
					} else {
						$id_unit.append('<option value = "' + val.id + '">' + val.nama_unit + '</option>');
					}

				});

			} else {
				$id_unit.html('<option value = "0">- Tidak Ada Unit -</option>');
			}

		}, 				
		error: function(){
			//if there is an error append a 'none available' option
			$id_unit.html('<option value = "0">- Tidak Ada Unit -</option>');
		}

		});

	}

</script>