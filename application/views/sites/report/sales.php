<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">DATA PENJUALAN
    </h3>
  </div>
  <div class="box-body">
  	<div class="pull-left">
  		<button type="button" id="print" class="btn btn-flat btn-default"><i class="fa fa-print"></i> Print</button>
  	</div>
  	<div class="pull-right">
  		<form action="<?= current_url();?>" class="form-inline" method="get"> 
			<div class="form-group">
				<input type="date" name="start" value="<?= date('Y-m-d'); ?>" class="form-control input-md"/>
			</div>
			&nbsp;
			<div class="form-group">
				<input type="date" name="end" value="<?= date('Y-m-d'); ?>" class="form-control input-md"/>
			</div>
			&nbsp;
			<div class="form-group">
				<button type="submit" class="btn btn-info btn-flat btn-md"><i class="fa fa-search"></i></button>
			</div>
		</form>
  	</div>
  	<div class="col-md-12">
  		<h4 class="pull-right">TOTAL : <?= format_currency($total); ?></h4>
  	</div>
    <div id="dataview">
		<table id="mytable" class="table table-striped table-bordered dt-responsive nowrap display">
		  <thead>
		    <tr>
		      <th width="5%">No</th>
		      <th>Kode</th>
		      <th>Tanggal</th>
		      <th>Pelanggan</th>
		      <th>Kasir</th>
		      <th>Total Amount</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php 
		  		$no=0; 
		  		foreach ($model->result() as $row) { 
		  			$cModel = $this->Customer_model->find_where(['id' => $row->customer_id])->row();
		  	?>
		  		<tr>
		  			<td><?= ++$no; ?></td>
		  			<td><?= $row->code; ?></td>
		  			<td><?= $row->document_date; ?></td>
		  			<td><?= ucfirst($cModel->name).' - '.$cModel->contact; ?></td>
		  			<td><?= $this->User_model->find_where(['id' => $row->user_id])->row()->name; ?></td>
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
			'searching'   : false,
			'ordering'    : false,
			'info'        : true,
			'autoWidth'   : true,
			'iDisplayLength': <?= $page_limit;?>
	    });

	    $('#print').click(function(){
	        var urlNew = "<?= base_url($controller_id)?>/sales/1?start=<?= $start;?>&end=<?= $end; ?>";
	        var win = window.open(urlNew, '_blank');
	        win.focus();
	        win.print();
	    });
	});
</script>