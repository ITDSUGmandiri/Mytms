<style>
/*
.content
{
  height: auto;
  background:#ffffff;
  width: 95%;
  margin-top: 50px;
  text-align:center;
  font-family: Arial;
  margin: 0 auto; 
  display:flex;
  justify-content:center;
  align-items:center;        
}																		

.isiboxb{     
  border-radius:5px;
  border: 1px solid #EBF0FF;
  margin :5px 5px 2px 5px;
  width:300px;
  height:30px;font-size:12px;
  float: center;
  background-color:#fff;
  border-radius:5;
  padding: none;
  cursor: pointer;  
  display : inline-block;
  text-align:left;
  position:relative;
  outline: none;
  padding:5px;
}

a {
  text-decoration:none !important;
}

.text_judul{
  box-sizing:border-box; 
  font-size: 24px;
  font-weight: 600;
  width:100%;
  text-align:left;
  color:#223263;
  overflow: hidden;
  text-overflow: ellipsis; 
}

.btn_keranjang{
  box-sizing:border-box; 
  font-size: 18px;
  padding:5px;
  font-weight: 460;
  height:50px;
  border-radius:15px;
  width:clamp(300px,50%,500px);
  display: flex;
  justify-content: center;
  color:#ffffff;
  overflow: hidden;
  background:#51b9ec;
  align-items:center;
  margin:5px auto;
  border:none;
}

.btn_keranjang:hover {
	transform: translateY(-2px);
	cursor: pointer;
  color :#ffffff;  
  text-decoration:none;		
}

.text_judul_des{
  box-sizing:border-box; 
  font-size: 22px;
  font-weight: 600;
  text-align:left;
  color:#223263;
}

.harga_detail{
  color:#40BFFF;
  background-color:#fff;
  text-align:left;
  font-weight: 600;
  font-size: 22px;
}

.rat_detail{
  color:grey;
  background-color:#fff;
  text-align:left;
  font-size: 22px;
}

.ket {
	color:#9098B1;
  background:#ffffff;
  overflow-x: hidden;
  overflow-y: scroll; 
  height:250px;
  text-overflow: ellipsis;
  white-space:pre-wrap;
  hyphens: auto;
  padding:1px;
  scrollbar-color: rgb(81,185,236) #9098B1 !important;
  scrollbar-width: thin !important;
}
*/

/* width */

.ket::-webkit-scrollbar {
  width: 10px;
}

.ket::-webkit-scrollbar-track {
  box-shadow: inset 0 0 5px grey; 
  border-radius: 10px;
}

/* Handle */
.ket::-webkit-scrollbar-thumb {
  background: #51b9ec; 
  border-radius: 5px;
  cursor: pointer;
}

/* Handle on hover */
.ket::-webkit-scrollbar-thumb:hover {
  background: #9098B1; 
}

/*
p{
  margin:2px;
  color:#9098B1;
}

.nama_toko{
  box-sizing:border-box; 
  cursor: pointer;
  width:100%;
  display: flex;
  background:#ffffff;
  color: #9098B1;
  text-decoration: none !important;
}

.nama_toko:hover {
  transform: translateY(-3px);
  color: #51b9ec;
}

.nama_toko_judul{
  display: block !important;;
  margin:5px;
}
*/

#map {
  height: 400px;
}

/*
.slide_box {
  height: 460px;
  width:100%;
  position: relative;
  top: auto;
  margin:bottom:5px;
  padding:5px;
}

.slide_1 {
  width:100%;
  height: 400px;
  padding:2px;
  background:transparent;
	display:flex;
	justify-content: center;
  align-items:center;
}
    
.slide_g {
  width:100%;
  height: 400px;
  cursor: pointer;
}

.slide1_g img {
  object-fit:contain;
  margin:0;
  cursor:pointer;
}

.prev_img, .next_img {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: 30px;
  height: 30px;
  display:flex;
  align-items:center;
  justify-content: center;
  margin-top: -22px;
  color: #fff !important;
  font-weight: bold;
  font-size: 18px;
  transition: 0.8s ease;
  border-radius: 50%;
  background: #000060;
  user-select: none;
  margin:5px;
}

.next_img {
  right: 5px;
  border-radius:  50%;
}

.prev_img:hover, .next_img:hover {
  background-color: transparent;
  text-decoration:none;
  color: #fff !important;
  cursor: pointer;
}

.link_bawah {
  display: flex;
  align-items:center;
  justify-content: center;
  transition:background-color 0.6s ease;
}

.active:hover {
  background-color: #717171;
  cursor: pointer;
}
*/

