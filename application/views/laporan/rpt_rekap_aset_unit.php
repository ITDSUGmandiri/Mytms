<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Rekap Aset Unit</title>

    <!-- Normalize or reset CSS with your favorite library -->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">-->
    <link href="<?php echo base_url(); ?>assets/templates/adminlte-2-3-11/dist/css/normalize.min.css" rel="stylesheet" type="text/css" />

    <!-- Load paper.css for happy printing -->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">-->
    <link href="<?php echo base_url(); ?>assets/templates/adminlte-2-3-11/dist/css/paper.css" rel="stylesheet" type="text/css" />

    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>@page { size: A4 landscape }</style>

    <style>
      header,
      footer {
        position: absolute;
        left: 0;
        right: 0;
        background-color: white;
        padding-right: 0.5cm;
        padding-left: 0.5cm;
      }

      header {
        top: 0;
        padding-top: 5mm;
        padding-bottom: 3mm;
      }
      footer {
        bottom: 0;
        color: #000;
        padding-top: 0.5mm;
        padding-bottom: 0.5mm;
      }


      /*
      @media print {
        
        body, page {
          margin: 0;
          box-shadow: 0;
        }
        
        header, footer {
          position: fixed;
          left: 0;
          right: 0;
          background-color: white;
          padding-right: 0.5cm;
          padding-left: 0.5cm;
        }

      }
      */

      .halaman{
        padding:0.5cm;
      }

      .table-footer{
        font-size:9px;
      }

      /* table border-color:inherit; */
      .tg  {border-collapse:collapse;border-spacing:0;padding: 100px;}
      .tg td{font-family:Arial, sans-serif;font-size:9px;padding:8px 4px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
      .tg th{font-family:Arial, sans-serif;font-size:9px;font-weight:bold;padding:5px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
      .tg .tg-kali{font-family:Arial, sans-serif;font-size:10px;font-weight:bold;padding:5px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
      .tg .tg-0pky{text-align:left;vertical-align:center}
      .tg .tg-0lax{text-align:center;vertical-align:center}
      .tg .tg-0knn{text-align:right;vertical-align:center}
    </style>

    <style type="text/css">
      html {
      font-family: helvetica;
      }

      #background{
        position:absolute;
        z-index:0;
        background:white;
        display:block;
        min-height:50%; 
        min-width:50%;
        color:yellow;
      }

      #bg-text
      {
          color:lightgrey;
          font-size:120px;
          transform:rotate(300deg);
          -webkit-transform:rotate(300deg);
      }
    </style>

</head>

<body class="A4 landscape">
  
<?php
    $no = 1;
		$number_page = 0;
    // $max = $laporan_list;
    $total_biaya_ds = 0;
    $total_biaya_lalamove = 0;
    $total_fee_rs = 0;
    $persentase_fee_rs = $fee_faskes;
    $pembagi_mod = 13;
    $total_uang_tunai = 0;
    $total_uang_non_tunai = 0;

    if ($id_faskes !== '0'){
      $nama_faskes = $nama_faskes . ', ';
    } else {
      $nama_faskes = '';
    }

    //echo '<pre>';
		//echo print_r($laporan_list);
    //echo '</pre>';
    
    //exit;

    foreach ($laporan_list as $val){ ?>

      <?php 
        if(($no == 1 || $no % $pembagi_mod == 0)){
          $number_page++;
      ?>

        <!--<page size="legal" layout="landscape">-->
        
        <!-- Each sheet element should have the class "sheet" -->
        <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
        <section class="sheet padding-0.5mm">
        
                <header>
                
                  <table style="width:100%;">
                    
                    <tr>
                      <td valign="bottom" height="0.1"><div style="font-weight: bold; padding-top: 10px; padding-bottom: 0px; padding-left: 10px; font-size: 15pt;">DATA INVENTARIS RUMAH DINAS RESIDENTIAL MANAGEMENT III</div></td>
                      <td width="20%" align="middle" rowspan="4">
                        <!--<div class="logo">-->
                          <img src="<?php echo base_url(); ?>assets/templates/adminlte-2-3-11/dist/img/logo_ugmandiri.png" alt="generic business logo" height="80" width="180" />
                        <!--</div>-->
                      </td>
                    </tr>

                    <tr>
                      <td valign="top" height="0.1"><div style="font-weight: bold; padding-top: 0px; padding-bottom: 0px; padding-left: 10px; font-size: 11pt;">Griya Mandiri Mampang Blok D9</div></td>
                    </tr>

                    <tr>
                      <td valign="top" height="0.1"><div style="font-weight: bold; padding-top: 0px; padding-bottom: 0px; padding-left: 10px; font-size: 11pt;">Jl. Kapten Tendean RT 01 RW 02, Mampang Prapatan, Mampang Prapatan, Jakarta Selatan 12790</div></td>
                    </tr>
                    
                    <tr>
                      <td valign="top" height="0.0"><div style="font-weight: bold; padding-top: 0px; padding-bottom: 0px; padding-left: 10px; font-size: 11pt;">Email : residentialmanagement21@gmail.com | Website : www.ugmandiri.co.id</div></td>
                    </tr>

                  </table>

                </header>

                <div class="halaman">

                    <br><br><br><br><br><br>

                    <table style="width:100%;">
                      <tr>
                        <td valign="top" height="0.1"><div style="padding-top: 0px; padding-bottom: 0px; padding-left: 10px;"><span style="font-weight: bold; font-size: 10pt;">Laporan Rekap Aset Unit</span></div></td>
                      </tr>
                    </table>

                    <br>


                    <table style="width:100%" class="tg">
                      <tr>
                        <th class="tg-0lax">No.</th>
                        <th class="tg-0lax">Unit</th>
                        <th class="tg-0lax">Status</th>
                        <th class="tg-0lax">Bagian</th>
                        <th class="tg-0lax">Nama Aset</th>
                        <th class="tg-0lax">Ada/Tidak</th>
                      </tr>
                      <!-- block if header -->
                      <?php } ?>

                      <tr>

                        <td class="tg-0lax"><?php echo $no; ?></td>
                        <td class="tg-0pky"><?php echo $val->nama_unit . ', ' . $val->blok . ' ' . $val->no_unit; ?></td>
                        <td class="tg-0lax"><?php echo $val->status_detail ?></td>
                        <td class="tg-0lax"><?php echo $val->bagian ?></td>
                        <td class="tg-0lax"><?php echo $val->nama_aset ?></td>
                        <td class="tg-0lax"><?php echo $val->is_barang_ada ?></td>

                      </tr>

<!-- begin footer -->

                    <?php

                    /*
                    $total_biaya_ds = $total_biaya_ds + $val->jmlh_pembayaran;
                    $total_biaya_lalamove = $total_biaya_lalamove + $val->biaya_driver;
                    
                    if ($val->metode_pembayaran === 'TN'){
                      $total_uang_tunai = $total_uang_tunai + $val->jmlh_pembayaran;
                    } else { 
                      $total_uang_non_tunai = $total_uang_non_tunai + $val->jmlh_pembayaran;
                    }
                    */

                    if (($no+1) % $pembagi_mod == 0 || $no == $max){

                      if ($no == $max){

                        //$total_fee_rs = ($total_biaya_ds / 100) * $persentase_fee_rs;
                    ?>

                    <?php
                      }
                    ?>

                    </table>

                    </div><!--halaman-->

                <!-- footer bisa di taro disini -->

                <footer>

                <table class="table-footer" style="width:100%">

                    <tr>
                      <td><span style="font-weight: bold; font-size: 8pt;">Tanggal Cetak : <?php echo $this->fungsi->tanggal_indo(date('Y-m-d'), true); ?></span></td>
                    </tr>
                  
                </table>

                <p align="center"><?php echo $number_page; ?></p>

                </footer>

        <!--</page>-->

        </section>

        <?php } ?>

  <?php 
  $no++;
  } 
  // end query laporan
  ?>

  </body>

</html>