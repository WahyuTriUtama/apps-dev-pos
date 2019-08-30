<!-- modal -->
<div class="modal fade in" id="modal_close_kasir">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span></button>
        <h4 class="modal-title">Closing Kasir</h4>
      </div>
      <form action="#" class="form" id="form_close_kasir">
        <div class="modal-body">
          <div class="form-group">
            <label for="">Open Kasir</label>
            <input type="text" value="" class="form-control" id="open_modal" placeholder="" required="" readonly="">
          </div>

          <div class="form-group">
            <label for="">Total Penjualan</label>
            <input type="text" value="0" class="form-control" id="total_sales" placeholder="" required="" readonly="">
          </div>

          <div class="form-group">
            <label for="">Total Setoran</label>
            <input type="text" value="0" class="form-control" id="total_setor" placeholder="" required="" readonly="">
          </div>

          <div class="form-group">
            <label for="">Input Jumlah Setoran</label>
            <input type="number" value="" class="form-control" id="jml_setor" placeholder="" required="">
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left btn-flat" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-save"></i> Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /modal -->


<script>
  $(function() {
    $('#closing').click(function(e) {
      var id_drawer = $('#id_drawer').val();
      $.ajax({
        url: '<?= base_url($controller_id);?>/check_closing',
        type: 'POST',
        dataType: 'json',
        data: {id_drawer: id_drawer},
      })
      .done(function(data) {
        var total_sales = data.total_sales;
        $('#total_sales').val(total_sales);
        total_sales = total_sales.replace(/,/g,'');
        total_sales = parseFloat(total_sales);
        var open_modal = $('#open_modal').val();
        open_modal = open_modal.replace(/,/g,'');
        open_modal = parseFloat(open_modal);
        var total_setor = total_sales + open_modal;
        $('#total_setor').val(total_setor);
        $('#modal_close_kasir').modal('show');
      })
      .fail(function() {
        alert("error");
      });
    })

    $('#form_close_kasir').submit(function(e) {
      var sales = $('#total_sales').val();
      var total = $('#total_setor').val();
      var amount = $('#jml_setor').val();
      total = parseFloat(total);
      amount = parseFloat(amount);
      sales = parseFloat(sales);
      if (total < 0 && amount < 0) {
        alert('Harus lebih besar 0');
      } else if (amount < total) {
        alert('Jumlah setor kurang');
      } else {
        $.ajax({
          url: '<?= base_url($cls_path);?>/cash_drawer/close_kasir',
          type: 'POST',
          dataType: 'json',
          data: {amount: amount, total: sales},
        })
        .done(function(data) {
          if (data.msg[0]) {
            $('#modal_close_kasir').modal('hide');
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
    //
  });
</script>