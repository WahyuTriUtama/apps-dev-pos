<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">DATA</h3>
  </div>
  <div class="box-body">
    <div id="dataview">
		<table id="mytable" class="table table-striped table-bordered dt-responsive nowrap display">
		  <thead>
		    <tr>
		      <th width="5%">No</th>
		      <th>Tipe</th>
		      <th>Tanggal</th>
		      <th>User</th>
		      <th>Total Penjualan</th>
		      <th>Amount</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php 
		  	$no = 0;
		  	foreach ($model->result() as $row) { ?>
		  		<tr>
		  			<td><?= ++$no; ?></td>
		  			<td><?= ucfirst($row->doc_type); ?></td>
		  			<td><?= $row->doc_date; ?></td>
		  			<td><?= ucfirst($row->name).' ( '.$row->username.' )'; ?></td>
		  			<td class="text-right"><?= format_currency($row->total_sales); ?></td>
		  			<td class="text-right"><?= format_currency($row->amount); ?></td>
		  		</tr>
		  	<?php } ?>
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