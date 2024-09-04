<!-- =========================== CONTENT =========================== -->

<style>
    .vertical-container {
      /* this class is used to give a max-width to the element it is applied to, and center it horizontally when it reaches that max-width */
      width: 98%;
      margin: 0 auto;
    }

    .vertical-container::after {
      /* clearfix */
      content: '';
      display: table;
      clear: both;
    }

    .v-timeline {
      position: relative;
      padding: 0;
      margin-top: 2em;
      margin-bottom: 2em;
    }

    .v-timeline::before {
      content: '';
      position: absolute;
      top: 0;
      left: 18px;
      height: 100%;
      width: 4px;
      background: #3d404c;
    }

    .vertical-timeline-content .btn {
      float: right;
    }

    .vertical-timeline-block {
      position: relative;
      margin: 2em 0;
    }

    .vertical-timeline-block:after {
      content: "";
      display: table;
      clear: both;
    }

    .vertical-timeline-block:first-child {
      margin-top: 0;
    }

    .vertical-timeline-block:last-child {
      margin-bottom: 0;
    }

    .vertical-timeline-icon {
      position: absolute;
      top: 0;
      left: 0;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      font-size: 16px;
      border: 1px solid #3d404c;
      text-align: center;
      background: grey;
      color: #ffffff;
    }

    .vertical-timeline-icon i {
      display: block;
      width: 24px;
      height: 24px;
      position: relative;
      left: 50%;
      top: 50%;
      margin-left: -12px;
      margin-top: -9px;
    }

    .vertical-timeline-content {
      position: relative;
      margin-left: 60px;
      background-color: transparent;
      border-radius: 0.25em;
      border: 1px solid #00bfff;
      padding: 5px;
    }

    .vertical-timeline-content:after {
      content: "";
      display: table;
      clear: both;
    }

    .vertical-timeline-content h2 {
      font-weight: 400;
      margin-top: 4px;
    }

    .vertical-timeline-content p {
      margin: 1em 0 0 0;
      line-height: 1.6;
    }

    .vertical-timeline-content .vertical-date {
      font-weight: 500;
      text-align: right;

    }

    .vertical-date small {
      color: grey;
      font-weight: 400;
    }

    .vertical-timeline-content:after,
    .vertical-timeline-content:before {
      right: 100%;
      top: 20px;
      border: solid transparent;
      content: " ";
      height: 0;
      width: 0;

      position: absolute;
      pointer-events: none;
    }

    .vertical-timeline-content:after {
      border-color: transparent;
      border-right-color: #00bfff;
      border-width: 10px;
      margin-top: -10px;

    }

    .vertical-timeline-content:before {
      border-color: transparent;
      border-right-color: #00bfff;
      border-width: 11px;
      margin-top: -11px;
    }

    .vertical-timeline-content h2 {
      font-size: 16px;
    }

    .panel {
      background-color: transparent;
      -webkit-box-shadow: none;
      -moz-box-shadow: none;
      box-shadow: none;
      color: #000040;
      border-radius: 3px;
      margin-bottom: 20px;
      border: 1px solid #00bfff;
    }

    .panel .panel-body {
      padding: 5px 15px 15px 15px;
    }

    .panel.panel-filled .panel-body {
      padding-top: 10px;
    }

    .panel .panel-footer {
      background-color: transparent;
      border: none;
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
      <li class="active"><i class="fa fa-map-pin"></i> &nbsp; Transaksi</li>
      <li class="active">Ticket</li> 
      <li class="active">Detail</li> 
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">

		<!-- Data detail box -->
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title"></h3>

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
              <th class="col-lg-3 active">Area</th>
              <td><?php echo $data->nama_lokasi; ?></td>
            </tr>

            <tr>  
              <th class="col-lg-3 active">Unit</th>
              <td><?php echo $data->nama_unit; ?></td>
            </tr>

            <tr>  
              <th class="col-lg-3 active">No. Ticket</th>
              <td><?php echo $data->tiket; ?></td>
            </tr>

            <tr>  
              <th class="col-lg-3 active">Pelapor</th>
              <td><?php echo strip_tags($data->pelapor); ?></td>
            </tr>
            
            <tr>  
              <th class="col-lg-3 active">Laporan Problem</th>
              <td><?php echo strip_tags($data->job_detail); ?></td>
            </tr>

            <tr>  
              <th class="col-lg-3 active">Service Family</th>
              <td><?php echo $data->service_family_name; ?></td>
            </tr>

            <tr>  
              <th class="col-lg-3 active">Type Incident</th>
              <td><?php echo $data->type_problem; ?></td>
            </tr>

            <tr>  
              <th class="col-lg-3 active">Sub Type Incident</th>
              <td><?php echo $data->sub_type_incident_id; ?></td>
            </tr>

            <tr>  
              <th class="col-lg-3 active">Last Status</th>
              <td>
                <?php 
                if ($data->status == 1) {
                      $label_status = "label label-warning";
                    } else if ($data->status == 2) {
                      $label_status = "label label-info";
                    } else if ($data->status == 3) {
                      $label_status = "label label-success";
                    } else if ($data->status == 4) {
                      $label_status = "label label-danger";
                    } else if ($data->status == 5) {
                      $label_status = "label label-success";
                    } else if ($data->status == 6) {
                      $label_status = "label label-success";
                    } else {
                      $label_status = "";
                } 
                ?>
                <span class="<?php echo $label_status; ?>"><?php echo $data->desc_status; ?></span>
              </td>
            </tr>

          </table>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <hr>
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-horizontal">
              <h4>PIC (Person In Charge)</h4>
              <table class="table table-bordered table-hover">
                
                <tr>
                  <th class="col-lg-4 active">Petugas 1</th>
                  <td><?php echo $data->name_pic ?></td>
                </tr>
               
                <tr>
                  <th class="active">Petugas 2</th>
                  <td><?php echo $data->name_pic1 ?></td>
                </tr>

                <tr>
                  <th class="active">Progress</th>
                  <td><?php echo $data->value_progres ?>&nbsp;%</td>
                </tr>

                <tr>
                  <th class="col-lg-4 active">Created</th>
                  <td><?php echo $data->create_date ?></td>
                </tr>

                <tr>
                  <th class="col-lg-4 active">Completed</th>
                  <td><?php echo $data->finish_date ?></td>
                </tr>

                <tr>
                  <th class="col-lg-4 active">Duration</th>
                  <td>
                  <?php
                                                              
                    $open = strtotime(date($data->create_date));
                                                              
                    if (empty($data->finish_date) || $data->finish_date == 0) {                                 
                      $finish = strtotime(date("Y-m-d H:i:s"));
                    } else { 
                      $finish = strtotime(date($data->finish_date));                                  
                    }
                                                              
                    $diff = $finish - $open;             
                    $jam   = floor($diff / 3600);
                    $menit = floor(($diff - ($jam * 3600)) / 60);                
                    $hari =  floor($jam / 24);    
                    $jam1 =  floor(($jam - ($hari * 24)));
                    $nilai = "$hari hari, $jam1 jam, $menit menit ";                                          
                    echo $nilai;                     
                  ?>
                  </td>
                </tr>

              </table>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-horizontal">

              <h4>Output</h4>

              <table class="table table-bordered table-hover">

                <tr>
                  <th class="col-lg-4 active">Solusi</th>
                  <td><?php echo $data->note ?></td>
                </tr>

                <tr>
                  <th class="col-lg-4 active">Result</th>
                  <td><?php echo $data->result ?></td>
                </tr>

                <tr>
                  <th class="active">Biaya</th>
                  <td>
                    <?php echo number_format($data->total_biaya_perbaikan) ?>
                  </td>
                </tr>
                
                <tr>
                  <th class="active">Kepuasan</th>
                  <td>
                    <?php echo ($data->rating == 1) ? 'Tidak Puas' : (($data->rating == 2) ? 'Cukup Puas' : (($data->rating == 3) ? 'Puas' : (($data->rating == 4) ? 'Sangat Puas' : ''))); ?>
                  </td>
                </tr>

              </table>

              <?php if ($data->status < 5) { ?>
                <a data-toggle="modal" data-target="#progres" data-rel="tooltip" href='#' title="Progress" style="float:right; margin:5px;" class="btn btn-success"> Progress</a>
                <a data-toggle="modal" data-target="#complete" data-rel="tooltip" href='#' title="Complete" style="float:right; margin:5px;" class="btn btn-success"> Complete</a>
              <?php } ?>
              
              <?php if ($data->status == 5 && $data->manager == '') { ?>
                <a data-toggle="modal" data-target="#approve" data-rel="tooltip" href='#' title="Progress" style="float:right; margin:5px;" class="btn btn-primary"> Approve</a>
              <?php } ?>

            </div>

          </div>

          <hr>

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-horizontal">
              <a data-toggle="modal" data-target="#tambah_biaya" data-rel="tooltip" href='#' title="Add File" style="float:right; margin:5px;" class="btn btn-success"> Add Biaya</a>
              <h4>Biaya Perbaikan</h4>

              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="text-align:center;">No.</th>
                    <th style="text-align:center;">Deskripsi</th>
                    <th style="text-align:center;">Qty</th>
                    <th style="text-align:center;">Biaya</th>
                    <th style="text-align:center;">Sub Total</th>
                    <td style="text-align:center;">#</th>
                  </tr>
                </thead>
                <tbody>
                  
                <?php
                  $no = 1;
                  $total_biaya = 0;

                  foreach ($biaya as $key => $b) { ?>

                    <tr>
                    <td style="text-align:center;"><?php echo $no; ?> </td>
                    <td><?php echo $b->desk; ?> </td>
                    <td style="text-align:center;"><?php echo  number_format($b->qty); ?> </td>
                    <td style="text-align:right;"><?php echo number_format($b->biaya); ?> </td>
                    <td style="text-align:right;"><?php echo number_format($b->subtotal); ?> </td>
                    <td style="text-align:center;">

                      <a href="javascript:;" data-id="<?php echo $b->id; ?>" data-toggle="modal" data-target="#delete_biaya" data-rel="tooltip" title="Cancel"><i class="fa fa-times" style="color:red; margin:10px;"></i>
                      </a>

                    </td>

                    </tr>

                  <?php
                    $no++;

                    $total_biaya = $total_biaya + $b->subtotal;
                  } ?>

                  <tr>
                    <td colspan="4" style="text-align:right">
                      <b>Total :</b>
                    </td>
                    <td style="text-align:right"><b><?php echo number_format($total_biaya); ?></b></td>
                    <td><input type="hidden" name="total_biaya_perbaikan" value="<?php echo $total_biaya; ?>"></td>
                  </tr>

                </tbody>
              </table>
              
            </div>

          <hr>

          <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-horizontal">
              <a data-toggle="modal" data-target="#comment" data-rel="tooltip" href='#' title="Add Comment" style="float:right; margin:5px;" class="btn btn-success"> Add Comment</a>
              <h4>Recent Activity</h4>

              <div class="v-timeline vertical-container">

                  <?php
                  foreach ($log as $key => $l) { ?>

                    <div class="vertical-timeline-block">
                      
                      <div class="vertical-timeline-icon" <?php if ($key == 0) { ?>style="background:#0f83c9;" <?php } ?>>
                        <i class="fa fa-arrow-up"></i>
                      </div>

                      <div class="vertical-timeline-content">

                        <div class="p-sm">
                          <span class="vertical-date pull-right"> <small> <?php echo $l->create_date; ?></small> </span>
                          <h2 style="color:#0f83c9;"> <?php echo $l->username; ?></h2>
                          <p> <?php echo $l->keterangan; ?></p>
                        </div>

                      </div>

                    </div>

                  <?php } ?>

                </div>


            </div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 form-horizontal">
              <a data-toggle="modal" data-target="#tambah_file" data-rel="tooltip" href='#' title="Add File" style="float:right; margin:5px;" class="btn btn-success"> Add File</a>
              <h4>Document Atachment</h4>

              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>User Create</th>
                    <th>View</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  foreach ($doc as $key => $d) { ?>

                    <td><?php echo $d->name_pic; ?>
                      <br>
                      <?php echo $d->deskripsi; ?>
                    </td>

                    <td>
                      <small>
                        
                      <!--<?php echo anchor(base_url('Doc/incident/' . $d->foto . ''), '' . $d->foto . '', array('target' => '_blank', 'class' => 'btn btn-secondary')); ?>-->

                      <img src="<?php if (file_exists('doc/incident/' . $d->foto . '')) {
                        echo base_url('doc/incident/' . $d->foto . '');            
                      } else {
                        echo base_url('assets/uploads/images/no_picture.png');
                      } ?>"onclick="onClick(this)" data-toggle="modal" style="width:50px; height:50px; margin:5px;" data-target="#myModal">

                      </small>
                    </td>

                    <td>
                      <a href="javascript:;" data-id="<?php echo $d->id; ?>" data-name="<?php echo $d->foto; ?>" data-desc="<?php echo $d->foto; ?>" data-toggle="modal" data-target="#delete_file" data-rel="tooltip" title="Cancel"><i class="fa fa-times" style="color:red; margin:10px;"></i></a>
                      <!--<i class="fas fa-lock" style="color:red; margin:10px;"></i>-->
                    </td>
                    </tr>

                  <?php
                    $no++;
                  } ?>

                </tbody>
              </table>
              
            </div>

          </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
          <hr>
          <button type="button" onClick="window.location='<?php echo site_url() . 'ticket' ?>';" class="btn btn-default"><i class="fa fa-undo"></i> Kembali</button>
        </div>

			</div>
			<!-- /.box-body -->
		</div>
		<!-- /.box -->

	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Modal comment -->

