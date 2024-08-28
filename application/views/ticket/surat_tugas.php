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

</style>
<body>
<table width="100%">
		<?php
		$no=1;
foreach ($detail as $s) { 
	?>
	<tr>
		
		<td style="text-align:left"> 
		
		</td>
		<td style="text-align:right;font-size:8px;"> 
<!--	Di cetak oleh <?= $this->session->userdata('nama'); ?> pada <?= date('d-m-Y H:i:s');?>-->
	<img src="<?=$img;?>" width="155px" height="40px">
		</td>
	</tr>
</table>

<br>
<table style="width:100%; text-align:center;">
<thead>
	<tr>
		<th colspan="3" style="font-size:12px">
		SURAT TUGAS <br> <?php echo $s->tiket;?>
		</th>
		</tr>
		<tr>
		<th colspan="3" style="font-size:12px">

		</th>
		</tr>
		</thead>
		</table>

<br>

<p style="font-size:12px">Menunjuk surat perjanjian kerjasama antara PT. Bank Mandiri (Persero) Tbk Corporate Real Estate Group dengan PT Usaha Gedung Mandiri perihal pekerjaan pengelolaaan Rumah Dinas Komplek, bersama ini kami menugaskan pegawai PT. Usaha Gedung Mandiri Residential Management:</p>

<div class='row'>
	  <div class ="col-md-12">
<table width="100%" style="font-size:12px">
<tr style="text-align:left">
<td style="width:155px;">Nama</td>
<td style="width:2px;">:</td>
<td><?php echo $s->name_pic;?></td>
</tr>
<tr style="text-align:left">
<td style="width:155px;"></td>
<td style="width:2px;"></td>
<td><?php echo $s->name_pic1;?></td>
</tr>
<tr style="text-align:left">
<td style="width:155px;">Jabatan</td>
<td style="width:2px;">:</td>
<td><?php echo $s->jabatan;?></td>
</tr>
<tr style="text-align:left">
<td style="width:155px;">Lokasi</td>
<td style="width:2px;">:</td>
<td> <?php echo $s->nama_unit;?> <?php if(!empty($s->blok)||$s->blok != null){ echo $s->blok;} ?> <?php echo $s->no_unit;?></td>
</tr>
<tr style="text-align:left">
<td style="width:155px;">Tugas</td>
<td style="width:2px;">:</td>
<td><?php echo $s->job_detail;?></td>
</tr>

</table>
</div>
  
</div>


<br>
<p style="font-size:12px">Demikian surat tugas ini kami buat untuk dipergunakan sebagaimana mestinya. Atas perhatiannya kami ucapkan terima kasih.</p>
<br>
<p style="font-size:12px">Jakarta,
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
 
echo tgl_indo(date('Y-m-d'));?><br>
PT USAHA GEDUNG MANDIRI
<br><br><br><br><br>
 <b><u>Yusuf Ridar</u></b><br>
 Residential Management Mgr III
</p>
<br>
<p style="font-size:12px"><b>Mohon di isi dan ditandatangani oleh Penghuni / Petugas</b></p>
<table  style="font-size:11px;width:100%;" >

<tr>
<td><b style="font-size:12px">Jam Datang:.......................................       </b></td>
<td><p style="font-size:12px;text-align:center;"><b>Penghuni</b></p></td>
		</tr>
		<tr>
<td><b style="font-size:12px">Jam Pulang:.......................................       </b></td>
<td><p style="font-size:12px"></td>
		</tr>

			<tr>
<td><p style="font-size:12px"><b></b></p></td>
<td><p style="font-size:12px;text-align:center;"><br><br><br><br><br><b>(.......................................)</b></p></td>
		</tr>

</table>
<br>
 <b>Catatan</b><br>

 <table  style="font-size:11px;width:100%;border:solid 1px;" >
			<tr>
<td><p style="font-size:12px;text-align:center;"><br><br><br><br><br><b></b></p></td>
		</tr>

</table>
<?php
$no++;
} ?>
</body>