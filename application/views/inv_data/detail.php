<!-- =========================== CONTENT =========================== -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Monitoring
      <small>Detail Aset</small>
    </h1>
    <ol class="breadcrumb">
      <li class="active"><i class="fa fa-map-pin"></i> &nbsp; Monitoring</li>
      <li class="active">Detail Aset</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <?php foreach ($data_detail->result() as $data){
      $curr_id_area          = $data->id_area;
      $curr_id_unit          = $data->id_unit;
      $curr_code             = $data->nomor_aset;
      $curr_nama_aset        = $data->nama_aset;
      $curr_bagian           = $data->bagian;
      $curr_brand            = $data->merek;
      $curr_model            = $data->model;
      $curr_bahan            = $data->bahan;
      $curr_jenis_aset       = $data->kategori;
      $curr_kondisi          = $data->kondisi;
      $curr_serial_number    = $data->serial_number;
      $curr_category_id      = $data->category_id;
      $curr_category         = $data->category_name;
      $curr_location_id      = $data->location_id;
      $curr_location         = $data->nama_lokasi;
      $curr_unit             = $data->nama_unit;
      $curr_status           = $data->status;
      $curr_status_name      = $data->status_name;
      $curr_length           = $data->length;
      $curr_width            = $data->width;
      $curr_height           = $data->height;
      $curr_weight           = $data->weight;
      $curr_color            = $data->color;
      $curr_price            = $data->harga_beli;
      $curr_date_of_purchase = tgl_indo_ddmmyyyy($data->tgl_beli);
      $curr_description      = $data->deskripsi;
      $curr_photo            = $data->photo;
      $curr_thumbnail        = $data->thumbnail;
    } ?>
		<!-- Data detail box -->
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"><?php echo $curr_nama_aset ?>
				</h3>

				<div class="box-tools pull-right">
					<!-- <button class="btn btn-default btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
				</div>
			</div>
			<div class="box-body">
        <?php echo $message;?>

        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
        <?php if ($curr_photo!=""): ?>
          <a href="<?php echo base_url("assets/uploads/images/inventory/").$curr_photo ?>" class="thumbnail" data-fancybox data-caption="<?php echo $curr_nama_aset ?>">
            <img src="<?php echo base_url("assets/uploads/images/inventory/").$curr_photo ?>" alt="<?php echo $curr_nama_aset ?>">
          </a>
        <?php else: ?>
          <img src="<?php echo base_url("assets/uploads/images/no_picture.png") ?>" class="center-block" alt="<?php echo $curr_nama_aset ?>">
          <h3 class="text-center">No Image</h3>
          <br><hr>
        <?php endif; ?>
        </div>

        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 form-horizontal">
          <table class="table table-bordered table-hover">
            <tr>
              <th class="col-lg-3 active">Code / No. Aset</th>
              <td><?php echo $curr_code ?></td>
            </tr>
            <tr>
              <th class="col-lg-3 active">Nama Aset</th>
              <td><?php echo $curr_nama_aset ?></td>
            </tr>
            <tr>
              <th class="col-lg-3 active">Bagian Penempatan</th>
              <td><?php echo $curr_bagian ?></td>
            </tr>
            <tr>
              <th class="active">Merek / Brand</th>
              <td><?php echo $curr_brand ?></td>
            </tr>
            <tr>
              <th class="active">Model</th>
              <td><?php echo $curr_model ?></td>
            </tr>
            <tr>
              <th class="active">Bahan</th>
              <td><?php echo $curr_bahan ?></td>
            </tr>
            <tr>
              <th class="active">Jenis Aset</th>
              <td><?php echo $curr_jenis_aset ?></td>
            </tr>

            <tr>
              <th class="active">Serial Number</th>
              <td><?php echo $curr_serial_number ?></td>
            </tr>

            <tr>
              <th class="active">Category</th>
              <td><?php echo $curr_category ?></td>
            </tr>
            <tr>
              <th class="active">Status</th>
              <td><?php echo $curr_status_name ?></td>
            </tr>

            <tr>
              <th class="active">Kondisi</th>
              <td><?php echo $curr_kondisi ?></td>
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
              <h4>Detail Information</h4>
              <table class="table table-bordered table-hover">
                <tr>
                  <th class="col-lg-4 active">Color</th>
                  <td><?php echo $curr_color ?></td>
                </tr>
                <tr>
                  <th class="active">Harga Beli</th>
                  <td><?php echo number_format($curr_price, 0, ',', '.') ?></td>
                </tr>
                <tr>
                  <th class="active">Tanggal Perolehan</th>
                  <td><?php echo $curr_date_of_purchase ?></td>
                </tr>
                <tr>
                  <th class="active">Description</th>
                  <td><?php echo $curr_description ?></td>
                </tr>
              </table>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-horizontal">
              <h4>Dimension</h4>
              <table class="table table-bordered table-hover">
                <tr>
                  <th class="col-lg-4 active">Length</th>
                  <td><?php echo $curr_length ?> Cm</td>
                </tr>
                <tr>
                  <th class="active">Width</th>
                  <td><?php echo $curr_width ?> Cm</td>
                </tr>
                <tr>
                  <th class="active">Height</th>
                  <td><?php echo $curr_height ?> Cm</td>
                </tr>
                <tr>
                  <th class="active">Weight</th>
                  <td><?php echo $curr_weight ?> Kg</td>
                </tr>
              </table>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-horizontal">
              <h4>Status Logs</h4>
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
              <h4>Location Logs</h4>
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
          <button type="button" onClick="window.location='<?php echo site_url() . 'inventory/by_aset_unit_area/' . $curr_id_area . '/' . $curr_id_unit ?>';" class="btn btn-default"><i class="fa fa-undo"></i> Kembali</button>
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