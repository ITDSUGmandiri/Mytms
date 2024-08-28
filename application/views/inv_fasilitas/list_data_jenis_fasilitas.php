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
                    <h3 class="box-title">List Data Fasilitas</h3>
                </div>

                <div class="box-header with-border">
                    <h5><?php echo $tabletitle ?></h5>
				        </div>

                <div class="box-header with-border">

                    <div class="row">

                        <div class="col-md-3">
                        
                          <select name="jenis_fasilitas" id="jenis_fasilitas" class="form-control">
                            <option value="0">- Jenis Fasilitas -</option>
                            <option value="Umum">Umum</option>
                            <option value="Sosial">Sosial</option>
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
                              <th></th>
                              <th style="text-align: center;">Code</th>
                              <th style="text-align: center;">Nama Fasilitas</th>
                              <th style="text-align: center;">Jenis Fasilitas</th>
                              <th style="text-align: center;">Detail</th>
                              <th style="text-align: center;">Photo</th>
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

    var site_url = "<?php echo site_url() . 'fasilitas/datatables_fasilitas_by_area/' . $id_lok ?>";
    var table;

    $(document).ready(function(){
        
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
            //{ "name": "id_faskes", "value": $('#id_faskes').val()},
            { "name": "jenis_fasilitas", "value": $('#jenis_fasilitas').val()} 
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
          "className" : "text-left"
        },
        { 
          "targets" : [3],
          "className" : "text-center"
        },
        { 
          "targets" : [4],
          "className" : "text-left"
        },
        { 
          "targets" : [5],
          "className" : "text-center"
        },
        { 
          "targets" : [6],
          "className" : "text-center"
        }
        ],

        "aaSorting": [[0, "desc" ]],
        
      });

      $('#jenis_fasilitas').change(function(){
        reload_table()
	   	});

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
	
	function detail_data(id)
    {

            $.ajax({
            type:'POST',
            url:'<?php echo site_url() . 'mspasien/detail_data'; ?>/'+id,
            success:function(data)
            {
                
                $('#bddetail').html(data);
                $('.help-block').empty(); // clear error string
                var size='large';
                var content = data;
                var title = 'Detail data';
                                                    
                var footer = '<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>';
                setModalBox(title,content,footer,size);
                
                //if success close modal and reload ajax table
                $('#myModal').modal('show');
                
            }
                
            });
                    
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

  function edit_data(id, order_id_lala_move){

    if (order_id_lala_move.trim() != ''){
      alert('Data yang sudah dikirim tidak dapat dirubah lagi !!');
      return false;
    }

		window.location='<?php echo site_url(); ?>'+'trantarobat/edit_data/'+id;

	}

  function timeline_pengiriman(id){
    window.location='<?php echo site_url(); ?>'+'trantarobat/timeline_pengiriman/'+id;
  }

  function list_aset_by_unit_area(id_area, id_unit)
	{
		window.location='<?php echo site_url(); ?>'+'inventory/by_aset_unit_area/'+id_area+'/'+id_unit;
	}

  function detail_penghuni(id_area, id_unit)
	{
		window.location='<?php echo site_url(); ?>'+'inventory/detail_penghuni/'+id_area+'/'+id_unit;
	}
</script>