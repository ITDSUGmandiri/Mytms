<style>
Body {
 font-family: Arial, Helvetica, sans-serif;
}


	.tbl 	
	{
		text-align:center; 
		font-size:11px; border:1px groove black;
		border-collapse: collapse;
	}
	.tbl th	
	{
		text-align:center; 
		font-size:10px; border:1px groove black;
	}
	.tbl td	
	{
		text-align:center; 
		font-size:10px; border:1px groove black;
		padding:1px;
	}
   .checkbox-container {
            display: block;
          
        }

        .checkbox-container label {
            display: block;
            margin-right: 15px;
            vertical-align: middle; /* Menyelaraskan vertikal dengan nilai tengah */
        }


</style>
<body>
			<?php
foreach ($detail as $s) { 
	?>
<table width="100%">

	<tr>
		<td style="text-align:center;width:33%;"> 
		</td>
		<td style="text-align:center;width:33%;"> 	<p style='text-align:center;'><br>PT.USAHA GEDUNG MANDIRI <br> RESIDENTAL MANAGEMENT III</b></p>
		</td>
		<td style="text-align:right;font-size:8px;;width:34%;"> 
	<img src="<?=$img;?>" width="155px" height="35px">
		</td>
	</tr>
</table>

	

<div style="border-top: 4px groove black; margin-top: 1em; padding-top: 1em;"></div>
<p style='text-align:center;'><br>Berita Acara Penyelesaian Pekerjaan
 (BAPP)</b></p>

<div class='row'>
<div class ="col-md-12">
<table width="100%" style="font-size:12px">
<tr style="text-align:left">
<td style="width:155px;">Alamat Rumah</td>
<td style="width:2px;">:</td>
<td><?php echo $s->nama_unit;?>  <?php echo $s->blok;?> <?php echo $s->no_unit;?></td>
</tr>
<tr style="text-align:left">
<td style="width:155px;">Nama Penghuni</td>
<td style="width:2px;">:</td>
<td><?php echo $s->nama;?></td>
</tr>
<tr style="text-align:left">
<td style="width:155px;">Jabatan</td>
<td style="width:2px;">:</td>
<td><?php echo $s->jabatan;?></td>
</tr>
</table>
</div>
</div>

<br>

<div class='row'>
<div class ="col-md-12">
<table width="100%" style="font-size:12px" border='1'>
<thead>
	<tr style="text-align:center; background:grey;">
		<th>Nomor Job Order</th>
		<th>Tanggal</th>
		<th>Jam</th>
		<th>Nama Penerima</th>
		<th>Keluhan</th>
</tr>
</thead>
<tr style="text-align:center">
<td><?php echo $s->tiket;?> </td>
<td><?php echo date('d/m/Y', strtotime($s->create_date));?> </td>
<td><?php echo date('h:i:sa', strtotime($s->create_date));?></td>
<td><?php echo $s->usc;?> </td>
<td><?php echo $s->job_detail;?> </td>
</tr>
</table>
</div>
</div>
<br>
<table width='50%'>
<tr style="text-align:left;font-size:12px;">
<td style="width:155px;">Keluhan Selesai</td>
<td style="width:2px;">:</td>
<td><?php echo $s->finish_date;?> </td>

</tr>
</table>

<p style="font-size:12px">Penyelesaian: <?php echo $s->note;?></p>

<p style="font-size:12px">Dengan ini kami menyatakan bahwa pekerjaan telah selesai 100%.</p>
<p style="font-size:12px">Atas pelayanan yang telah di berikan, kami menyatakan :</p>
<div class="checkbox-container">
    <label style="font-size:12px">
        <input type="checkbox" name="checkbox1" style="font-size:12px"  <?php if($s->rating==4) {echo 'checked';}?>> Sangat Puas
    </label>
    <label style="font-size:12px">
        <input type="checkbox" name="checkbox2" style="font-size:12px" <?php if($s->rating==3) {echo 'checked';}?>> Puas
    </label>
    <label style="font-size:12px">
        <input type="checkbox" name="checkbox3" style="font-size:12px" <?php if($s->rating==2) {echo 'checked';}?>> Cukup Puas
    </label>
    <label style="font-size:12px">
        <input type="checkbox" name="checkbox4" style="font-size:12px" <?php if($s->rating==1) {echo 'checked';}?>> Tidak Puas
    </label>
</div>
<p style="font-size:12px">Tanggal : Jakarta,
<?php
function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
 
echo tgl_indo(date('Y-m-d', strtotime($s->create_date)));?><br>


<table  style="font-size:11px;width:100%;text-align:center;">

		<tr>
<td style="text-align:center;width:33%;"><b style="font-size:12px">Petugas</b></td>
<td style="text-align:center;width:33%;"></td>
<td style="text-align:center;width:33%;"><b style="font-size:12px;text-align:right;">Pelapor</b></td>
		</tr>
		<tr>
<td><p style="font-size:12px">	
<?php if (file_exists('Doc/sign_user/'.$s->pic.'.png')) {  ?>

<img  src="<?php $path = 'Doc/sign_user/'.$s->pic.'.png';
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$dt = file_get_contents($path);
						$foto= 'data:image/' . $type . ';base64,' . base64_encode($dt);
						echo $foto;
						?>"  height="40px">
<?php  }?>
</td>
<td></td>
<td><p style="font-size:12px">	
<?php if (file_exists('Doc/sign/'.$s->file_upload.'') && $s->file_upload !='') {  ?>

<img  src="<?php $path = 'Doc/sign/'.$s->file_upload.'';
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$dt = file_get_contents($path);
						$foto= 'data:image/' . $type . ';base64,' . base64_encode($dt);
						echo $foto;
						?>"  height="40px">
<?php  }?>
</td>
		</tr>
	<tr>
<td><p style="font-size:12px;text-align:center;"><b>( <?php echo $s->name_pic;?> / <?php echo $s->name_pic1;?> ) <br> ( Teknisi )</b></p></td>
<td></td>
<td><p style="font-size:12px;text-align:center;"><b>( <?php echo $s->nama;?> ) <br> ( <?php echo $s->jabatan;?> )</b></p></td>
		</tr>
</table>


<table  style="font-size:11px;width:100%;text-align:center;" >

		<tr>
<td><b style="font-size:12px">Mengetahui</b></td>

		</tr>
		<tr>
<td><?php if (file_exists('Doc/sign_user/'.$s->gb.'.png')) {  ?>

<img  src="<?php $path = 'Doc/sign_user/'.$s->gb.'.png';
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$dt = file_get_contents($path);
						$foto= 'data:image/' . $type . ';base64,' . base64_encode($dt);
						echo $foto;
						?>"  height="40px">
<?php  }?>

</td>
		</tr>

	<tr> 
<td><p style="font-size:12px;text-align:center;"><b>( <?php echo $s->manager;?> ) <br> ( Residential Management Mgr ) </b></p></td>

		</tr>



</table>
<?php
} ?>
</body>