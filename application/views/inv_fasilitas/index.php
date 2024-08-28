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
			<?php echo $message; ?>
			<!-- Insert New Data box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Tambah Fasilitas
					</h3>

					<div class="box-tools pull-right">
						<button class="btn btn-default btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button>
					</div>
				</div>

				<div class="box-body <?php if (!isset($open_form)){ echo "hide";} ?>" id="add_new">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

						<form action="<?php echo base_url('fasilitas/add') ?>" method="post" autocomplete="off" class="form form-horizontal" enctype="multipart/form-data">
							
							<div class="form-group">
								<label for="area_id" class="control-label col-md-2">* Area</label>
								<div class="col-md-8 <?php if (form_error('area_id')) {echo "has-error";} ?>">
								
									<select name="area_id" id="area_id" class="form-control" required>
										<option value="0">- Pilih Area -</option>

										<?php foreach ($data_list_area->result() as $val){ ?>
											<option value="<?php echo $val->id; ?>"><?php echo $val->nama_lokasi; ?></option>
										<?php } ?>

									</select>

								</div>
							</div>

							<div class="form-group">
								<label for="nama_fasilitas" class="control-label col-md-2">* Nama Fasilitas</label>
								<div class="col-md-8 <?php if (form_error('nama_fasilitas')) {echo "has-error";} ?>">
									<input type="text" name="nama_fasilitas" id="nama_fasilitas" class="form-control" value="<?php echo set_value('nama_fasilitas'); ?>" placeholder="Nama Fasilitas" required>
								</div>
							</div>
							
							<div class="form-group">
								<label for="detail" class="control-label col-md-2">Detail</label>
								<div class="col-md-8">
									<textarea name="detail" id="detail" class="form-control text_editor" rows="4" style="resize:vertical; min-height:100px; max-height:200px;"><?php echo set_value('detail'); ?></textarea>
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

			<!-- Default box -->
			<div class="box box-primary">

				<div class="box-header with-border">
					<h3 class="box-title">List Data fasilitas</h3>

					<div class="box-tools pull-right">

						<form action="<?php echo site_url('fasilitas/index'); ?>" class="form-inline" method="get">
								
							<div class="input-group" style="width: 250px;">
														
								<input type="text" class="form-control" name="q" value="<?php echo (isset($q)?$q:'') ?>" placeholder="Search...">
															
								<span class="input-group-btn">

									<button class="btn btn-primary" type="submit">Search</button>

									<?php 
                                    if (isset($q) <> ''){ 
									?>
                                    <a href="<?php echo site_url('fasilitas'); ?>" class="btn btn-default">Reset</a>
                                    <?php                        
									}
                                    ?>

								</span>
													
							</div>
						
						</form>

					</div>
				</div>

				<div class="box-body">
					<div class="table-responsive">
						<table class="table table-hover table-bordered table-striped">
							<thead>
								<tr>
									<th style="text-align:center">No.</th>
									<th style="text-align:center">Area</th>
									<th style="text-align:center">Nama Fasilitas</th>
									<th style="text-align:center">Detail</th>
									<th style="text-align:center">Photo</th>
									<th style="text-align:center">#</th>
								</tr>
							</thead>
							<tbody>
							<?php if (count($data_list->result())>0): 
								$numbering = $data_page;
								
								foreach ($data_list->result() as $data): 
									$numbering++;
							?>

								<tr>
									<td style="text-align:center"><?php echo $numbering; ?></td>
									<td><?php echo $data->nama_lokasi; ?></td>
									<td><?php echo $data->nama_fasilitas; ?></td>
									<td><?php echo $data->detail; ?></td>

									<td style="text-align:center"><?php if ($data->thumbnail!="") :?><a href="<?php echo base_url('assets/uploads/images/fasilitas/').$data->photo ?>" data-fancybox data-caption="<?php echo $data->nama_fasilitas ?>">
										<img src="<?php echo base_url('assets/uploads/images/fasilitas/').$data->thumbnail ?>" alt="<?php echo $data->nama_fasilitas ?>"></a><?php endif ?></td>
									
										<td width="5%" style="text-align:center">
										<form action="<?php echo base_url('fasilitas/delete/'.$data->id.'/'.$data->photo.'/'.$data->thumbnail) ?>" method="post" autocomplete="off">
											<div class="btn-group-vertical">
												<a class="btn btn-sm btn-primary" href="<?php echo base_url('fasilitas/edit/'.$data->id) ?>" role="button"><i class="fa fa-pencil"></i> Edit</a>
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
