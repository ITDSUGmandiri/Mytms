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
             
              <div class="box">

                <div class="box-header with-border">
                    <h3 class="box-title">List Data Unit</h3>
                </div>

                <div class="box-header with-border">
                    <h5><?php echo $tabletitle ?></h5>
				        </div>

                <div class="box-header with-border">

                    <div class="row">

                        <div class="col-md-3">
                        
                          <select name="id_unit" id="id_unit" class="form-control select2">
                            <option value="0">- Pilih Unit -</option>
                          </select>

                        </div>

                        <div class="col-md-3">
                        
                          <select name="id_status" id="id_status" class="form-control">
                          </select>

                        </div>

                        <div class="col-md-3">
                        
                          <select name="klasifikasi_id" id="klasifikasi_id" class="form-control">
                          </select>

                        </div>

                        <div class="col-md-3">
                          
                          <div class="btn-group">
                            <button type="button" onClick="reload_table()" class="btn btn-default"><i class="fa fa-undo"></i> Refresh</button>
                          </div>
                          
                        </div>
        
                    </div>
                
                </div>

				
                <div class="box-body">
                  <div class="table-responsive">
                  
                    <table id="dataTables-list" class="table table-bordered table-striped" cellspacing="0" width="100%">
                      <thead>

                          <tr>
                              <th style="text-align: center;"></th>
                              <th style="text-align: center;">Klasifikasi</th>
                              <th style="text-align: center;">Nama Unit</th>
                              <th style="text-align: center;">Status Hunian</th>
                              <th style="text-align: center;">Foto</th>
                              <th style="text-align: center;">Alamat Lengkap</th>
                              <th style="text-align: center;">#</th>
                          </tr>

                      </thead>
                    
                    </table>
                  
                  </div>
                </div><!-- /.box-body -->	
				
				<div class="box-footer">
          
				</div>
				
              </div><!-- /.box -->
		  
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
	  <!-- Modal -->

                <!-- Modal form-->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel"></h4>
                      </div>
                      <div class="modal-body" id="modal-bodyku">
                      </div>
                      <div class="modal-footer" id="modal-footerq">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="modal fade" id="mdl_update_status" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog ">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <h4 class="modal-title" id="myModalLabel-status"></h4>
                      </div>

                      <div class="modal-body" id="modal-bodyku-status">
                      </div>

                      <div class="modal-footer" id="modal-footerq-status">
                      </div>
                    </div>
                  </div>
                </div>

    <!-- DATA TABLES -->
    <link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
				
    <!-- jQuery 2.1.4 -->
    <!--<script src="<?php echo base_url(); ?>assets/templates/adminlte-2-3-11/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>-->

    <!-- jQuery 2.2.3 -->
    <script src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>

    <!-- Bootstrap 3.3.2 JS -->
    <!--<script src="<?php echo base_url(); ?>assets/templates/adminlte-2-3-11/bootstrap/js/bootstrap-3.3.2.min.js" type="text/javascript"></script>-->

    <!-- Bootstrap 3.3.6 -->
    <script src="<?php echo base_url('assets/templates/adminlte-2-3-11/bootstrap/js/bootstrap.min.js'); ?>"></script>

    <!-- DATA TABES SCRIPT -->
    <script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    
    <!-- SlimScroll -->
    <!--<script src="<?php echo base_url(); ?>asset/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>-->
    <!-- FastClick -->
    <!--<script src="<?php echo base_url(); ?>asset/plugins/fastclick/fastclick.min.js" type="text/javascript"></script>-->
    <!-- AdminLTE App -->
    <!--<script src="<?php echo base_url(); ?>asset/dist/js/app.min.js" type="text/javascript"></script>-->
    <!-- AdminLTE for demo purposes -->
    <!--<script src="<?php echo base_url(); ?>asset/dist/js/demo.js" type="text/javascript"></script>-->

    <!--<script src="<?php echo base_url(); ?>assets/dist/js/myclass.js" type="text/javascript"></script>-->

    <!-- SlimScroll -->
    <script src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/slimScroll/jquery.slimscroll.min.js'); ?>"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/fastclick/fastclick.js'); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url('assets/templates/adminlte-2-3-11/dist/js/app.min.js'); ?>"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url('assets/templates/adminlte-2-3-11/dist/js/demo.js'); ?>"></script>

    <script src="<?php echo base_url(); ?>assets/templates/adminlte-2-3-11/dist/js/myclass.js" type="text/javascript"></script>
    
    <!-- page script -->

