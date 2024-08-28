	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				Categories
				<small>Group your inventory</small>
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-star"></i> &nbsp; Categories</li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Update Category Data box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">Edit Category
					</h3>

					<div class="box-tools pull-right">
						<!-- <button class="btn btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
					</div>
				</div>
				<div class="box-body">
					<?php echo $message;?>

					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<form action="<?php echo base_url('categories/edit/').$id ?>" method="post" autocomplete="off" class="form form-horizontal">
							<?php foreach ($data_list->result() as $data){
								$curr_code        = $data->code;
								$curr_name        = $data->name;
								$curr_description = $data->description;
							} ?>
							<div class="form-group">
								<label for="code" class="control-label col-md-2">Code</label>
								<div class="col-md-8">
									<p class="form-control-static"><?php echo $curr_code ?></p>
								</div>
							</div>
							<div class="form-group">
								<label for="name" class="control-label col-md-2">* Name</label>
								<div class="col-md-8 <?php if (form_error('name')) {echo "has-error";} ?>">
									<input type="text" name="name" id="name" class="form-control" value="<?php echo $curr_name ?>" placeholder="Category Name" required>
								</div>
							</div>
							<div class="form-group">
								<label for="description" class="control-label col-md-2">Description</label>
								<div class="col-md-8">
									<textarea name="description" id="description" class="form-control text_editor" rows="4" style="resize:vertical; min-height:100px; max-height:200px;"><?php echo $curr_description ?></textarea>
								</div>
							</div>
							<div class="form-group">
								<div class="col-md-8 col-md-offset-2">
									<button type="submit" class="btn btn-primary" onclick="return confirm('Save your data?')">Submit</button>
									<a class="btn btn-danger" href="<?php echo base_url('categories'); ?>" role="button">Cancel</a>
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