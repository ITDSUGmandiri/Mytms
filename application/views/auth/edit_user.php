  <!-- =========================== CONTENT =========================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo lang('edit_user_heading');?>
        <small><?php echo lang('edit_user_subheading');?></small>
      </h1>
      <ol class="breadcrumb">
        <li><i class="fa fa-users"></i> <a href="<?php echo base_url('auth') ?>"><?php echo lang('index_heading');?></a></li>
        <li class="active"><?php echo lang('edit_user_heading'); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">
          </h3>

          <div class="box-tools pull-right">
            <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
          </div>
        </div>
        <div class="box-body">

          <?php echo $message;?>
          
          <?php echo form_open(uri_string(), array('class' => 'form form-horizontal', 'autocomplete' => 'off', ));?>

            <div class="form-group">
              <?php echo lang('edit_user_fname_label', 'first_name', array('class' => 'control-label col-md-3'));?> 
              <div class="col-md-7">
                <?php echo form_input($first_name);?>
              </div>
            </div>

            <div class="form-group">
              <?php echo lang('edit_user_lname_label', 'last_name', array('class' => 'control-label col-md-3'));?> 
              <div class="col-md-7">
                <?php echo form_input($last_name);?>
              </div>
            </div>

            <div class="form-group">
              <?php echo lang('edit_user_phone_label', 'phone', array('class' => 'control-label col-md-3'));?> 
              <div class="col-md-7">
                <?php echo form_input($phone);?>
              </div>
            </div>

            <div class="form-group">
							<label for="lokasi_kerja" class="control-label col-md-3"><?php echo "Lokasi Kerja"; ?></label>
							<div class="col-md-7">
								<select name="lokasi_kerja" id="lokasi_kerja" class="form-control">
									<option value=""> - Pilih Lokasi Kerja - </option>

									<?php foreach ($data_list_area as $value) { ?>
                    <option value="<?php echo $value['id']; ?>" <?php echo ($value['id'] == $lok_id) ? 'selected="selected"' : ''; ?>><?php echo $value['nama_lokasi']; ?> </option>
									<?php } ?>

								</select>
							</div>
						</div>

						<div class="form-group">
							<label for="lat" class="control-label col-md-3"><?php echo "Latitude"; ?></label>
							<div class="col-md-7">
                <?php echo form_input($lat);?>
							</div>
						</div>

						<div class="form-group">
							<label for="lon" class="control-label col-md-3"><?php echo "Longitude"; ?></label>
							<div class="col-md-7">
                <?php echo form_input($lon);?>
							</div>
						</div>

            <div class="form-group">
							<label for="user_type" class="control-label col-md-3"><?php echo "User Type"; ?></label>
							<div class="col-md-7">
								<select name="user_type" id="user_type" class="form-control">
									<option value=""> - Pilih User Type - </option>

									<?php foreach ($data_list_user_type as $value) { ?>
										<option value="<?php echo $value->ut_id; ?>" <?php echo ($value->ut_id == $user_type) ? 'selected="selected"' : ''; ?>><?php echo $value->type; ?> </option>
									<?php } ?>

								</select>
							</div>
						</div>
            
            <hr>

            <div class="form-group">
              <?php echo lang('edit_user_password_label', 'password', array('class' => 'control-label col-md-3'));?> 
              <div class="col-md-7">
                <?php echo form_input($password);?>
                <p class="help-block">Leave blank if you don't want to change password</p>
              </div>
            </div>

            <div class="form-group">
              <?php echo lang('edit_user_password_confirm_label', 'password_confirm', array('class' => 'control-label col-md-3'));?>
              <div class="col-md-7">
                <?php echo form_input($password_confirm);?>
              </div>
            </div>

            <?php if ($this->ion_auth->is_admin()): ?>
              <hr>
              <h3 class="text-center"><?php echo lang('edit_user_groups_heading');?></h3>
              <div class="form-group">
                <div class="col-md-7 col-md-offset-3">
                <?php foreach ($groups as $group):?>
                  <div class="checkbox">
                    <label class="checkbox">
                    <?php
                        $gID=$group['id'];
                        $checked = null;
                        $item = null;
                        foreach($currentGroups as $grp) {
                            if ($gID == $grp->id) {
                                $checked= ' checked="checked"';
                            break;
                            }
                        }
                    ?>
                    <input type="checkbox" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
                    <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
                    </label>
                  </div>
                <?php endforeach?>
                </div>
              </div>

            <?php endif ?>

            <?php echo form_hidden('id', $user->id);?>
            <?php echo form_hidden($csrf); ?>

            <div class="form-group text-center">
              <hr>
              <?php echo form_submit('submit', lang('edit_user_submit_btn'), array('class' => 'btn btn-primary'));?>
              <a href="javascript:history.back()" class="btn btn-default">Cancel</a>
            </div>

      <?php echo form_close();?>
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
	<script src="<?php echo base_url(); ?>assets/templates/adminlte-2-3-11/dist/js/myclass.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>assets/templates/adminlte-2-3-11/dist/js/functions.js" type="text/javascript"></script>

  <script type="text/javascript">
  $('#lokasi_kerja').change(function(){

    var id_lok = $(this).val();

    $.ajax({
      type: "POST",
      url: "<?php echo site_url('auth/get_lokasi_kerja'); ?>",
      data: "id_lok="+id_lok,
      success: function(msg){
        
        var value = JSON.parse(msg);
        $('#lat').val(value['lat']);
        $('#lon').val(value['long']);

      }
      
    });

  });
  </script>