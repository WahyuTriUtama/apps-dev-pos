<?php
	$cust = array();
	$custModel = $this->Customer_model->all();
	foreach ($custModel->result() as $row) {
		$cust[$row->id] = ucfirst($row->name).' ['.$row->contact.']';
	}
?>

<div class="row">
	<div class="col-md-5">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title">Barang</h3>
				<div class="box-tools pull-right">
				</div>
			</div>
			<div class="box-body">
				<div class="form-group">
		            <input type="text" name="search_scan" value="" class="form-control" id="search_scan" placeholder="Scan Barang" autofocus="">
		        </div>
		        <hr>
				<table id="mytable_item" class="table table-striped table-bordered dt-responsive nowrap display">
					<thead>
						<tr>
							<th>Barang</th>
							<th>Nama Barang</th>
							<th>Harga</th>
							<th>Stok</th>
							<th>#</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
	<div class="col-md-7">
		<div class="box box-success">
			<div class="box-header with-border">
				<h3 class="box-title">Keranjang</h3>
				<div class="box-tools pull-right">
					<?= form_dropdown('customer_id', $cust, '', ['class' => 'select2', 'id' => 'customer_id']); ?>
			        <button type="button" class="btn btn-flat" id="cust_btn"><i class="fa fa-user-plus"></i></button>
				</div>
			</div>
			<div class="box-body">
				<div style="min-height: 400px;">
					<table id="mytable_cart" class="table table-striped table-bordered dt-responsive nowrap display">
						<thead>
							<tr>
								<th>Barang</th>
								<th>Nama Barang</th>
								<th>Harga</th>
								<th>Jumlah</th>
								<th>Total Amount</th>
								<th>#</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			
			<div class="box-footer">
				<form class="form-horizontal">
					<div class="form-group">
						<label for="name" class="col-sm-7 control-label">Total</label>
						<div class="col-sm-5">
							<input type="text" name="sub_total" value="" class="form-control" id="sub_total" placeholder="0.00" readonly="" />
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="col-sm-7 control-label">Bayar</label>
						<div class="col-sm-5">
							<input type="text" name="payment" value="" class="form-control" id="payment"/>
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="col-sm-7 control-label">Kembalian</label>
						<div class="col-sm-5">
							<input type="text" name="change" value="" class="form-control" id="change" placeholder="0.00" readonly="" />
						</div>
					</div>
				</form>
				<hr>
				<div class="">
					<button type="button" onclick="del_all_cart()" class="btn btn-flat btn-danger"><i class="fa fa-trash"></i> Hapus Semua</button>&nbsp;
					<button type="button" class="btn btn-warning btn-flat" id="closing"><i class="fa fa-money"></i> Closing</button>
					<button type="button" id="save_trans" class="btn btn-flat pull-right btn-success"><i class="fa fa-save"></i> Simpan</button>
				</div>

			</div>
		</div>
	</div>
</div>

<?php $this->load->view($controller_id.'/customer_modal');?>
<?php $this->load->view($controller_id.'/cash_open_modal');?>
<?php $this->load->view($controller_id.'/cash_close_modal');?>

