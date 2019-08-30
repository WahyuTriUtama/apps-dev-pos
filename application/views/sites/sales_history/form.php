<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title">Form 
			<?= ucfirst($method_name); ?>
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
	                 	<label for="">Nama Pelanggan</label>
	                 	<input type="text" value="<?= $model->customer_name ?>" class="form-control" id="date" placeholder="" readonly="">
	                </div>
	                <div class="form-group">
	                  <label for="">Kontak Pelanggan</label>
	                  <input type="text" value="<?= $model->contact; ?>" class="form-control" id="date" placeholder="" readonly="">
	                </div>
			  	</div>

			  	<div class="col-md-4">
			  		<div class="form-group">
	                  <label for="">Kasir</label>
	                  <input type="text" value="<?= $model->kasir;?>" class="form-control" id="code" placeholder="Open" readonly="">
	                </div>
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
								<th>Kode</th>
								<th>Deskripsi</th>
								<th>Satuan</th>
								<th>Jumlah</th>
								<th>Harga</th>
								<th>Sub Total</th>
						    </tr>
						  </thead>
						  <tbody>
						  	 <?php foreach ($detailModel->result() as $row) { ?>
						  		<tr>
						  			<td><?= $row->item_code;?></td>
						  			<td><?= $row->item_name;?></td>
						  			<td><?= $row->uom; ?></td>
						  			<td class="text-right"><?= $row->qty;?></td>
						  			<td class="text-right"><?= $row->price;?></td>
						  			<td class="text-right"><?= $row->total_price;?></td>
						  		</tr>
						  	<?php } ?>
						  </tbody>
					</table>
				</div>
			</div>
		</div>

	</div>
</div>