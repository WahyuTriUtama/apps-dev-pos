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
		      <th width="10%">#</th>
		      <th>Username</th>
		      <th>Nama</th>
		      <th>Grup</th>
		      <th>Status</th>
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
		  			<td><?= $row->username; ?></td>
		  			<td><?= ucfirst($row->name); ?></td>
		  			<td><?= ucfirst($row->group); ?></td>
		  			<td><?= $row->is_active ? "<span class='label bg-green'>Active</span>" : "<span class='label bg-gray'>Non Active</span>"; ?></td>
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