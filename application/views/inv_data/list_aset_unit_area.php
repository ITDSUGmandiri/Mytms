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
                  <h3 class="box-title">List Data Aset</h3>
                </div>

                <div class="box-header with-border">
                  <div class="box-title"><h5><?php echo $tabletitle ?></h5></div>
                </div>

                <div class="box-header with-border">

                    <div class="row">

                        <div class="col-md-3">

                          <select name="id_status" id="id_status" class="form-control">
                          </select>

                        </div>

                        <div class="col-md-3">
                        
                          <select name="id_kategori" id="id_kategori" class="form-control">
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
                  
                    <table id="dataTables-list" class="table table-bordered table-striped" cellspacing="0">
                      <thead>
                        <tr>
                          <th style="text-align: center;"></th>
                          <th style="text-align: center;">Lokasi</th>
                          <th style="text-align: center;">Unit</th>
                          <th style="text-align: center;">Nama Aset</th>
                          <th style="text-align: center;">Bagian</th>
                          <th style="text-align: center;">No. Aset</th>
                          <th style="text-align: center;">Jenis</th>
                          <th style="text-align: center;">Merek</th>
                          <th style="text-align: center;">Bahan</th>        
                          <th style="text-align: center;">Jumlah</th>
                          <th style="text-align: center;">Kondisi Fisik</th>
                          <th style="text-align: center;">Tahun Perolehan</th>
                          <th style="text-align: center;">Foto</th>
                          <th style="text-align: center;">Keterangan</th>
                          <th style="text-align: center;">No. Seri</th>
                          <th style="text-align: center;">Harga Beli</th>        
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

    <!-- DATA TABLES -->
    <link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

    <!-- jQuery 2.2.3 -->
    <script src="<?php echo base_url('assets/templates/adminlte-2-3-11/plugins/jQuery/jquery-2.2.3.min.js'); ?>"></script>

    <!-- Bootstrap 3.3.6 -->
    <script src="<?php echo base_url('assets/templates/adminlte-2-3-11/bootstrap/js/bootstrap.min.js'); ?>"></script>

    <!-- DATA TABES SCRIPT -->
    <script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
    
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

    var site_url = "<?php echo site_url() . 'inventory/datatables_aset_by_unit_area/' . $id_lok . '/' . $id_unit ?>";
    var table;

    $(document).ready(function(){

        load_dropdown_categories();
        load_dropdown_status();
        
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
            { "name": "id_kategori", "value": $('#id_kategori').val()},
            { "name": "id_status", "value": $('#id_status').val()} 
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
          "className" : "text-left"
        },
        { 
          "targets" : [2],
          "className" : "text-left"
        },
        { 
          "targets" : [3],
          "className" : "text-left"
        },
        { 
          "targets" : [4],
          "className" : "text-center"
        },
        { 
          "targets" : [5],
          "className" : "text-center"
        },
        { 
          "targets" : [6],
          "className" : "text-left"
        },
        { 
          "targets" : [7],
          "className" : "text-center"
        },
        { 
          "targets" : [8],
          "className" : "text-left"
        },
        { 
          "targets" : [9],
          "className" : "text-center"
        },
        { 
          "targets" : [10],
          "className" : "text-center"
        },
        { 
          "targets" : [11],
          "className" : "text-center"
        },
        { 
          "targets" : [12],
          "className" : "text-center"
        },
        { 
          "targets" : [13],
          "className" : "text-left"
        },
        { 
          "targets" : [14],
          "className" : "text-center"
        },
        { 
          "targets" : [15],
          "className" : "text-right"
        },
        { 
          "targets" : [16],
          "className" : "text-center"
        }

        ],
        "aaSorting": [[0, "desc" ]],
      });

      $('#id_kategori, #id_status').change(function(){
        //table.draw();
        reload_table()
	   	});
	   			  
      $('#searchName').keyup(function(){
	   		userDataTable.draw();
	   	});

    });
	
  function reload_table(){
    table.ajax.reload(null,false); //reload datatable ajax 
  }

  function timeline_pengiriman(id){
    window.location='<?php echo site_url(); ?>'+'trantarobat/timeline_pengiriman/'+id;
  }

  function load_dropdown_status(){
		
		//get a reference to the select element
		var $id_status = $('#id_status');

		//request the JSON data and parse into the select element
		$.ajax({
		url:'<?php echo site_url() . 'status/load_dropdown_status'; ?>',
		dataType: 'JSON', 
		success: function(data){

			//clear the current content of the select
			$id_status.html('');
			$id_status.append('<option value = "0">- Pilih Status -</option>');
			//iterate over the data and append a select option
			$.each(data.list_data, function (key, val){
				$id_status.append('<option value = "' + val.id + '">' + val.name + '</option>');
			})

		}, 			
		error: function(){
			$id_status.html('<option value = "-1">- Data tidak ada -</option>');
		}
							
		});

	}

  function load_dropdown_categories(){
		
		//get a reference to the select element
		var $id_kategori = $('#id_kategori');

		//request the JSON data and parse into the select element
		$.ajax({
		url:'<?php echo site_url() . 'categories/load_dropdown_categories'; ?>',
		dataType: 'JSON', 
		success: function(data){

			//clear the current content of the select
			$id_kategori.html('');
			$id_kategori.append('<option value = "0">- Pilih Kategori -</option>');
			
      //iterate over the data and append a select option
			$.each(data.list_data, function (key, val){
				$id_kategori.append('<option value = "' + val.id + '">' + val.name + '</option>');
			})

		}, 			
		error: function(){
			$id_kategori.html('<option value = "0">- Data tidak ada -</option>');
		}
							
		});

	}
  
  function list_aset_by_unit_area(id_area, id_unit){
		window.location='<?php echo site_url(); ?>'+'inventory/by_aset_unit_area/'+id_area+'/'+id_unit;
	}

  function detail(kode_penghuni){
		window.location='<?php echo site_url(); ?>'+'inventory/detail/'+kode_penghuni;
	}
</script>