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
				Unit
				<small>Master Data / Unit</small>
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-map-pin"></i>&nbsp; Master Data</li>
				<li class="active">Unit</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

		<?php //echo $message; ?>

			<!-- Insert New Data box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Tambah Unit
					</h3>

					<div class="box-tools pull-right">
						<!--<button class="btn btn-default btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button>-->
					</div>
				</div>

				<div class="box-body <?php if (!isset($open_form)){ echo "hide";} ?>" id="add_new">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

						<form action="<?php echo base_url('unit/add') ?>" method="post" autocomplete="off" class="form form-horizontal" enctype="multipart/form-data">
							
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
									<div class="invalid-feedback"><?= form_error('id_lok', '<div class="error">', '</div>') ?></div>

								</div>
							</div>

							<div class="form-group">
								<label for="nama_unit" class="control-label col-md-2">* Nama Unit</label>
								<div class="col-md-8 <?php if (form_error('nama_unit')) {echo "has-error";} ?>">
									<input type="text" name="nama_unit" id="nama_unit" class="form-control" value="<?php echo set_value('nama_unit'); ?>" placeholder="Nama Unit">
									<div class="invalid-feedback"><?= form_error('nama_unit', '<div class="error">', '</div>') ?></div>
								</div>
							</div>

							<div class="form-group">
								<label for="blok" class="control-label col-md-2">* Blok</label>
								<div class="col-md-8 <?php if (form_error('blok')) {echo "has-error";} ?>">
									<input type="text" name="blok" id="blok" class="form-control" value="<?php echo set_value('blok'); ?>" placeholder="Blok">
									<div class="invalid-feedback"><?= form_error('blok', '<div class="error">', '</div>') ?></div>
								</div>
							</div>

							<div class="form-group">
								<label for="no_unit" class="control-label col-md-2">* No. Unit</label>
								<div class="col-md-8 <?php if (form_error('no_unit')) {echo "has-error";} ?>">
									<input type="text" name="no_unit" id="no_unit" class="form-control" value="<?php echo set_value('no_unit'); ?>" placeholder="No. Unit">
									<div class="invalid-feedback"><?= form_error('no_unit', '<div class="error">', '</div>') ?></div>
								</div>
							</div>

							<div class="form-group">
								<label for="lantai" class="control-label col-md-2">* Lantai</label>
								<div class="col-md-8 <?php if (form_error('lantai')) {echo "has-error";} ?>">
									<input type="number" min="0" maxlength="50" name="lantai" id="lantai" class="form-control" value="<?php echo set_value('lantai'); ?>" placeholder="Lantai">
									<div class="invalid-feedback"><?= form_error('lantai', '<div class="error">', '</div>') ?></div>
								</div>
							</div>

							<div class="form-group">
								<label for="status_unit" class="control-label col-md-2">* Status Unit</label>
								<div class="col-md-8 <?php if (form_error('status_unit')) {echo "has-error";} ?>">

									<select name="status_unit" id="status_unit" class="form-control">
									</select>
									<input type="hidden" name="hidden_status_unit" id="hidden_status_unit" value="<?php echo set_value('status_unit'); ?>">

									<div class="invalid-feedback"><?= form_error('status_unit', '<div class="error">', '</div>') ?></div>

								</div>
							</div>

							<div class="form-group">
								<label for="penghuni_id" class="control-label col-md-2">Penghuni</label>
								<div class="col-md-8 <?php if (form_error('penghuni_id')) {echo "has-error";} ?>">

									<select name="penghuni_id" id="penghuni_id" class="form-control select2">
										<option value="0">- Pilih Penghuni -</option>
									</select>

									<input type="hidden" name="hidden_penghuni_id" id="hidden_penghuni_id" value="<?php echo set_value('penghuni_id'); ?>">
									<input type="hidden" name="kode_penghuni" id="kode_penghuni" value="0">
									<input type="hidden" name="penghuni" id="penghuni" value="0">

								</div>
							</div>

							<hr>

							<div class="form-group">
								<label for="dok" class="control-label col-md-2">No. SPRD</label>
								<div class="col-md-8 <?php if (form_error('dok')) {echo "has-error";} ?>">
									<input type="text" name="dok" id="dok" class="form-control" value="<?php echo set_value('dok'); ?>" placeholder="No. SPRD">
								</div>
							</div>

							<div class="form-group">
								<label for="tgl_sprd" class="control-label col-md-2">Tanggal SPRD</label>
								
								<div class="col-md-8 <?php if (form_error('tgl_sprd')) {echo "has-error";} ?>">
									
									<div class="input-group date" id="datepicker_tgl_sprd">
                                                
                                    	<input type="text" class="form-control" id="tgl_sprd" name="tgl_sprd" value="<?php echo set_value('tgl_sprd'); ?>" placeholder="Tanggal SPRD" />

                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar">
                                            </span>
                            	        </span>

                                    </div>
									<small style="color:red;">(format : tgl/bln/thn)</small>
								</div>

							</div>

							<div class="form-group">
								<label for="no_bast" class="control-label col-md-2">No. BAST Masuk</label>
								<div class="col-md-8 <?php if (form_error('no_bast')) {echo "has-error";} ?>">
									<input type="text" name="no_bast" id="no_bast" class="form-control" value="<?php echo set_value('no_bast'); ?>" placeholder="No. BAST Masuk">
								</div>
							</div>

							<div class="form-group">
								<label for="tgl_bast" class="control-label col-md-2">Tanggal BAST Masuk</label>
								
								<div class="col-md-8 <?php if (form_error('tgl_bast')) {echo "has-error";} ?>">
									
									<div class="input-group date" id="datepicker_tgl_bast">
                                                
                                    	<input type="text" class="form-control" id="tgl_bast" name="tgl_bast" value="<?php echo set_value('tgl_bast'); ?>" placeholder="Tanggal BAST Masuk" />

                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar">
                                            </span>
                            	        </span>

                                    </div>
									<small style="color:red;">(format : tgl/bln/thn)</small>
								</div>

							</div>

							<div class="form-group">
								<label for="wilayah" class="control-label col-md-2">Wilayah</label>
								<div class="col-md-8 <?php if (form_error('wilayah')) {echo "has-error";} ?>">

									<select name="wilayah" id="wilayah" class="form-control" required>
										<option value="0">- Wilayah -</option>
									</select>

									<input type="hidden" name="hidden_wilayah" id="hidden_wilayah" value="<?php echo set_value('wilayah'); ?>">

								</div>
							</div>

							<div class="form-group">
								<label for="kondisi" class="control-label col-md-2">* Kondisi Rumah Dinas</label>
								<div class="col-md-8 <?php if (form_error('kondisi')) {echo "has-error";} ?>">

									<select name="kondisi" id="kondisi" class="form-control" required>
										<option value="0">- Pilih Kondisi -</option>
									</select>

									<input type="hidden" name="hidden_kondisi" id="hidden_kondisi" value="<?php echo set_value('kondisi'); ?>">
									<div class="invalid-feedback"><?= form_error('kondisi', '<div class="error">', '</div>') ?></div>

								</div>
							</div>

							<div class="form-group">
								<label for="masuk" class="control-label col-md-2">Tanggal Masuk</label>
								
								<div class="col-md-8 <?php if (form_error('masuk')) {echo "has-error";} ?>">
									
									<div class="input-group date" id="datepicker_tgl_masuk">
                                                
                                    	<input type="text" class="form-control" id="masuk" name="masuk" value="<?php echo set_value('masuk'); ?>" placeholder="Tanggal Masuk" />

                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar">
                                            </span>
                            	        </span>

                                    </div>
									<small style="color:red;">(format : tgl/bln/thn)</small>
								</div>

							</div>

							<div class="form-group">
								<label for="keluar" class="control-label col-md-2">Tanggal Keluar</label>
								
								<div class="col-md-8 <?php if (form_error('keluar')) {echo "has-error";} ?>">
									
									<div class="input-group date" id="datepicker_tgl_keluar">
                                                
                                    	<input type="text" class="form-control" id="keluar" name="keluar" value="<?php echo set_value('keluar'); ?>" placeholder="Tanggal Keluar" />

                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar">
                                            </span>
                            	        </span>

                                    </div>
									<small style="color:red;">(format : tgl/bln/thn)</small>
								</div>

							</div>

							<div class="form-group">
								<label for="tgl_perbaikan" class="control-label col-md-2">Tanggal Perbaikan</label>
								
								<div class="col-md-8 <?php if (form_error('tgl_perbaikan')) {echo "has-error";} ?>">
									
									<div class="input-group date" id="datepicker_tgl_perbaikan">
                                                
                                    	<input type="text" class="form-control" id="tgl_perbaikan" name="tgl_perbaikan" value="<?php echo set_value('tgl_perbaikan'); ?>" placeholder="Tanggal Perbaikan" />

                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar">
                                            </span>
                            	        </span>

                                    </div>
									<small style="color:red;">(format : tgl/bln/thn)</small>
								</div>

							</div>
							
							<div class="form-group">
									<label for="nominal_rab" class="control-label col-md-2">Nominal RAB</label>
									<div class="col-md-8 <?php if (form_error('nominal_rab')) {echo "has-error";} ?>">
										<div class="input-group">
											<span class="input-group-addon">Rp</span>
											<input type="text" name="nominal_rab" id="nominal_rab" class="form-control" maxlength="12" min="0" value="<?php echo set_value('nominal_rab') ?>" placeholder="Nominal RAB">
										</div>
									</div>
								</div>

							<div class="form-group">
								<label for="nominal_spk" class="control-label col-md-2">Nominal SPK</label>
								
									<div class="col-md-8 <?php if (form_error('nominal_spk')) {echo "has-error";} ?>">
										<div class="input-group">
											<span class="input-group-addon">Rp</span>
											<input type="text" name="nominal_spk" id="nominal_spk" class="form-control" maxlength="12" min="0" value="<?php echo set_value('nominal_spk'); ?>" placeholder="Nominal SPK">
										</div>
									</div>	
							</div>

							<div class="form-group">
								<label for="kontraktor" class="control-label col-md-2">Kontraktor</label>
								<div class="col-md-8 <?php if (form_error('kontraktor')) {echo "has-error";} ?>">
									<input type="text" name="kontraktor" id="kontraktor" class="form-control" value="<?php echo set_value('kontraktor'); ?>" placeholder="Kontraktor">
								</div>
							</div>
							
							<hr>

							<div class="form-group">
								<label for="id_listrik" class="control-label col-md-2">ID Listrik</label>
								<div class="col-md-8 <?php if (form_error('id_listrik')) {echo "has-error";} ?>">
									<input type="text" name="id_listrik" id="id_listrik" class="form-control" value="<?php echo set_value('id_listrik'); ?>" placeholder="ID Listrik">
								</div>
							</div>
							
							<div class="form-group">
								<label for="id_pam" class="control-label col-md-2">ID PAM</label>
								<div class="col-md-8 <?php if (form_error('id_pam')) {echo "has-error";} ?>">
									<input type="text" name="id_pam" id="id_pam" class="form-control" value="<?php echo set_value('id_pam'); ?>" placeholder="ID PAM">
								</div>
							</div>

							<div class="form-group">
								<label for="id_telp" class="control-label col-md-2">ID Telp</label>
								<div class="col-md-8 <?php if (form_error('id_telp')) {echo "has-error";} ?>">
									<input type="text" name="id_telp" id="id_telp" class="form-control" value="<?php echo set_value('id_telp'); ?>" placeholder="ID Telp">
								</div>
							</div>

							<div class="form-group">
								<label for="id_internet1" class="control-label col-md-2">ID Internet 1</label>
								<div class="col-md-8 <?php if (form_error('id_internet1')) {echo "has-error";} ?>">
									<input type="text" name="id_internet1" id="id_internet1" class="form-control" value="<?php echo set_value('id_internet1'); ?>" placeholder="ID Internet 1">
								</div>
							</div>

							<div class="form-group">
								<label for="id_internet2" class="control-label col-md-2">ID Internet 2</label>
								<div class="col-md-8 <?php if (form_error('id_internet2')) {echo "has-error";} ?>">
									<input type="text" name="id_internet2" id="id_internet2" class="form-control" value="<?php echo set_value('id_internet2'); ?>" placeholder="ID Internet 2">
								</div>
							</div>

							<div class="form-group">
								<label for="id_internet3" class="control-label col-md-2">ID Internet 3</label>
								<div class="col-md-8 <?php if (form_error('id_internet3')) {echo "has-error";} ?>">
									<input type="text" name="id_internet3" id="id_internet3" class="form-control" value="<?php echo set_value('id_internet3'); ?>" placeholder="ID Internet 3">
								</div>
							</div>

							<div class="form-group">
								<label for="id_internet4" class="control-label col-md-2">ID Internet 4</label>
								<div class="col-md-8 <?php if (form_error('id_internet4')) {echo "has-error";} ?>">
									<input type="text" name="id_internet4" id="id_internet4" class="form-control" value="<?php echo set_value('id_internet4'); ?>" placeholder="ID Internet 4">
								</div>
							</div>

							<div class="form-group">
								<label for="daya_listrik" class="control-label col-md-2">Daya Listrik</label>
								<div class="col-md-8 <?php if (form_error('daya_listrik')) {echo "has-error";} ?>">
									<input type="text" name="daya_listrik" id="daya_listrik" class="form-control" value="<?php echo set_value('daya_listrik'); ?>" placeholder="Daya Listrik">
								</div>
							</div>

							<hr>

							<div class="form-group">
								<label for="hak_menempati" class="control-label col-md-2">* Hak Menempati</label>
								<div class="col-md-8 <?php if (form_error('hak_menempati')) {echo "has-error";} ?>">

									<select name="hak_menempati" id="hak_menempati" class="form-control">
										<option value="0">- Pilih Hak Menempati -</option>
										<option value="Ya" <?php echo set_select('hak_menempati', 'Ya'); ?>>Ya</option>
										<option value="Tidak" <?php echo set_select('hak_menempati', 'Tidak'); ?>>Tidak</option>
									</select>

									<div class="invalid-feedback"><?= form_error('hak_menempati', '<div class="error">', '</div>') ?></div>

								</div>
							</div>

							<div class="form-group">
								<label for="klasifikasi_id" class="control-label col-md-2">* Klasifikasi</label>
								<div class="col-md-8 <?php if (form_error('klasifikasi_id')) {echo "has-error";} ?>">

									<select name="klasifikasi_id" id="klasifikasi_id" class="form-control">
										<option value="0">- Pilih Klasifikasi -</option>
									</select>

									<div class="invalid-feedback"><?= form_error('klasifikasi_id', '<div class="error">', '</div>') ?></div>

									<input type="hidden" name="hidden_klasifikasi_id" id="hidden_klasifikasi_id" value="<?php echo set_value('klasifikasi_id'); ?>">
									<input type="hidden" name="klasifikasi" id="klasifikasi" value="0">

								</div>
							</div>

							<div class="form-group">
								<label for="keterangan" class="control-label col-md-2">Catatan</label>
								<div class="col-md-8">
									<textarea name="keterangan" id="keterangan" class="form-control text_editor" rows="4" style="resize:vertical; min-height:100px; max-height:200px;"><?php echo set_value('keterangan'); ?></textarea>
								</div>
							</div>

							<div class="form-group">
								<label for="alamat_lengkap" class="control-label col-md-2">Alamat Lengkap</label>
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
									<button onclick="return confirm('Save your data?')" name="submit" id = "submit" type="submit" class="peringatan btn btn-default"><i class="fa fa-save"></i> Submit</button>
									<button type="button" onClick="window.location='<?php echo site_url();?>unit';" class="btn btn-default"><i class="fa fa-undo"></i> Cancel</button>
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

		load_dropdown_status_hunian();
		load_dropdown_penghuni();
		load_dropdown_wilayah();
		load_dropdown_kondisi();
		load_dropdown_klasifikasi();

		$('#tgl_sprd').datepicker({
			format: 'dd/mm/yyyy',
			viewMode: 'years',
			autoclose: true,
			todayHighlight: true,
			//startDate: new Date(),
			//endDate: new Date()
		});

		$('#tgl_bast').datepicker({
			format: 'dd/mm/yyyy',
			viewMode: 'years',
			autoclose: true,
			todayHighlight: true,
			//startDate: new Date(),
			//endDate: new Date()
		});
	
		$('#masuk').datepicker({
			format: 'dd/mm/yyyy',
			viewMode: 'years',
			autoclose: true,
			todayHighlight: true,
			//startDate: new Date(),
			//endDate: new Date()
		});

		$('#keluar').datepicker({
			format: 'dd/mm/yyyy',
			viewMode: 'years',
			autoclose: true,
			todayHighlight: true,
			//startDate: new Date(),
			//endDate: new Date()
		});

		$('#tgl_perbaikan').datepicker({
			format: 'dd/mm/yyyy',
			viewMode: 'years',
			autoclose: true,
			todayHighlight: true,
			//startDate: new Date(),
			//endDate: new Date()
		});

		$('#id_lok').change(function(){
			
			nama_lokasi = $("#id_lok option:selected").text();
			$('#nama_lokasi').val(nama_lokasi);

		});

		$('#penghuni_id').change(function(){
			
			penghuni = $("#penghuni_id option:selected").text();
			$('#penghuni').val(penghuni);

			var penghuni_id = $('#penghuni_id').val();
			
			$.getJSON('<?php echo site_url() . '/unit/getDataPenghuni/'; ?>/' + penghuni_id,
			function(json)
			{
    						
				if (json == null)
				{
					alert("Data penghuni tidak ditemukan");
    			} 
				else
				{
					
					$('#kode_penghuni').val(json.list_data[0].kode);
													
    			}
    		});

		});

		$('#nominal_rab,#nominal_spk').keyup(function(){
			FormNum(this);
		});

	});

	function load_dropdown_status_hunian(){
		
		//get a reference to the select element
		let $status_unit = $('#status_unit');
		let hidden_status_unit = $('#hidden_status_unit').val();

		//request the JSON data and parse into the select element
		$.ajax({
		url:'<?php echo site_url() . 'inventory/load_dropdown_status'; ?>',
		dataType: 'JSON', 
		success: function(data){

			//clear the current content of the select
			$status_unit.html('');
			$status_unit.append('<option value = "0">- Pilih Status -</option>');
			//iterate over the data and append a select option
			$.each(data.list_data, function (key, val){

				if (hidden_status_unit == val.id){
					$status_unit.append('<option selected="selected" value = "' + val.id + '">' + val.status_detail + '</option>');
				} else {
					$status_unit.append('<option value = "' + val.id + '">' + val.status_detail + '</option>');
				}

			})

		}, 			
		error: function(){
			$status_unit.html('<option value = "-1">- Data tidak ada -</option>');
		}
							
		});

	}

	function load_dropdown_penghuni(){
		
		//get a reference to the select element
		let $penghuni_id = $('#penghuni_id');
		let hidden_penghuni_id = $('#hidden_penghuni_id').val();

		//request the JSON data and parse into the select element
		$.ajax({
		url:'<?php echo site_url() . 'unit/load_dropdown_penghuni'; ?>',
		dataType: 'JSON', 
		success: function(data){

			//clear the current content of the select
			$penghuni_id.html('');
			$penghuni_id.append('<option value = "0">- Pilih Penghuni -</option>');
			//iterate over the data and append a select option
			$.each(data.list_data, function (key, val){

				if (hidden_penghuni_id == val.id){
					$penghuni_id.append('<option selected="selected" value = "' + val.id + '">' + val.nama + '</option>');
				} else {
					$penghuni_id.append('<option value = "' + val.id + '">' + val.nama + '</option>');
				}

			})

		}, 			
		error: function(){
			$penghuni_id.html('<option value = "-1">- Data tidak ada -</option>');
		}
							
		});

	}

	function load_dropdown_wilayah(){
		
		//get a reference to the select element
		var $wilayah = $('#wilayah');
		let hidden_wilayah = $('#hidden_wilayah').val();

		//request the JSON data and parse into the select element
		$.ajax({
		url:'<?php echo site_url() . 'unit/load_dropdown_wilayah'; ?>',
		dataType: 'JSON', 
		success: function(data){

			//clear the current content of the select
			$wilayah.html('');
			$wilayah.append('<option value = "0">- Pilih Wilayah -</option>');
			//iterate over the data and append a select option
			$.each(data.list_data, function (key, val){

				if (hidden_wilayah == val.wilayah){
					$wilayah.append('<option selected="selected" value = "' + val.wilayah + '">' + val.wilayah + '</option>');
				} else {
					$wilayah.append('<option value = "' + val.wilayah + '">' + val.wilayah + '</option>');
				}
				
			})

		}, 			
		error: function(){
			$wilayah.html('<option value = "-1">- Data tidak ada -</option>');
		}
							
		});

	}

	function load_dropdown_kondisi(){
		
		//get a reference to the select element
		var $kondisi = $('#kondisi');
		let hidden_kondisi = $('#hidden_kondisi').val();

		//request the JSON data and parse into the select element
		$.ajax({
		url:'<?php echo site_url() . 'unit/load_dropdown_kondisi'; ?>',
		dataType: 'JSON', 
		success: function(data){

			//clear the current content of the select
			$kondisi.html('');
			$kondisi.append('<option value = "0">- Pilih Kondisi -</option>');
			//iterate over the data and append a select option
			$.each(data.list_data, function (key, val){

				if (hidden_kondisi == val.id){
					$kondisi.append('<option selected="selected" value = "' + val.id + '">' + val.kondisi + '</option>');
				} else {
					$kondisi.append('<option value = "' + val.id + '">' + val.kondisi + '</option>');
				}

			})

		}, 			
		error: function(){
			$kondisi.html('<option value = "-1">- Data tidak ada -</option>');
		}
							
		});
	
	}

	function load_dropdown_klasifikasi(){
		
	
		//get a reference to the select element
		let $klasifikasi_id = $('#klasifikasi_id');
		let hidden_klasifikasi_id = $('#hidden_klasifikasi_id').val();
	
		//request the JSON data and parse into the select element
	
		$.ajax({
	
			url:'<?php echo site_url() . 'unit/load_dropdown_klasifikasi'; ?>',
			dataType: 'JSON', 
			success: function(data){

				//clear the current content of the select
				$klasifikasi_id.html('');
				$klasifikasi_id.append('<option value = "0">- Pilih Klasifikasi -</option>');
				//iterate over the data and append a select option
				$.each(data.list_data, function (key, val){

					if (hidden_klasifikasi_id == val.id){
						$klasifikasi_id.append('<option selected="selected" value = "' + val.id + '">' + val.klasifikasi + '</option>');
					} else {
						$klasifikasi_id.append('<option value = "' + val.id + '">' + val.klasifikasi + '</option>');
					}

				})

			}, 			
			error: function(){
				$klasifikasi_id.html('<option value = "-1">- Data tidak ada -</option>');
			}
							
		});

	}
	</script>