<!-- =========================== CONTENT =========================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">

  <h1>
    <?php echo $title ?>
    <small><?php echo $subtitle ?></small>
  </h1>

    <ol class="breadcrumb">
			<?php echo $navigasi; ?>
    </ol>

  </section>

  <!-- Main content -->
  <section class="content">
    <?php foreach ($data_detail->result() as $data){
      
      $curr_code                = $data->kode;
      $curr_nama                = $data->nama;
      $curr_jk                  = $data->jk;
      $curr_jabatan             = $data->jabatan;
      $curr_unit_kerja          = $data->unit_kerja;
      $curr_pasangan            = $data->pasangan;
      $curr_hubungan            = $data->hubungan;
      $curr_telp                = $data->telp;
      $curr_lama_menetap        = $data->lama_menetap;
      $curr_anak1               = $data->anak1;
      $curr_anak2               = $data->anak2;
      $curr_anak3               = $data->anak3;
      $curr_anak4               = $data->anak4;
      $curr_anak5               = $data->anak5;
      //$curr_color            = $data->color;
      //$curr_price            = $data->price;
      //$curr_date_of_purchase = $data->date_of_purchase;
      //$curr_description      = $data->description;
      $curr_photo            = $data->photo;
      $curr_thumbnail        = $data->thumbnail;
    } ?>
		<!-- Data detail box -->
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Detail Penghuni</h3>

				<div class="box-tools pull-right">
					<!-- <button class="btn btn-default btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
				</div>
			</div>

			<div class="box-body">
        
        <?php echo $message;?>

        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

          <?php if ($curr_photo!=""): ?>
          
          <a href="<?php echo base_url("assets/uploads/images/penghuni/").$curr_photo ?>" class="thumbnail" data-fancybox data-caption="<?php echo $curr_nama; ?>">
            <img src="<?php echo base_url("assets/uploads/images/penghuni/").$curr_photo ?>" alt="<?php echo $curr_nama; ?>">
          </a>

          <?php else: ?>
          <img src="<?php echo base_url("assets/uploads/images/no_picture.png") ?>" class="center-block" alt="<?php echo $curr_nama; ?>">
          <h3 class="text-center">No Image</h3>
          <br><hr>
          <?php endif; ?>
        
        </div>

        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 form-horizontal">
          <table class="table table-bordered table-hover">
            <tr>
              <th class="col-lg-3 active">Code</th>
              <td><?php echo $curr_code ?></td>
            </tr>
            <tr>
              <th class="active">Nama Penghuni</th>
              <td><?php echo $curr_nama ?></td>
            </tr>
            <tr>
              <th class="active">Jenis Kelamin</th>
              <td><?php echo $curr_jk ?></td>
            </tr>
            <tr>
              <th class="active">Jabatan</th>
              <td><?php echo $curr_jabatan ?></td>
            </tr>
            <tr>
              <th class="active">Unit Kerja</th>
              <td><?php echo $curr_unit_kerja ?></td>
            </tr>
            <tr>
              <th class="active">Telpon</th>
              <td><?php echo $curr_telp ?></td>
            </tr>
            <tr>
              <th class="active">Lama Menetap</th>
              <td><?php echo $curr_lama_menetap ?></td>
            </tr>
          </table>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          
        <hr>

          <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-horizontal">

              <h4>Data Pasangan</h4>

              <table class="table table-bordered table-hover">
                <tr>
                  <th class="col-lg-4 active">Pasangan</th>
                  <td><?php echo $curr_pasangan ?></td>
                </tr>
                <tr>
                  <th class="active">Hubungan</th>
                  <td><?php echo $curr_hubungan ?></td>
                </tr>
              </table>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-horizontal">
              <h4>Data Anak</h4>
              <table class="table table-bordered table-hover">
                <tr>
                  <th class="col-lg-4 active">Anak 1</th>
                  <td><?php echo $curr_anak1 ?></td>
                </tr>
                <tr>
                  <th class="active">Anak 2</th>
                  <td><?php echo $curr_anak2 ?></td>
                </tr>
                <tr>
                  <th class="active">Anak 3</th>
                  <td><?php echo $curr_anak3 ?></td>
                </tr>
                <tr>
                  <th class="active">Anak 4</th>
                  <td><?php echo $curr_anak4 ?></td>
                </tr>
                <tr>
                  <th class="active">Anak 5</th>
                  <td><?php echo $curr_anak5 ?></td>
                </tr>
              </table>
            </div>

          </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
          <hr>
          <button type="button" onClick="window.location='<?php echo site_url() . 'penghuni' ?>';" class="btn btn-default"><i class="fa fa-undo"></i> Kembali</button>
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