<div class="modal fade" id="comment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
            
      <div class="modal-header">      
        <h5 class="modal-title" id="exampleModalLabel">New Comment</h5>          
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"> </span>          
        </button>
      </div>

      <form method="post" action="<?= base_url('ticket/new_comment') ?>" enctype="multipart/form-data" role="form">
        
        <div class="modal-body">
          <input type="text" value="<?php echo encrypt_url($data->id); ?>" name="id_comment" required hidden>

            <div class="form-group">        
              <label for="exampleFormControlInput1">Comment</label>      
              <textarea name="task_comment" rows="4" class='form-control' required="required"></textarea>
            </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <button class="btn btn-primary" type="submit">Submit</button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- Modal Add File -->

<div class="modal fade" id="tambah_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah File</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"> </span>
              </button>
            </div>
            <form method="post" action="<?= base_url('ticket/document') ?>" enctype="multipart/form-data" role="form">
              <div class="modal-body">
                <input type="text" value="<?php echo encrypt_url($data->id); ?>" name="id_file" required hidden>
                <div class="form-group">
                  <label for="exampleFormControlInput1">Description File</label>
                  <textarea name="dok_desc" rows="4" class='form-control' required="required"></textarea>
                </div>


                <div class="form-group">
                  <label for="exampleFormControlInput1">File</label>
                  <input class='form-control' type='file' name='file' required>
                </div>
                <hr>
              </div>

              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="submit">Simpan</button>
              </div>
            </form>
          </div>
        </div>
      </div>

