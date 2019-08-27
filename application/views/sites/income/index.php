<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">DATA
    </h3>
  </div>
  <div class="box-body">
    <div id="dataview">
		<table id="mytable" class="table table-striped table-bordered dt-responsive nowrap display">
		  <thead>
		    <tr>
		      <th width="5%">No</th>
		      <th>Tahun</th>
		      <th>Bulang</th>
		      <th>Total Pembelian</th>
		      <th>Total Penjualan</th>
		      <th>Laba / Rugi</th>
		    </tr>
		  </thead>
		  <tbody>
		  	
		  </tbody>
		</table> 
	</div>
  </div>
  <!-- /.box-body -->
</div>

<script>
	$(function() {
		var table;
		table = $('#mytable').DataTable({
			'processing'  : true,
			'paging'      : true,
			'lengthChange': false,
			'searching'   : true,
			'ordering'    : true,
			'info'        : true,
			'autoWidth'   : true,
			'iDisplayLength': <?= $page_limit;?>
	    });
	});
</script>