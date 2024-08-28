<!-- =========================== CONTENT =========================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
    Unit
      <small>Master Data / Unit</small>
    </h1>
    <ol class="breadcrumb">
      <li class="active"><i class="fa fa-map-pin"></i> &nbsp; Master Data</li>
      <li class="active">Unit</li> 
      <li class="active">Detail</li> 
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <?php foreach ($data_detail->result() as $data){
      $curr_id_area           = $data->id_area;
      $curr_id_unit           = $data->id_unit;
      $curr_code              = $data->kode;
      $curr_nama_unit         = $data->nama_unit;
      $curr_blok              = $data->blok;
      $curr_no_unit           = $data->no_unit;
      $curr_lantai            = $data->lantai;
      $curr_status_detail     = $data->status_detail;
      $curr_klasifikasi       = $data->klasifikasi;

      $curr_hak_menempati     = $data->hak_menempati;
      
      $curr_location_id       = $data->location_id;
      $curr_location          = $data->nama_lokasi;
      $curr_unit              = $data->nama_unit;
      $curr_status            = $data->status;
      $curr_status_name       = $data->status_name;

      $curr_dok               = $data->dok;
      $curr_tgl_dok           = tgl_indo_ddmmyyyy($data->tgl_dok);
      $curr_no_bast           = $data->no_bast;
      $curr_tgl_bast          = tgl_indo_ddmmyyyy($data->tgl_bast);
      $curr_wilayah           = $data->wilayah;
      $curr_kondisi_rumdin    = $data->kondisi_rumdin;
      $curr_masuk             = tgl_indo_ddmmyyyy($data->masuk);
      $curr_keluar            = tgl_indo_ddmmyyyy($data->keluar);
      $curr_tgl_perbaikan     = tgl_indo_ddmmyyyy($data->tgl_perbaikan);
      $curr_nominal_rab       = $data->nominal_rab;
      $curr_nominal_spk       = $data->nominal_spk;
      $curr_kontraktor        = $data->kontraktor;

      $curr_id_listrik          = $data->id_listrik;
      $curr_id_pam              = $data->id_pam;
      $curr_id_telp             = $data->id_telp;
      $curr_id_internet1        = $data->id_internet1;
      $curr_id_internet2        = $data->id_internet2;
      $curr_id_internet3        = $data->id_internet3;
      $curr_id_internet4        = $data->id_internet4;
      $curr_daya_listrik        = $data->daya_listrik;

      $curr_keterangan          = $data->keterangan;
      $curr_alamat_lengkap      = $data->alamat_lengkap;

      $curr_photo            = $data->photo;
      $curr_thumbnail        = $data->thumbnail;
    } ?>
		<!-- Data detail box -->
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $curr_blok . ' ' . $curr_no_unit ?>
				</h3>

				<div class="box-tools pull-right">
					<!-- <button class="btn btn-default btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
				</div>
			</div>
			<div class="box-body">
        <?php echo $message;?>

        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <?php if ($curr_photo!=""): ?>
          <a href="<?php echo base_url("assets/uploads/images/unit/").$curr_photo ?>" class="thumbnail" data-fancybox data-caption="<?php echo $curr_blok . ' ' . $curr_no_unit ?>">
            <img src="<?php echo base_url("assets/uploads/images/unit/").$curr_photo ?>" alt="<?php echo $curr_blok . ' ' . $curr_no_unit ?>">
          </a>
        <?php else: ?>
          <img src="<?php echo base_url("assets/uploads/images/no_picture.png") ?>" class="center-block" alt="<?php echo $curr_blok . ' ' . $curr_no_unit ?>">
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
              <th class="col-lg-3 active">Nama Unit</th>
              <td><?php echo $curr_nama_unit ?></td>
            </tr>
            <tr>
              <th class="col-lg-3 active">Blok</th>
              <td><?php echo $curr_blok ?></td>
            </tr>
            <tr>
              <th class="active">No. Unit</th>
              <td><?php echo $curr_no_unit ?></td>
            </tr>
            <tr>
              <th class="active">Lantai</th>
              <td><?php echo $curr_lantai ?></td>
            </tr>
            <tr>
              <th class="active">Status Hunian</th>
              <td><?php echo $curr_status_detail ?></td>
            </tr>

            <tr>
              <th class="active">Hak Menempati</th>
              <td><?php echo $curr_hak_menempati ?></td>
            </tr>

            <tr>
              <th class="active">Klasifikasi Unit</th>
              <td><?php echo $curr_klasifikasi ?></td>
            </tr>
            
            <tr>
              <th class="active">Location</th>
              <td><?php echo $curr_location ?></td>
            </tr>
            <tr>
              <th class="active">Unit</th>
              <td><?php echo $curr_unit ?></td>
            </tr>
            
          </table>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <hr>
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-horizontal">
              <h4>Legal</h4>
              <table class="table table-bordered table-hover">
                <tr>
                  <th class="col-lg-4 active">No. SPRD</th>
                  <td><?php echo $curr_dok ?></td>
                </tr>
                <tr>
                  <th class="col-lg-4 active">Tanggal SPRD</th>
                  <td><?php echo $curr_tgl_dok ?></td>
                </tr>
                <tr>
                  <th class="col-lg-4 active">No. BAST Masuk</th>
                  <td><?php echo $curr_no_bast ?></td>
                </tr>
                <tr>
                  <th class="col-lg-4 active">Tanggal BAST Masuk</th>
                  <td><?php echo $curr_tgl_bast ?></td>
                </tr>
                <tr>
                  <th class="col-lg-4 active">Wilayah</th>
                  <td><?php echo $curr_wilayah ?></td>
                </tr>

                <tr>
                  <th class="col-lg-4 active">Kondisi Rumah Dinas</th>
                  <td><?php echo $curr_kondisi_rumdin ?></td>
                </tr>

                <tr>
                  <th class="col-lg-4 active">Tanggal Masuk</th>
                  <td><?php echo $curr_masuk ?></td>
                </tr>

                <tr>
                  <th class="col-lg-4 active">Tanggal Keluar</th>
                  <td><?php echo $curr_keluar ?></td>
                </tr>

                <tr>
                  <th class="col-lg-4 active">Tanggal Perbaikan</th>
                  <td><?php echo $curr_tgl_perbaikan ?></td>
                </tr>

                <tr>
                  <th class="active">Nomimal RAB</th>
                  <td><?php echo number_format($curr_nominal_rab, 0, ',', '.') ?></td>
                </tr>

                <tr>
                  <th class="active">Nomimal SPK</th>
                  <td><?php echo number_format($curr_nominal_spk, 0, ',', '.') ?></td>
                </tr>

                <tr>
                  <th class="active">Kontraktor</th>
                  <td><?php echo $kontraktor ?></td>
                </tr>

              </table>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-horizontal">

              <h4>Listrik dan Internet</h4>

              <table class="table table-bordered table-hover">
                <tr>
                  <th class="col-lg-4 active">ID Listrik</th>
                  <td><?php echo $curr_id_listrik ?></td>
                </tr>
                <tr>
                  <th class="active">ID PAM</th>
                  <td><?php echo $curr_id_pam ?></td>
                </tr>
                <tr>
                  <th class="active">ID Telp</th>
                  <td><?php echo $curr_id_telp ?></td>
                </tr>
                <tr>
                  <th class="active">ID Internet 1</th>
                  <td><?php echo $curr_id_internet1 ?></td>
                </tr>

                <tr>
                  <th class="active">ID Internet 2</th>
                  <td><?php echo $curr_id_internet2 ?></td>
                </tr>

                <tr>
                  <th class="active">ID Internet 3</th>
                  <td><?php echo $curr_id_internet3 ?></td>
                </tr>

                <tr>
                  <th class="active">ID Internet 4</th>
                  <td><?php echo $curr_id_internet4 ?></td>
                </tr>

                <tr>
                  <th class="active">Daya Listrik</th>
                  <td><?php echo $curr_daya_listrik ?></td>
                </tr>

              </table>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-horizontal">
              
              <h4>Catatan</h4>

              <table class="table table-bordered table-hover">

                <tr>
                  <th class="col-lg-4 active">Catatan</th>
                  <td><?php echo $curr_keterangan ?></td>
                </tr>

                <tr>
                  <th class="active">Alamat</th>
                  <td><?php echo $curr_alamat_lengkap ?></td>
                </tr>

              </table>

            </div>

          </div>

          <hr>

          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-horizontal">
              <h4>Status Hunian Unit Logs</h4>
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th style="text-align:center">Date</th>
                    <th style="text-align:center">Status</th>
                    <th style="text-align:center">Changed by</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($status_logs->result() as $status_log): ?>
                    <tr>
                      <td style="text-align:center" class="col-lg-4"><?php echo $status_log->created_on ?></td>
                      <td style="text-align:center"><?php echo $status_log->status_name ?></td>
                      <td style="text-align:center"><?php echo $status_log->first_name. " " . $status_log->last_name ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-horizontal">
              <h4>Penghuni Logs</h4>
              <table class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th style="text-align:center">Date</th>
                    <th style="text-align:center">Area</th>
                    <th style="text-align:center">Unit</th>
                    <th style="text-align:center">Changed by</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($location_logs->result() as $location_log): ?>
                    <tr>
                      <td style="text-align:center" class="col-lg-4"><?php echo $location_log->created_on ?></td>
                      <td><?php echo $location_log->nama_lokasi ?></td>
                      <td style="text-align:center"><?php echo $location_log->blok . ' ' . $location_log->no_unit ?></td>
                      <td style="text-align:center"><?php echo $location_log->first_name. " " . $location_log->last_name ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
          <hr>
          <button type="button" onClick="window.location='<?php echo site_url() . 'unit' ?>';" class="btn btn-default"><i class="fa fa-undo"></i> Kembali</button>
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