<!-- Modal Delete File -->

<div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Delete File</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"> </span>
              </button>
            </div>

            <div class="modal-body">Apakah anda yakin untuk menghapus file <span id='desc_teks'> </span> ?</div>
            
            <div class="modal-footer">

              <form method="post" action="<?= base_url('ticket/delete_file') ?>" enctype="multipart/form-data" role="form">
                
                <input type="hidden" value="<?php echo encrypt_url($data->id); ?>" name="id_delete" required>

                <input type="hidden" name="id_file_delete" id="id_file_delete" required>
                <input type="hidden" name="name_file_delete" id="name_file_delete">
                <input type="hidden" name="desc_file_delete" id="desc_file_delete">
                
                <button class="btn btn-danger" type="submit">Hapus</button>
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>

              </form>

            </div>
          </div>
        </div>
      </div>

<!-- Modal Approve -->

<div class="modal fade" id="approve" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Approval Ticket</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"> </span>
              </button>
            </div>

            <form method="post" action="<?= base_url('ticket/approve') ?>" enctype="multipart/form-data" role="form">
              
              <div class="modal-body">
                <input type="hidden" value="<?php echo encrypt_url($data->id); ?>" name="id_approve" required>

                <div class="form-group">
                  <label for="exampleFormControlInput1">Apakah Anda ingin approve data ini ?</label>
                </div>

              </div>

              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="submit">Approve</button>
              </div>

            </form>

          </div>
        </div>
      </div>

