<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Daftar Laporan Koordinator</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
						<table id="table"
				            data-toggle="table"
				            data-url="<?php echo base_url('laporan/list_data_laporan_koordinator/?cabangID='.$cabangID); ?>"
				            data-show-refresh="true"
				            data-show-toggle="true"
				            data-show-columns="true"
				            data-search="true"
				            data-select-item-name="toolbar1"
				            data-side-pagination="server"
				            data-pagination="true"
				            data-page-list="[10, 20, 50, 100, 200]">
							<thead>
						    <tr>
						        <th data-field="no" data-sortable="true">#</th>
						        <th data-field="nama_pengajar" data-sortable="true">Nama Pengajar</th>
						        <th data-field="tanggal" data-sortable="true">Tanggal</th>
						        <th data-field="aksi" data-sortable="true">Aksi</th>
						    </tr>
						    </thead>
						</table>
					</div>
				</div>
			</div><!--/.row-->
		</div>	<!--/.main-->
		<script type="text/javascript">
			function doHapus(id, judul){
				swal({
					title: "Apakah anda yakin?",
					text: "Anda akan menghapus <strong>"+judul+"</strong>",
					type: "warning",
					html: true,
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Ya, hapus!",
					closeOnConfirm: false
				},
				function(){
					window.location.href = "<?php echo base_url('laporan/delete_laporan_koordinator/?cabangID='.$cabangID.'&id='); ?>" + id;
				});
			}
		</script>