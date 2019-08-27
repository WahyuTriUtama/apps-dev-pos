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
  	<?= form_open(current_url(), array('id'=>'form', 'class'=>'form-horizontal'));?>
      <div class="box-body">
        <div class="form-group">
          <label for="code" class="col-sm-2 control-label">Kode</label>
          <div class="col-sm-6">
            <input type="text" name="code" value="<?= set_value('code', isset($model->code) && $model->code ? $model->code : '');?>" class="form-control" id="code" placeholder="">
            <?= form_error('code');?>
          </div>
        </div>

        <div class="form-group">
          <label for="description" class="col-sm-2 control-label">Deskripsi</label>
          <div class="col-sm-6">
            <input type="text" name="description" value="<?= set_value('description', isset($model->description) && $model->description ? $model->description : '');?>" class="form-control" id="description" placeholder="">
            <?= form_error('description');?>
          </div>
        </div>

      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <button type="submit" class="btn btn-success pull-right btn-flat"><i class="fa fa-save"></i> Simpan</button>
      </div>
      <!-- /.box-footer -->
    <?= form_close();?>
  </div>
</div>