<!-- Update Progress -->

<div class="modal fade" id="progres" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Update Progres</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"> </span>
              </button>
            </div>

            <form method="post" action="<?= base_url('ticket/progres') ?>" enctype="multipart/form-data" role="form">
              
            <div class="modal-body">

                <input type="hidden" value="<?php echo encrypt_url($data->id); ?>" name="id_update">

                <div class="form-group">
                  <label for="exampleFormControlInput1">Value Progress %</label>
                  <input type="number" class='form-control' value="<?php echo encrypt_url($data->value_progres); ?>" name="value_progres" required>
                </div>

                <div class="form-group">
                  <label for="exampleFormControlInput1">Progres Note</label>
                  <textarea name="task_progres" rows="4" class="form-control" required="required"><?php echo $data->last_update; ?></textarea>
                </div>
              </div>

              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="submit">Submit</button>
              </div>
            </form>

          </div>
        </div>
      </div>

<!-- Modal Update Complete -->

<div class="modal fade" id="complete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Update Complete</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"> </span>
              </button>
            </div>

            <form method="post" action="<?= base_url('ticket/complete') ?>" enctype="multipart/form-data" role="form">

              <div class="modal-body">

                <input type="hidden" value="<?php echo encrypt_url($data->id); ?>" name="id_complete">

                <div class="form-group">
                  <label for="exampleFormControlInput1">Result</label>
                  <textarea name="task_result" rows="4" class="form-control" required="required"></textarea>
                </div>

                <div class="form-group">
                  <label for="exampleFormControlInput1">Solusi</label>
                  <textarea name="task_solusi" rows="4" class="form-control" required="required"></textarea>
                </div>
              </div>

              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="submit">Submit</button>
              </div>

            </form>

          </div>
        </div>
      </div>

