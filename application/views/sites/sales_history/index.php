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
		      <th>Kasir</th>
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
		  				<a href='<?= base_url().$controller_id;?>/view/<?= $row->id; ?>' title='View' class='btn btn-flat btn-info btn-xs'><i class='fa fa-eye'></i></a>
		  				&nbsp;
		  				<button type="button" onclick="print(<?= $row->id; ?>)" class="btn btn-flat btn-xs btn-default"><i class="fa fa-print"></i></button>
		  			</td>
		  			<td><?= $row->code; ?></td>
		  			<td><?= $row->document_date; ?></td>
		  			<td><a href="<?= base_url();?>sites/customer/update/<?= $row->customer_id; ?>" target="_blank"><?= $row->customer_name ?></a></td>
		  			<td><?= $this->User_model->find_where(['id' => $row->user_id])->row()->name; ?></td>
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

	function print(id) {
        var urlNew = "<?= base_url($cls_path)?>/sales/print/"+ id;
        var win = window.open(urlNew, '_blank');
        win.focus();
        win.print();
    }
</script>