.muncul {
  -webkit-animation: fadein 2s; /* Safari, Chrome and Opera > 12.1 */
  -moz-animation: fadein 2s; /* Firefox < 16 */
  -ms-animation: fadein 2s; /* Internet Explorer */
  -o-animation: fadein 2s; /* Opera < 12.1 */
  animation: fadein 2s;
}

/*
.frame_bawah {
  opacity: 0.6;
  margin:2px;
  height:50px;
  width:50px;
  border-radius:5px;
  cursor:pointer;
}

.active,.frame_bawah:hover {
  opacity: 1;
  border:2px solid #000060;
}
*/

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
  background: #000060;
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
  border: 1px solid #000060;
  text-align: center;
  background: grey ;
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
  border: 1px solid #000060;
  padding:5px;
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
   border: 1px solid transparent;
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

    <?php foreach ($data_detail->result() as $data) {
      $curr_code = $data->kode;
      $curr_nama = $data->nama_lokasi;
      $curr_latitude = $data->lat;
      $curr_longitude = $data->long;
      $curr_keterangan = $data->keterangan;
      $curr_alamat_lengkap = $data->alamat_lengkap;
      $curr_photo = $data->photo;
      $curr_thumbnail = $data->thumbnail;
    } ?>

		<!-- Data detail box -->
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Detail Area</h3>

				<div class="box-tools pull-right">
					<!-- <button class="btn btn-default btn-box-tool" title="Show / Hide" id="myboxwidget"><i class="fa fa-plus"></i> Show / Hide</button> -->
				</div>
			</div>

			<div class="box-body">
        
        <?php echo $message; ?>

        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

          <?php if ($curr_photo != ''): ?>
          
          <a href="<?php echo base_url('assets/uploads/images/locations/') . $curr_photo ?>" class="thumbnail" data-fancybox data-caption="<?php echo $curr_nama; ?>">
            <img src="<?php echo base_url('assets/uploads/images/locations/') . $curr_photo ?>" alt="<?php echo $curr_nama; ?>">
          </a>

          <?php else: ?>
          <img src="<?php echo base_url('assets/uploads/images/no_picture.png') ?>" class="center-block" alt="<?php echo $curr_nama; ?>">
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
              <th class="active">Nama Area</th>
              <td><?php echo $curr_nama ?></td>
            </tr>
            <tr>
              <th class="active">Latitude</th>
              <td><?php echo $curr_latitude ?></td>
            </tr>
            <tr>
              <th class="active">Longitude</th>
              <td><?php echo $curr_longitude ?></td>
            </tr>
            <tr>
              <th class="active">Keterangan</th>
              <td><?php echo $curr_keterangan ?></td>
            </tr>
            <tr>
              <th class="active">Alamat</th>
              <td><?php echo $curr_alamat_lengkap ?></td>
            </tr>
            
          </table>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          
        <hr>

          <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-horizontal">

              <h4>Data Lokasi</h4>

              <div id="map"></div>

            </div>

          </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
          <hr>
          <button type="button" onClick="window.location='<?php echo site_url() . 'locations' ?>';" class="btn btn-default"><i class="fa fa-undo"></i> Kembali</button>
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


  <script>
  $(document).ready(function(e){
  
    var base_url = "<?php echo base_url(); ?>"; // You can use full url here but I prefer like this

  }); // End Document Ready Function
  </script>

  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB2aydOihJBxeEEqpkBSTZzHAOvZ9ZqRWk&callback=initMap">
  </script>

  <script>

    function initMap() {
      // Set the coordinates and zoom level for the map
      var myLatLng = {lat: <?php echo $curr_latitude; ?>, lng: <?php echo $curr_longitude; ?>};
      var mapOptions = {
        center: myLatLng,
        zoom: 15
      };
      // Create a new Google Map object
      var map = new google.maps.Map(document.getElementById('map'), mapOptions);
      // Add a marker to the map
      var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: 'San Francisco'
      });
    }
  
  </script>

  <script>

    $("a").click(function() {
    
      setInterval(function(){
        $(".pr").fadeOut("slow");
      }, 2000);
              
    });  

  </script>

  <script>
    
    function onClick(element){
      document.getElementById("img01").src = element.src;
      document.getElementById("modal01").style.display = "block";
    }
    
  </script>