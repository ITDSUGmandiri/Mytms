    <style>
    #state {
        display: none;
    }
    </style>

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

            <div class="row">

                <div class="col-md-6">
        
                    <div class="box">

                        <div class="box-header with-border">
                            <h3 class="box-title">Laporan Rekap Ticket Insident</h3>
                        </div>

                        <div class="box-body">

                            <form action="<?php echo base_url('laporan/rekap_aset_unit') ?>" role="form" id="f_laporan_rekap_aset_unit" method="GET" enctype="multipart/form-data" autocomplete="off">

                                <div class="box-body">

                                    <div class="form-group">
                                    
                                        <label for="id_lok">Area</label>
                                                                                                    
                                        <select class="form-control" id = "id_lok" name="id_lok">
                                            <option value="0" selected="selected">- Pilih Area -</option>
                                        </select>

                                        <input type="hidden" name="nama_lokasi" id="nama_lokasi" value="-">
                                            
                                    </div>

                                    <div class="form-group">
                                    
                                        <label for="id_unit">Nama Unit</label>
                                                                                                    
                                        <select class="form-control select2" id = "id_unit" name="id_unit">
                                            <option value="0" selected="selected">- Pilih Unit -</option>
                                        </select>

                                        <input type="hidden" name="nama_unit" id="nama_unit" value="-">
                                            
                                    </div>

                                    <div class="form-group">
                                    
                                        <label for="jenis_laporan">Jenis Laporan</label>
                                                                                                    
                                        <select class="form-control" id = "jenis_laporan" name="jenis_laporan">
                                            <option value="0" selected="selected">- Jenis Laporan -</option>
                                            <option value="1">Ada</option>
                                            <option value="2">Tidak Ada</option>
                                        </select>

                                        <input type="hidden" name="nama_unit" id="nama_unit" value="-">
                                        <p class="help-block">Pastikan parameter yang tersedia tidak kosong </p>
                                            
                                    </div>
                                    
                                </div><!-- /.box-body -->

                                <div class="box-footer">
                                                                    
                                    <button name="btn_print" type="submit" class="peringatan btn btn-default" id = "btn_print"><i class="fa fa-save"></i> Print</button>
                                    <button name="btn_excel" type="submit" class="peringatan btn btn-default" id = "btn_excel"><i class="fa fa-file-excel-o"></i> Excel</button>
                                    <button type="button" onClick="window.location='<?php echo site_url();?>laporan';" class="btn btn-default"><i class="fa fa-undo"></i> Cancel</button>
                                    
                                </div>

                            </form>
                    
                        </div><!-- /.box-body -->

                    </div><!-- /.box -->

                </div><!-- /.col-md-6 -->

            </row>
		  
        </section><!-- /.content -->

      </div><!-- /.content-wrapper -->

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

    $(function(){
        //Initialize Select2 Elements
        $(".select2").select2();
        load_dropdown_area();
    });

    </script>

    <script type="text/javascript">

    $(document).ready(function(){

        $('#id_lok').change(function(){
        
            load_dropdown_nama_unit(this.value);
            var nama_lokasi = $("#id_lok option:selected").text();
            $('#nama_lokasi').val(nama_lokasi);

        });

    })
    </script>

    <script type="text/javascript">

    function load_dropdown_area(){
		
		//get a reference to the select element
		var $id_lok = $('#id_lok');

		//request the JSON data and parse into the select element
		$.ajax({
		url:'<?php echo site_url() . 'locations/load_dropdown_area'; ?>',
		dataType: 'JSON', 
		success: function(data){

			//clear the current content of the select
			$id_lok.html('');
			$id_lok.append('<option value = "0">- Pilih Area -</option>');
			//iterate over the data and append a select option
			$.each(data.list_data, function (key, val){
				$id_lok.append('<option value = "' + val.id + '">' + val.nama_lokasi + '</option>');
			})

		}, 			
		error: function(){
			$id_lok.html('<option value = "-1">- Data tidak ada -</option>');
		}
							
		});

	}

    function load_dropdown_nama_unit(id_lok){
		
		//get a reference to the select element
		var $id_unit = $('#id_unit');
        $("#id_unit").html('<option value="0">Loading...</option>');

        $.ajax({
        method: "POST",
        url:'<?php echo site_url() . 'unit/load_dropdown_nama_unit'; ?>',
        dataType: 'JSON', 
        data: {id_lok: id_lok},
        success: function(data){

            if (data.is_data_ada){

                //clear the current content of the select
                $id_unit.html('');
                $id_unit.append('<option value = "0">- Silahkan Pilih -</option>');

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

    </script>