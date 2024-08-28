<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>

</head>

<body>

    <!-- End navigation-->

    <div class="container-fluid">
        <div class="col-md-6">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-4">
                <div class="view-header">
                    <div class="pull-right text-left">

                    </div>

                    <div class="header-icon">
                        <i class="pe page-header-icon pe-7s-box1"></i>
                    </div>
                    <div class="header-title">
                        <h3>Report</h3>
                        <small>
                            Report Helpdesk
                        </small>
                    </div>
                </div>

            </div>

            <div class="col-lg-8">

                <form method="GET" action="<?= base_url('Data_report/Helpdesk') ?>" enctype="multipart/form-data" role="form">
                    <div class="form-row">
                        <div class="col-md-6">
                            <label>Bulan</label>
                            <input type="month" class="form-control" name="tgl" value="<?php echo $tanggal; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label>Area</label>
                            <select class="form-control" id="area" name="area">
                                <option Value="">Pilih</option>
                                <?php
                                foreach ($area as $lok) { ?>
                                    <option value="<?php echo encrypt_url($lok->id); ?>"><?php echo $lok->nama_lokasi ?></option>
                                <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <a class="btn btn-success" href="<?php echo base_url('Data_report/Export_helpdesk?tgl=') . '' . $tanggal; ?>" style="float:right;margin-left:10px;">Export to excel</a>
                    <button class="btn btn-primary" style="float:right;" type="submit">Cek</button>
            </div>

        </div>


        <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">


            </div>
        </div>
        <hr>
        <div>
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id='ab'>
                    <thead>
                        <tr>
                            <th>Tiket</th>
                            <th>Status</th>
                            <th>Area</th>
                            <th>Blok</th>
                            <th>No Unit</th>
                            <th>Kategori Laporan</th>
                            <th>Prioritas</th>
                            <th>Laporan</th>
                            <th>Pelapor</th>
                            <th>Penerima Laporan</th>
                            <th>Penghuni</th>
                            <th>Petugas 1</th>
                            <th>Petugas 2</th>
                            <th>Petugas Pengerjaan</th>
                            <th>Progress</th>
                            <th>Hasil Pekerjaan</th>
                            <th>Waktu Laporan</th>
                            <th>Waktu Selesai</th>
                            <th>Durasi</th>
                            <th>Biaya Perbaikan</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($helpdesk as $t) {
                            if ($t->status == 1) {
                                $label_status = "label label-warning";
                            } else if ($t->status == 2) {
                                $label_status = "label label-info";
                            } else if ($t->status == 3) {
                                $label_status = "label label-success";
                            } else if ($t->status == 4) {
                                $label_status = "label label-danger";
                            } else if ($t->status == 5) {
                                $label_status = "label label-success";
                            } else if ($t->status == 6) {
                                $label_status = "label label-success";
                            } else {
                                $label_status = "";
                            }

                            $jumlahkarakter = 20;
                            $cetak = substr($t->job_detail, 0, $jumlahkarakter);
                            $status = '<span class="' . $label_status . '">' . $t->desc_status . '</span>';
                            $open = strtotime(date($t->create_date));

                            if (empty($t->finish_date) || $t->finish_date == 0) {
                                $finish = strtotime(date("Y-m-d H:i:s"));
                            } else {
                                $finish = strtotime(date($t->finish_date));
                            }

                            $diff = $finish - $open;
                            $jam   = floor($diff / 3600);
                            $menit = floor(($diff - ($jam * 3600)) / 60);
                            $hari =  floor($jam / 24);
                            $jam1 =  floor(($jam - ($hari * 24)));
                            $durasi = "$hari hari,$jam1 jam,$menit menit ";

                        ?>
                        
                            <tr>
                                <td><a href="<?php echo  base_url('Helpdesk/Update?id=') . '' . encrypt_url($t->id); ?>"><?php echo $t->tiket; ?></a></td>
                                <td><a href="<?php echo  base_url('Helpdesk/Update?id=') . '' . encrypt_url($t->id); ?>"><?php echo $status; ?></a> </td>
                                <td><?php echo $t->nama_lokasi; ?></td>
                                <td><?php echo $t->blok; ?></td>
                                <td><?php echo $t->no_unit; ?></td>
                                <td><?php echo $t->type_incident; ?></td>

                                <td><span class="label 
                  <?php if ($t->type == 'High') {
                                echo 'label-danger';
                            } else if ($t->type == 'Medium') {
                                echo 'label-info';
                            } else if ($t->type == 'Low') {
                                echo 'label-success';
                            }
                    ?> "><?php echo $t->type; ?></span></td>

                                <td><?php echo $cetak; ?></td>
                                <td><?php echo $t->pelapor; ?></td>
                                <td><?php echo $t->ucreate; ?></td>
                                <td><?php echo $t->uhuni; ?></td>
                                <td><?php echo $t->name_pic; ?></td>
                                <td><?php echo $t->name_pic1; ?></td>
                                <td><?php echo $t->name_pic_complete; ?></td>
                                <td><?php echo $t->value_progres; ?> %</td>
                                <td><?php echo $t->result; ?></td>
                                <td><?php echo $t->create_date; ?></td>
                                <td><?php echo $t->finish_date; ?></td>
                                <td><?php echo $durasi; ?></td>
                                <td><?php echo $t->nilai; ?></td>
                            </tr>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    <div class="pull-right">

    </div>

    </div>






    <script>
        $("a").click(function() {
            setInterval(function() {
                $(".pr").fadeOut("slow");
            }, 4000);
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#ab').dataTable({
                "aaSorting": [
                    [0, "desc"]
                ]
            });

        });
    </script>

</body>

</html>