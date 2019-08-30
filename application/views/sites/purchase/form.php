<?php
	$vendor = array('' => '-- Suplier --');
	$vendorModel = $this->Vendor_model->find_where(['is_active' => 1]);
	foreach ($vendorModel->result() as $row) {
		$vendor[$row->id] = $row->code;
	}

	$item = array('' => '-- Barang --');
	$itemModel = $this->Item_model->all();
	foreach ($itemModel->result() as $row) {
		$item[$row->id] = $row->code;
	}
?>

<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title">Form 
			<?= $method_name == 'create' ? "Add" : "Edit"; ?>
		</h3>
		<div class="box-tools pull-right">
			<a href="<?= base_url($controller_id);?>" class="btn btn-danger btn-xs btn-flat" title="Back"><i class="fa fa-long-arrow-left"></i> Kembali</a>
		</div>
	</div>
	<div class="box-body">
  		<?= form_open(current_url(), array('id'=>'form', 'class'=>'header_form'));?>
			<div class="row">
			  	<div class="col-md-4">
			  		<div class="form-group">
	                  <label for="">Kode</label>
	                  <input type="text" value="<?= set_value('code', isset($model->code) && $model->code ? $model->code : '');?>" class="form-control" id="code" placeholder="" readonly="">
	                </div>
	                <div class="form-group">
	                  <label for="">Tanggal</label>
	                  <input type="text" value="<?= set_value('document_date', isset($model->document_date) && $model->document_date ? $model->document_date : '');?>" class="form-control" id="date" placeholder="<?= date('Y-m-d'); ?>" readonly="">
	                </div>
			  	</div>

			  	<div class="col-md-4">
			  		<div class="form-group">
	                 	<label for="">Suplier</label>
	                 	<?= form_dropdown('vendor_id', $vendor, isset($model->vendor_id) && $model->vendor_id ? $model->vendor_id: '', ['class' => 'form-control select2', 'id' => 'vendor']); ?>
	        			<?= form_error('vendor_id');?>
	                </div>
	                <div class="form-group">
	                  <label for="">Nama Suplier</label>
	                  <input type="text" value="<?= set_value('vendor_name', isset($model->vendor_name) && $model->vendor_name ? $model->vendor_name : '');?>" class="form-control" id="date" placeholder="" readonly="">
	                </div>
			  	</div>

			  	<div class="col-md-4">
			  		<div class="form-group">
	                  <label for="">Status</label>
	                  <input type="text" value="<?= set_value('status', isset($model->status) && $model->status ? $model->status : '');?>" class="form-control" id="code" placeholder="Open" readonly="">
	                </div>
	                <div class="form-group">
	                  <label for="">Total Amount</label>
	                  <input type="text" value="<?= set_value('total_amount', isset($model->total_amount) && $model->total_amount ? format_currency($model->total_amount) : '');?>" class="form-control" id="date" placeholder="Rp. 0.00" readonly="">
	                </div>
			  	</div>

			</div>
		<?= form_close();?>
		<div class="form-group"></div>

		<div class="row">
			<div class="col-md-12">
				<div id="dataview">
					<caption><strong>Barang</strong></caption>
					<table id="mytable" class="table table-striped table-bordered dt-responsive nowrap display">
						<thead>
						    <tr>
								<th width="10%">#</th>
								<th>Kode Barang</th>
								<th>Nama Barang</th>
								<th>Jumlah</th>
								<th>Harga</th>
								<th>Total Harga</th>
						    </tr>
						  </thead>
						<?php if (isset($model->id) && $model->id) { ?>
						  <tbody>
						  	 <?php foreach ($detailModel->result() as $row) { ?>
						  		<tr>
						  			<td class="text-center">
						  				<?php if ($model->status == 'open') { ?>
						  					<a href='<?= base_url().$controller_id;?>/item_delete/<?= $row->id; ?>' onclick='return confirm("Are you sure ?")' class='btn btn-flat btn-danger btn-xs' title='Delete'><i class='fa fa-trash-o'></i></a>
						  				<?php } ?>
						  			</td>
						  			<td><?= $row->item_code;?></td>
						  			<td><?= $row->item_name;?></td>
						  			<td><?= $row->qty;?></td>
						  			<td><?= $row->price;?></td>
						  			<td><?= $row->total_price;?></td>
						  		</tr>
						  	<?php } ?>
						  </tbody>
						  <tfoot>
						  	<tr>
						  		<td colspan="6">
						  			<?php if ($model->status == 'open') { ?>
							  			<button type="button" id="add_item" class="btn btn-sm btn-success btn-flat">
							  				<i class="fa fa-plus"></i> Tambah Barang
							  			</button>&nbsp;
						  			<?php } ?>
						  			<?php if ($model->total_amount > 0 && $model->status == 'open') { ?>
							  			<button type="button" id="posting" class="btn btn-sm btn-primary btn-flat">
							  				<i class="fa fa-save"></i> Post
							  			</button>
						  			<?php }?>
						  		</td>
						  	</tr>
						  </tfoot>
						<?php } ?>
					</table>
				</div>
			</div>
		</div>

	</div>
