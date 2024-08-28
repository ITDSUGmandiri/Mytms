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
				Ticket
				<small>Transaksi / Ticket</small>
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-map-pin"></i>&nbsp; Transaksi</li>
				<li class="active">Ticket</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

		<?php //echo $message; ?>

			<!-- Insert New Data box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Tambah Ticket
					</h3>

					<div class="box-tools pull-right">
						<!--<button class="btn btn-default btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button>-->
					</div>
				</div>

				<div class="box-body <?php if (!isset($open_form)){ echo "hide";} ?>" id="add_new">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

						<form action="<?php echo base_url('ticket/add') ?>" method="post" autocomplete="off" class="form form-horizontal" enctype="multipart/form-data">
							
							<div class="form-group">
								<label for="pelapor" class="control-label col-md-2">* Pelapor</label>
								<div class="col-md-8">
									<textarea name="pelapor" id="pelapor" class="form-control text_editor" rows="4" style="resize:vertical; min-height:100px; max-height:200px;"><?php echo set_value('pelapor'); ?></textarea>
									<div class="invalid-feedback"><?= form_error('pelapor', '<div class="error">', '</div>') ?></div>
								</div>
							</div>

							<div class="form-group">
								<label for="job_detail" class="control-label col-md-2">* Laporan Problem</label>
								<div class="col-md-8">
									<textarea name="job_detail" id="job_detail" class="form-control text_editor" rows="4" style="resize:vertical; min-height:100px; max-height:200px;"><?php echo set_value('job_detail'); ?></textarea>
									<div class="invalid-feedback"><?= form_error('job_detail', '<div class="error">', '</div>') ?></div>
								</div>
							</div>

							<hr>

							<div class="form-group">
								<label for="id_lok" class="control-label col-md-2">* Area</label>
								<div class="col-md-8 <?php if (form_error('id_lok')) {echo "has-error";} ?>">
								
									<select name="id_lok" id="id_lok" class="form-control" required>
										<option value="0">- Pilih Area -</option>

										<?php foreach ($data_list_area->result() as $val){ ?>
											<option value="<?php echo $val->id; ?>" <?php echo set_select('id_lok', $val->id, False); ?>><?php echo $val->nama_lokasi; ?> </option> 
										<?php } ?>

									</select>

									<input type="hidden" name="nama_lokasi" id="nama_lokasi" value="">
									<input type="hidden" name="hidden_location" id="hidden_location" value="<?php echo set_value('id_lok'); ?>">
									<div class="invalid-feedback"><?= form_error('id_lok', '<div class="error">', '</div>') ?></div>

								</div>
							</div>

							<div class="form-group">
								<label for="id_unit" class="control-label col-md-2">* Unit</label>
								<div class="col-md-4">
									<select name="id_unit" id="id_unit" class="form-control select2 required" style="width:100%">
									</select>
									<input type="hidden" name="hidden_id_unit" id="hidden_id_unit" value="<?php echo set_value('id_unit'); ?>">
									<div class="invalid-feedback"><?= form_error('id_unit', '<div class="error">', '</div>') ?></div>
								</div>
							</div>

							<hr>

							<div class="form-group">
								<label for="service_family_id" class="control-label col-md-2">* Service Family</label>
								<div class="col-md-8 <?php if (form_error('service_family_id')) {echo "has-error";} ?>">
								
									<select name="service_family_id" id="service_family_id" class="form-control" required>
										<option value="0">- Pilih Service Family -</option>

										<?php foreach ($data_list_service_family->result() as $val){ ?>
											<option value="<?php echo $val->id_service_family; ?>" <?php echo set_select('service_family_id', $val->id_service_family, False); ?>><?php echo $val->service_family_name; ?> </option> 
										<?php } ?>

									</select>

									
									<div class="invalid-feedback"><?= form_error('service_family_id', '<div class="error">', '</div>') ?></div>

								</div>
							</div>

							<div class="form-group">
								<label for="type_incident" class="control-label col-md-2">* Type Incident</label>
								<div class="col-md-8 <?php if (form_error('type_incident')) {echo "has-error";} ?>">

									<select name="type_incident" id="type_incident" class="form-control select2">
										<option value="0">- Pilih Type Incident -</option>
									</select>

									<input type="hidden" name="hidden_type_incident_id" id="hidden_type_incident_id" value="<?php echo set_value('type_incident'); ?>">
									<div class="invalid-feedback"><?= form_error('type_incident', '<div class="error">', '</div>') ?></div>
								</div>
							</div>

							<hr>

							<div class="form-group">
								<label for="petugas1" class="control-label col-md-2">Petugas 1</label>
								<div class="col-md-8 <?php if (form_error('petugas1')) {echo "has-error";} ?>">

									<select name="petugas1" id="petugas1" class="form-control select2">
										<option value="0">- Pilih Petugas 1 -</option>
									</select>

									<input type="hidden" name="hidden_username1" id="hidden_username1" value="<?php echo set_value('hidden_username1'); ?>">

								</div>
							</div>

							<div class="form-group">
								<label for="petugas2" class="control-label col-md-2">Petugas 2</label>
								<div class="col-md-8 <?php if (form_error('petugas2')) {echo "has-error";} ?>">

									<select name="petugas2" id="petugas2" class="form-control select2">
										<option value="0">- Pilih Petugas 2 -</option>
									</select>

									<input type="hidden" name="hidden_username2" id="hidden_username2" value="<?php echo set_value('hidden_username2'); ?>">

								</div>
							</div>
							
							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
									<button onclick="return confirm('Save your data?')" name="submit" id = "submit" type="submit" class="peringatan btn btn-default"><i class="fa fa-save"></i> Submit</button>
									<button type="button" onClick="window.location='<?php echo site_url();?>ticket';" class="btn btn-default"><i class="fa fa-undo"></i> Cancel</button>
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

		load_dropdown_type_incident();
		load_dropdown_petugas1();
		load_dropdown_petugas2();

		$('#id_lok').change(function(){
			//nama_lokasi = $("#id_lok option:selected").text();
			//$('#nama_lokasi').val(nama_lokasi);
			load_dropdown_nama_unit(this.value);
		});

		let hidden_location = $('#hidden_location').val();

		if (hidden_location != ''){
			load_dropdown_nama_unit(hidden_location);
		}

		$('#service_family_id').change(function(){
			//nama_lokasi = $("#id_lok option:selected").text();
			//$('#nama_lokasi').val(nama_lokasi);
			//load_dropdown_nama_unit(this.value);
			load_dropdown_type_incident(this.value);
		});

		$('#petugas1').change(function(){
			
			$.get( "<?php echo site_url(); ?>ticket/getUsersTableById/" + this.value, function(data) {
  				var dataObj = JSON.parse(data);
  				$('#hidden_username1').val(dataObj.username);
			});

		});

		$('#petugas2').change(function(){
			
			$.get( "<?php echo site_url(); ?>ticket/getUsersTableById/" + this.value, function(data) {
				var dataObj = JSON.parse(data);
  				$('#hidden_username2').val(dataObj.username);
			});

		});

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

	function load_dropdown_petugas1(){
		
		//get a reference to the select element
		let $petugas1 = $('#petugas1');
		let hidden_petugas1_id = $('#hidden_petugas1_id').val();

		//request the JSON data and parse into the select element
		$.ajax({
		url:'<?php echo site_url() . 'ticket/load_dropdown_petugas1'; ?>',
		dataType: 'JSON', 
		success: function(data){

			//clear the current content of the select
			$petugas1.html('');
			$petugas1.append('<option value = "0">- Pilih Petugas 1 -</option>');
			//iterate over the data and append a select option
			$.each(data.list_data, function (key, val){

				if (hidden_petugas1_id == val.id){
					$petugas1.append('<option selected="selected" value = "' + val.id + '">' + val.first_name + ' ' + val.last_name + '</option>');
				} else {
					$petugas1.append('<option value = "' + val.id + '">' + val.first_name + ' ' + val.last_name + '</option>');
				}

			})

		}, 			
		error: function(){
			$petugas1.html('<option value = "-1">- Data tidak ada -</option>');
		}
							
		});

	}

	function load_dropdown_petugas2(){
		
		//get a reference to the select element
		let $petugas2 = $('#petugas2');
		let hidden_petugas2_id = $('#hidden_petugas2_id').val();

		//request the JSON data and parse into the select element
		$.ajax({
		url:'<?php echo site_url() . 'ticket/load_dropdown_petugas2'; ?>',
		dataType: 'JSON', 
		success: function(data){

			//clear the current content of the select
			$petugas2.html('');
			$petugas2.append('<option value = "0">- Pilih Petugas 2 -</option>');
			//iterate over the data and append a select option
			$.each(data.list_data, function (key, val){

				if (hidden_petugas2_id == val.id){
					$petugas2.append('<option selected="selected" value = "' + val.id + '">' + val.first_name + ' ' + val.last_name + '</option>');
				} else {
					$petugas2.append('<option value = "' + val.id + '">' + val.first_name + ' ' + val.last_name + '</option>');
				}

			})

		}, 			
		error: function(){
			$petugas2.html('<option value = "-1">- Data tidak ada -</option>');
		}
							
		});

	}

	function load_dropdown_type_incident(service_family_id){
		
		//get a reference to the select element
		let $type_incident = $('#type_incident');
		let hidden_type_incident_id = $('#hidden_type_incident_id').val();

		//request the JSON data and parse into the select element
		$.ajax({
		url:'<?php echo site_url() . 'ticket/load_dropdown_type_incident'; ?>',
		dataType: 'JSON', 
		data: {service_family_id: service_family_id},
		success: function(data){

			if (data.is_data_ada){

				//clear the current content of the select
				$type_incident.html('');
				$type_incident.append('<option value = "0">- Pilih Type Incident -</option>');
				//iterate over the data and append a select option
				$.each(data.list_data, function (key, val){

					if (hidden_type_incident_id == val.id){
						$type_incident.append('<option selected="selected" value = "' + val.id + '">' + val.type + '</option>');
					} else {
						$type_incident.append('<option value = "' + val.id + '">' + val.type + '</option>');
					}

				})
				
			} else {
				$type_incident.html('<option value = "-1">- Tidak ada data -</option>');
			}

		}, 			
		error: function(){
			$type_incident.html('<option value = "-1">- Data tidak ada -</option>');
		}
							
		});

	}
	</script>