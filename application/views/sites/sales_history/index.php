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
		      <th width="10%">#</th>
		      <th>Kode</th>
		      <th>Tanggal</th>
		      <th>Pelanggan</th>
		      <th>Status</th>
		      <th>Total Amount</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php 
		  	$no = 0;
		  	foreach ($model->result() as $row) { ?>
		  		<tr>
		  			<td><?= ++$no; ?></td>
		  			<td class="text-center">
		  				<!-- <a href='<?= base_url().$controller_id;?>/update/<?= $row->id; ?>' title='Edit' class='btn btn-flat btn-warning btn-xs'><i class='fa fa-edit'></i></a> -->
                    	<a href='<?= base_url().$controller_id;?>/delete/<?= $row->id; ?>' onclick='return confirm("Are you sure ?")' class='btn btn-flat btn-danger btn-xs' title='Delete'><i class='fa fa-trash-o'></i></a>
		  			</td>
		  			<td><?= $row->code; ?></td>
		  			<td><?= $row->document_date; ?></td>
		  			<td><a href="<?= base_url();?>sites/customer/update/<?= $row->customer_id; ?>" target="_blank"><?= $row->customer_name ?></a></td>
		  			<td><?= ucfirst($row->status); ?></td>
		  			<td class="text-right"><?= format_currency($row->total_amount); ?></td>
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