<!-- Modal Tambah Biaya -->

<div class="modal fade" id="tambah_biaya" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Tambah Biaya</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"> </span>
              </button>
            </div>

            <form method="post" action="<?= base_url('ticket/new_biaya') ?>" enctype="multipart/form-data" role="form">
              <div class="modal-body">

                <input type="text" value="<?php echo encrypt_url($data->id); ?>" name="id_biaya" required hidden>

                <div class="form-group">
                  <label for="exampleFormControlInput1">Deskripsi</label>
                  <textarea name="desk_biaya" rows="4" class='form-control' required="required"></textarea>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">Qty</label>
                  <input type="number" value="" class='form-control' name="qty_biaya" required>
                </div>
                <div class="form-group">
                  <label for="exampleFormControlInput1">Biaya</label>


                  <input type="number" class="form-control" onkeyup="kalkulasi()" id="limit" class='form-control' name="biaya" required />


                  <h2 style="color:red">Rp.<span style="color:red" name="limit_2" id="limit_2"></span></h2>
                </div>
              </div>

              <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="submit">Submit</button>
              </div>
            </form>

          </div>
        </div>
      </div>

<!-- Modal Hapus Biaya -->

<div class="modal fade" id="delete_biaya" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Delete Biaya</h5>
              <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"> </span>
              </button>
            </div>

            <div class="modal-body">
              <span>Apakah Anda yakin untuk menghapus biaya </span> ?
            </div>

            <div class="modal-footer">

              <form method="post" action="<?= base_url('ticket/delete_biaya') ?>" enctype="multipart/form-data" role="form">
                <input type="hidden" value="<?php echo encrypt_url($data->id); ?>" name="id_delete_biaya" required>
                <input type="hidden" name='id_biaya_delete' id='id_biaya_delete' required>
                <button class="btn btn-danger" type="submit">Hapus</button>
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
              </form>

            </div>
          </div>
        </div>
      </div>

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

<script>
$(document).ready(function() {

  // Untuk sunting        
  $('#delete_file').on('show.bs.modal', function(e) {
    var div = $(e.relatedTarget) // Tombol dimana modal di tampilkan
    var modal = $(this)
    modal.find('#id_file_delete').attr("value", div.data('id'));
    modal.find('#name_file_delete').attr("value", div.data('name'));
    modal.find('#desc_file_delete').attr("value", div.data('desc'));        
    modal.find('#desc_teks').html(div.data('desc'));
  });

  $('#delete_biaya').on('show.bs.modal', function(e) {
    var div = $(e.relatedTarget); // Tombol dimana modal di tampilkan
    var modal = $(this);
    modal.find('#id_biaya_delete').attr("value", div.data('id'));
  });
   
});      
</script>

<script>
function kalkulasi() {
  var lim = $("#limit").val();        
  $("#limit_2").text(number_format(lim, 0, '', '.'));
}      
</script>

<script>
function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}
</script>