<script>
	var table;
	var table2;

	$(function() {
		table = $('#mytable_item').DataTable({
			"sScrollY": "400px",
			"bScrollCollapse": true,
			"processing"  : true,
			"paging"      : false,
			"lengthChange": false,
			"searching"   : true,
			"ordering"    : false,
			"info"        : false,
			"autoWidth"   : true,
			"iDisplayLength": <?= $page_limit;?>,
			"bServerSide": true,
			"bDestroy": true,
			"ajax": {
				"url": "<?= base_url().$controller_id;?>/list_item",
				"type": "GET"
			},
			"bDeferRender": true,
			"columns": [
				{"data": "code"},
				{"data": "name"},
				{"data": "price"},
				{"data": "stock"},
				{"data": "code"},
			],
			"aoColumnDefs": [
		        {
		          "targets": [4],
		          "orderable": false,
		          "className": "text-center",
		          "render": function(data, type, row) {
		            var $html = '<a href="javascript:void(0)" row="'+row['code']+'" onclick="add_cart(this)" title="Add to cart" class="btn btn-flat btn-success btn-xs"><i class="fa fa-cart-plus"></i></a>';

		            return $html;
		          }
		        },
	        ]
	    });

		table2 = $('#mytable_cart').DataTable({
			"processing"  : true,
			"paging"      : false,
			"lengthChange": false,
			"searching"   : false,
			"ordering"    : false,
			"info"        : false,
			"autoWidth"   : true,
			"iDisplayLength": <?= $page_limit;?>,
			"bServerSide": true,
			"ajax": {
				"url": "<?= base_url().$controller_id;?>/list_cart",
				"type": "GET"
			},
			//"bDeferRender": true,
			"columns": [
				{"data": "code"},
				{"data": "name"},
				{"data": "price"},
				{"data": "qty"},
				{"data": "subtotal"},
				{"data": "rowid"},
			],
			"aoColumnDefs": [
				{
					"targets": [2,4],
					"orderable": false,
					"className": "text-right"
				},
		        {
		          "targets": [5],
		          "orderable": false,
		          "className": "text-center",
		          "render": function(data, type, row) {
		            var $html = "<a href='javascript:void(0)' row='"+row['rowid']+"' onclick='del_cart(this)' title='Remove cart' class='btn btn-flat btn-danger btn-xs'><i class='fa fa-trash'></i></a>";

		            return $html;
		          }
		        },
	        ]
	    });

	    cart_total();

	    $('#payment').keyup(function(e) {
	    	var total = $('#sub_total').val();
	    	var payment = $(this).val();
	    	var change = 0.00;
	    	total = total.replace(/,/g,'');
	    	total = parseFloat(total);
	    	payment = parseFloat(payment);
	    	if (payment > total) {
	    		change = payment - total; 
	    	}
	    	$('#change').val(change);
	    });

	    $('#search_scan').keypress(function(e) {
	    	var code = $(this).val();
	    	api_cart(code);
	    });

	    $('#payment').keypress(function(e) {
			var keycode = (e.keyCode ? e.keyCode : e.which);
			if(keycode == '13'){
				$('#save_trans').click();	
			}
	    });

	    $('#save_trans').click(function(e) {
	    	var customer_id = $('#customer_id').val();
	    	var drawer_id = $('#id_drawer').val();
	    	var sub_total = $('#sub_total').val();
	    	var payment = $('#payment').val();

	    	sub_total = sub_total.replace(/,/g,'');
	    	sub_total = parseFloat(sub_total);
	    	payment = parseFloat(payment);

	    	if (payment < sub_total) {
	    		alert('Jumlah bayar kurang');
	    	} else {
	    		$.ajax({
		    		url: '<?= base_url($controller_id);?>/save_trans',
		    		type: 'POST',
		    		dataType: 'json',
		    		data: {customer_id: customer_id, drawer_id: drawer_id},
		    	})
		    	.done(function(data) {
		    		if (data.msg[0]) {
		    			print(data.msg[2]);
		    			window.location.reload();
		    		} else {
		    			alert(data.msg[1]);
		    		}
		    	})
		    	.fail(function() {
		    		alert("error");
		    	});
	    	}
	    });
	});

	function add_cart(e) {
		var code = $(e).attr('row');
		api_cart(code);
	}

	function api_cart(code) {
		let url = "<?= base_url($controller_id);?>/add_cart";
		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			data: {code: code},
		})
		.done(function(data) {
			if (data.msg[0]) {
				cartReload();
			} else {
				alert(data.msg[1]);
			}
		})
		.fail(function() {
			console.log("error");
		});
	}

	function del_cart(e) {
		var rowid = $(e).attr('row');
		let url = "<?= base_url($controller_id);?>/remove_cart";
		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			data: {rowid: rowid},
		})
		.done(function() {
			cartReload();
		})
		.fail(function() {
			console.log("error");
		});
	}

	function del_all_cart() {
		let url = "<?= base_url($controller_id);?>/remove_all_cart";
		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json'
		})
		.done(function() {
			cartReload();
		})
		.fail(function() {
			console.log("error");
		});
	}

	function cart_total() {
		let url = "<?= base_url($controller_id);?>/total_cart";
		$.ajax({
			url: url,
			type: 'GET',
			dataType: 'json'
		})
		.done(function(data) {
			$('#sub_total').val(data.total);
		})
		.fail(function() {
			console.log("error");
		});
	}

	function cartReload() {
		cart_total();
        table2.ajax.reload(null, false);
        table.ajax.reload(null, false);
    }

    function print(id) {
        var urlNew = "<?= base_url($controller_id)?>/print/"+ id;
        var win = window.open(urlNew, '_blank');
        win.focus();
        win.print();
    }
</script>