<script type="text/javascript">

  var site_url = "<?php echo site_url() . 'inventory/datatables_unit_by_area/' . $id_lok ?>";
  var table;

  $(document).ready(function(){

    let id_lok = <?php echo $id_lok ?>;

    load_dropdown_nama_unit(id_lok);
    load_dropdown_status();
    load_dropdown_klasifikasi();
        
      table = $('#dataTables-list').DataTable({ 

        "bSort" : true,
        "sPaginationType": "full_numbers",
        "bAutoWidth": true, // Disable the auto width calculation
        "bProcessing": true, //Feature control the processing indicator.
        "bServerSide": true, //Feature control DataTables' server-side processing mode.
        "scrollX":true,
        //"bFilter": true,
                
        "sAjaxSource": site_url,
        "fnServerParams": function ( aoData ) {
          aoData.push( 
            { "name": "id_unit", "value": $('#id_unit').val()},
            { "name": "id_status", "value": $('#id_status').val()},
            { "name": "klasifikasi_id", "value": $('#klasifikasi_id').val()} 
          );
        },
        
        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          //"targets": [ -1 ], //last column
          //"orderable": false, //set not orderable
          "targets" : [0],
          "className" : "text-center"
        },
        { 
          "targets" : [1],
          "className" : "text-center"
        },
        { 
          "targets" : [2],
          "className" : "text-center"
        },
        { 
          "targets" : [3],
          "className" : "text-center"
        },
        { 
          "targets" : [4],
          "className" : "text-center"
        },
        { 
          "targets" : [5],
          "className" : "text-left"
        },
        { 
          "targets" : [6],
          "className" : "text-center"
        }
        ],

        "aaSorting": [[0, "desc" ]],
        
      });

      $('#id_unit, #id_status, #klasifikasi_id').change(function(){
        //table.draw();
        reload_table()
	   	});
	   	
		  /*
      $('#searchName').keyup(function(){
	   		userDataTable.draw();
	   	});
      */

  });
	
  function reload_table(){
    table.ajax.reload(null,false); //reload datatable ajax 
  }
	
	function setModalBox(title,content,footer,$size)
  {
                
        document.getElementById('modal-bodyku').innerHTML=content;
        document.getElementById('myModalLabel').innerHTML=title;
        document.getElementById('modal-footerq').innerHTML=footer;
                
        if ($size == 'large')
        {
        $('#myModal').attr('class', 'modal fade bs-example-modal-lg')
        .attr('aria-labelledby','myLargeModalLabel');
        $('.modal-dialog').attr('class','modal-dialog modal-lg');
        }
        
        if ($size == 'standart')
        {
        $('#myModal').attr('class', 'modal fade')
        .attr('aria-labelledby','myModalLabel');
        $('.modal-dialog').attr('class','modal-dialog');
        }
                
        if ($size == 'small')
        {
        $('#myModal').attr('class', 'modal fade bs-example-modal-sm')
        .attr('aria-labelledby','mySmallModalLabel');
        $('.modal-dialog').attr('class','modal-dialog modal-sm');
        }

  }

  function setModalBoxStatus(title,content,footer,$size)
  {
            
    document.getElementById('modal-bodyku-status').innerHTML=content;
    document.getElementById('myModalLabel-status').innerHTML=title;
    document.getElementById('modal-footerq-status').innerHTML=footer;

            if($size == 'large')
            {
                $('#mdl_update_status').attr('class', 'modal fade bs-example-modal-lg')
                             .attr('aria-labelledby','myLargeModalLabel');
                $('.modal-dialog').attr('class','modal-dialog modal-lg');
            }
            if($size == 'standart')
            {
                $('#mdl_update_status').attr('class', 'modal fade')
                             .attr('aria-labelledby','myModalLabel');
                $('.modal-dialog').attr('class','modal-dialog');
            }
            if($size == 'small')
            {
                $('#mdl_update_status').attr('class', 'modal fade bs-example-modal-sm')
                             .attr('aria-labelledby','mySmallModalLabel');
                $('.modal-dialog').attr('class','modal-dialog modal-sm');
            }

  }

  function load_dropdown_status(){
		
		//get a reference to the select element
		var $id_status = $('#id_status');

		//request the JSON data and parse into the select element
		$.ajax({
		url:'<?php echo site_url() . 'inventory/load_dropdown_status'; ?>',
		dataType: 'JSON', 
		success: function(data){

			//clear the current content of the select
			$id_status.html('');
			$id_status.append('<option value = "0">- Pilih Status -</option>');
			//iterate over the data and append a select option
			$.each(data.list_data, function (key, val){
				$id_status.append('<option value = "' + val.id + '">' + val.status_detail + '</option>');
			})

		}, 			
		error: function(){
			$id_status.html('<option value = "-1">- Data tidak ada -</option>');
		}
							
		});

	}

  function load_dropdown_nama_unit(id_lok){
		
		//get a reference to the select element
		var $id_unit = $('#id_unit');
    $("#id_unit").html('<option value="0">Loading...</option>');

    $.ajax({
    method: "POST",
    url:'<?php echo site_url() . 'unit/load_dropdown_nama_unit/' ?>',
    dataType: 'JSON', 
    data: {id_lok: id_lok},
		success: function(data){

				if (data.is_data_ada){

					//clear the current content of the select
					$id_unit.html('');
					$id_unit.append('<option value = "0">- Pilih Unit -</option>');

					//iterate over the data and append a select option

					$.each(data.list_data, function (key, val){
					  $id_unit.append('<option value = "' + val.id + '">' + val.nama_unit + '</option>');
					});

				} else {
					$id_unit.html('<option value = "0">- Tidak Ada Unit -</option>');
				}

		}, 			
		error: function(){
			//if there is an error append a 'none available' option
			$id_unit.html('<option value = "0">- Tidak Ada Unit -</option>');
		}

    });

	}

  function load_dropdown_klasifikasi(){
		
		//get a reference to the select element
		var $klasifikasi_id = $('#klasifikasi_id');

		//request the JSON data and parse into the select element
		$.ajax({
		url:'<?php echo site_url() . 'unit/load_dropdown_klasifikasi'; ?>',
		dataType: 'JSON', 
		success: function(data){

			//clear the current content of the select
			$klasifikasi_id.html('');
			$klasifikasi_id.append('<option value = "0">- Pilih Klasifikasi -</option>');
			//iterate over the data and append a select option
			$.each(data.list_data, function (key, val){
				$klasifikasi_id.append('<option value = "' + val.id + '">' + val.klasifikasi + '</option>');
			})

		}, 			
		error: function(){
			$klasifikasi_id.html('<option value = "-1">- Data tidak ada -</option>');
		}
							
		});

	}

  function list_aset_by_unit_area(id_area, id_unit)
	{
		window.location='<?php echo site_url(); ?>'+'inventory/by_aset_unit_area/'+id_area+'/'+id_unit;
	}

  function detail_penghuni(kode_penghuni, id_unit, id_area)
	{
		window.location='<?php echo site_url(); ?>'+'inventory/detail_penghuni/'+kode_penghuni+'/'+id_unit+'/'+id_area;
	}
</script>