<?php
	$vendor = array('' => '-- Vendor --');
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
	                 	<label for="">Vendor</label>
	                 	<?= form_dropdown('vendor_id', $vendor, isset($model->vendor_id) && $model->vendor_id ? $model->vendor_id: '', ['class' => 'form-control select2', 'id' => 'vendor']); ?>
	        			<?= form_error('vendor_id');?>
	                </div>
	                <div class="form-group">
	                  <label for="">Nama Vendor</label>
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
						  <tfoot>
						  	<tr>
						  		<td colspan="5">
						  			<button type="button" id="add_item" class="btn btn-xs btn-success btn-flat">
						  				<i class="fa fa-plus"></i> Tambah Barang
						  			</button>
						  		</td>
						  	</tr>
						  </tfoot>
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
          <input type="text" value="<?= set_value('item_name', isset($model->item_name) && $model->item_name ? $model->item_name : '');?>" class="form-control" id="date" placeholder="">
        </div>

        <div class="form-group">
          <label for="">Harga</label>
          <input type="text" value="<?= set_value('price', isset($model->price) && $model->price ? $model->price : '');?>" class="form-control" id="date" placeholder="">
        </div>

        <div class="form-group">
          <label for="">Jumlah</label>
          <input type="number" value="<?= set_value('qty', isset($model->qty) && $model->qty ? $model->qty : '');?>" class="form-control" id="date" placeholder="">
        </div>

        <div class="form-group">
          <label for="">Total</label>
          <input type="text" value="<?= set_value('total_price', isset($model->total_price) && $model->total_price ? format_currency($model->total_price) : '');?>" class="form-control" id="date" placeholder="Rp. 0.00" readonly="">
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
	    	$('.header_form').submit();
	    });

	    $('#add_item').click(function(e) {
	    	$('#modal_item').modal('show');
	    });
	});
</script>