</div>

<!-- modal -->
<div class="modal fade in" id="modal_item">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Barang</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="">Barang</label>
          <?= form_dropdown('item_id', $item, isset($model->item_id) && $model->item_id ? $model->item_id: '', ['class' => 'form-control select2', 'id' => 'item', 'style' => 'width:100%']); ?>
        </div>

        <div class="form-group">
          <label for="">Nama Barang</label>
          <input type="text" value="" class="form-control" id="item_name" placeholder="" readonly="">
        </div>

        <div class="form-group">
          <label for="">Harga</label>
          <input type="text" value="" class="form-control" id="item_price" placeholder="">
        </div>

        <div class="form-group">
          <label for="">Jumlah</label>
          <input type="number" value="" class="form-control" id="item_qty" placeholder="">
        </div>

        <div class="form-group">
          <label for="">Total</label>
          <input type="text" value="" class="form-control" id="item_amount" placeholder="Rp. 0.00" readonly="">
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tutup</button>
        <button type="button" id="save_item" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Simpan</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /modal -->


<script>
	$(function() {
		var table;
		table = $('#mytable').DataTable({
			'processing'  : false,
			'paging'      : false,
			'lengthChange': false,
			'searching'   : false,
			'ordering'    : false,
			'info'        : false,
			'autoWidth'   : true,
			'iDisplayLength': 100
	    });

	    $('#vendor').change(function(e) {
	    	var st = "<?= isset($model->status) && $model->status ? $model->status : ''; ?>";

	    	if (st != '' && st != 'open') {
	    		alert('Tidak bisa diubah');
	    		window.location.reload();
	    	} else {
	    		$('.header_form').submit();
	    	}
	    });

	    $('#add_item').click(function(e) {
	    	$('#modal_item').modal('show');
	    	clear_form();
	    });

	    <?php if (isset($model->status) &&  $model->status != 'open') { ?>
	    	$('#vendor').attr('disabled');
	    <?php } ?>

	    $('#item').change(function(e) {
	    	var id = $(this).val();
	    	var po_id = "<?= isset($model->id) && $model->id ? $model->id : '';?>";
	    	$.ajax({
	    		url: '<?= base_url($controller_id); ?>/item/'+ po_id,
	    		type: 'POST',
	    		dataType: 'json',
	    		data: {id: id}
	    	})
	    	.done(function(data) {
	    		if (data.status) {
	    			$('#item_name').val(data.data.name);
	    		} else {
	    			alert(data.eror);
	    		}
	    	})
	    	.fail(function() {
	    		alert("error");
	    	});
	    });

	    $('#item_qty, #item_price').keyup(function(e) {
	    	var price = $('#item_price').val();
	    	var qty = $('#item_qty').val();
	    	var total_amount = 0.00;
	    	price = price.replace(/,/g,'');
	    	price = parseFloat(price);
	    	qty = parseFloat(qty);
	    	if (qty > 0 && price > 0) {
	    		total_amount = qty * price; 
	    	}
	    	$('#item_amount').val(total_amount);
	    });

	    $('#save_item').click(function(e) {
	    	var item_id = $('#item').val();
	    	var price = $('#item_price').val();
	    	var qty = $('#item_qty').val();
	    	var total = $('#item_amount').val();
	    	var po_id = "<?= isset($model->id) && $model->id ? $model->id : '';?>";
	    	if (item_id == '' || price <= 0 || qty <= 0) {
	    		alert('Semua field harus diisi. Harga & jumlah harus lebih besar 0.');
	    	} else {
	    		$.ajax({
	    			url: '<?= base_url($controller_id);?>/add_detail/'+ po_id,
	    			type: 'POST',
	    			dataType: 'json',
	    			data: {item_id: item_id, price: price, qty: qty, total: total},
	    		})
	    		.done(function(data) {
	    			if (data.status) {
	    				$('#modal_item').modal('hide');
	    				clear_form();
	    				window.location.reload();
	    			} else {
	    				alert('Terjadi kesalahan sistem, cek data dan klik simpan.');
	    			}
	    		})
	    		.fail(function() {
	    			alert("error");
	    		});
	    		
	    	}
	    });

	    $('#posting').click(function(e) {
	    	var po_id = "<?= isset($model->id) && $model->id ? $model->id : '';?>";
	    	if (confirm('Apakah anda yakin akan posting?')) {
	    		$.ajax({
	    			url: '<?= base_url($controller_id);?>/posting/'+ po_id,
	    			type: 'POST',
	    			dataType: 'json',
	    		})
	    		.done(function(data) {
	    			if (data.status) {
	    				alert('Pembelian telah terposting.');
	    				window.location.reload();
	    			} else {
	    				alert('Terjadi kesalahan sistem, cek data dan klik simpan.');
	    			}
	    		})
	    		.fail(function() {
	    			alert("error");
	    		});
	    		
	    	}
	    });
	    /*end*/
	});

	function clear_form() {
		$('#item').val('');
		$('#item_price').val('');
		$('#item_qty').val(0);
		$('#item_amount').val(0);
	}
</script>