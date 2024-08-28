	<!-- =========================== CONTENT =========================== -->

	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				<?php echo lang('index_heading');?>
				<small><?php echo lang('index_subheading');?></small>
			</h1>
			<ol class="breadcrumb">
				<li class="active"><i class="fa fa-users"></i> <?php echo lang('index_heading');?></li>
			</ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<!-- Default box -->
			<div class="box">
				<div class="box-header with-border">
					<h3 class="box-title">
						<a class="btn btn-primary" href="<?php echo base_url('auth/create_user') ?>" role="button"><?php echo lang('index_create_user_link') ?></a>
						<a class="btn btn-default" href="<?php echo base_url('auth/create_group') ?>" role="button"><?php echo lang('index_create_group_link') ?></a>
					</h3>

					<div class="box-tools pull-right">
						<button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
					</div>
				</div>
				<div class="box-body">
					<?php echo $message;?>

					<table class="table table-bordered table-striped">
						<tr>
							<th style="text-align: center;">No</th>
							<th style="text-align: center;">Photo</th>
							<th style="text-align: center;">Lokasi Kerja</th>

							<th style="text-align: center;">Latitude</th>
							<th style="text-align: center;">Longitude</th>

							<th style="text-align: center;">User Type</th>
							
							<th style="text-align: center;"><?php echo lang('index_fname_th');?></th>

							<th style="text-align: center;"><?php echo lang('index_username_th');?></th>
							<th style="text-align: center;"><?php echo lang('index_groups_th');?></th>
							<th style="text-align: center;"><?php echo lang('index_status_th');?></th>
							<th style="text-align: center;"><?php echo lang('index_action_th');?></th>
						</tr>
						<?php $no = 1; ?>
						<?php foreach ($users as $user):?>
							<tr>
								<td style="text-align: center;"><?php echo $no; ?></td>
								<td style="text-align: center;"><img src="<?=base_url('assets/uploads/images/profile/').$user->thumbnail;?>" width="50px" height="50px"></td>
								<td style="text-align: center;"><?php echo $user->nama_lokasi; ?></td>

								<td style="text-align: center;"><?php echo $user->lat; ?></td>
								<td style="text-align: center;"><?php echo $user->lon; ?></td>

								<td style="text-align: center;"><?php echo $user->type; ?></td>

					            <td><?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8') . ' ' . htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8') ?></td>

					            <td><?php echo htmlspecialchars($user->username,ENT_QUOTES,'UTF-8');?></td>
								<td style="text-align: center;">
									<div class="btn-group-vertical">
									<?php foreach ($user->groups as $group):?>
										<?php echo anchor("auth/edit_group/".$group->id, htmlspecialchars($group->name,ENT_QUOTES,'UTF-8'), array('class' => 'btn btn-sm btn-info')) ;?>
					                <?php endforeach?>
									</div>
								</td>
								<td style="text-align: center;"><?php echo ($user->active) ? anchor("auth/deactivate/".$user->id, lang('index_active_link'), array('class' => 'btn btn-sm btn-danger')) : anchor("auth/activate/". $user->id, lang('index_inactive_link'), array('class' => 'btn btn-sm btn-success'));?></td>
								<td style="text-align: center;">
									<?php echo anchor("auth/edit_user/".$user->id, 'Edit', array('class' => 'btn btn-sm btn-primary')) ;?>
									<?php echo anchor("auth/delete_user/".$user->id, 'Delete', array('class' => 'btn btn-sm btn-danger', 'onclick' => "return confirm('Are you sure want to delete this user?')")) ;?>
								</td>
							</tr>
							<?php $no++; ?>
						<?php endforeach;?>
					</table>
				</div>
				<!-- /.box-body -->
				<div class="box-footer">
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