<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">DATA 
    	&nbsp; &nbsp;
    	<a href="<?= base_url($controller_id)?>/create" class="btn btn-primary btn-flat btn-xs" title="Tambah Data"><i class="fa fa-plus"></i>&nbsp; Tambah</a>
    </h3>
  </div>
  <div class="box-body">
    <div id="dataview">
		<table id="mytable" class="table table-striped table-bordered dt-responsive nowrap display">
		  <thead>
		    <tr>
		      <th width="5%">No</th>
		      <th width="10%" class="text-center">#</th>
		      <th>Kode</th>
		      <th>Nama</th>
		      <th>Kategori</th>
		      <th>Satuan</th>
		      <th>Stok</th>
		      <th>Harga</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php 
		  	$no = 0;
		  	foreach ($model->result() as $row) { ?>
		  		<tr>
		  			<td><?= ++$no; ?></td>
		  			<td class="text-center">
		  				<a href='<?= base_url().$controller_id;?>/update/<?= $row->id; ?>' title='Edit' class='btn btn-flat btn-warning btn-xs'><i class='fa fa-edit'></i></a>
                    	<a href='<?= base_url().$controller_id;?>/delete/<?= $row->id; ?>' onclick='return confirm("Are you sure ?")' class='btn btn-flat btn-danger btn-xs' title='Delete'><i class='fa fa-trash-o'></i></a>
		  			</td>
		  			<td><?= $row->code; ?></td>
		  			<td><?= $row->name; ?></td>
		  			<td><?= $row->category; ?></td>
		  			<td><?= $row->uom_code; ?></td>
		  			<td class="text-right">
		  			<?php 

		  				$invModel =$this->Inventory_model->count_qty(['item_id' => $row->id]);
		  				echo ($invModel->num_rows()) ? $invModel->row()->remaining_qty : '0'; ?>
		  			</td>
		  			<td class="text-right"><?= format_currency($row->price); ?></td>
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