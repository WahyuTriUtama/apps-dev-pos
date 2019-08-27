<?php 
 $status = [
    '1' => 'Active',
    '0' => 'Non Active'
  ];
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
          <label for="name" class="col-sm-2 control-label">Nama</label>
          <div class="col-sm-6">
            <input type="text" name="name" value="<?= set_value('name', isset($model->name) && $model->name ? $model->name : '');?>" class="form-control" id="name" placeholder="">
            <?= form_error('name');?>
          </div>
        </div>

        <div class="form-group">
          <label for="code" class="col-sm-2 control-label">Kontak</label>
          <div class="col-sm-6">
            <input type="text" name="contact" value="<?= set_value('contact', isset($model->contact) && $model->contact ? $model->contact : '');?>" class="form-control" id="contact" placeholder="">
            <?= form_error('contact');?>
          </div>
        </div>

        <div class="form-group">
          <label for="code" class="col-sm-2 control-label">Alamat</label>
          <div class="col-sm-10">
            <input type="text" name="address" value="<?= set_value('address', isset($model->address) && $model->address ? $model->address : '');?>" class="form-control" id="address" placeholder="">
            <?= form_error('address');?>
          </div>
        </div>

        <div class="form-group">
          <label for="group" class="col-sm-2 control-label">Status</label>
          <div class="col-sm-6">
            <?= form_dropdown('is_active', $status, isset($model->is_active) ? $model->is_active: '', ['class' => 'form-control select2']); ?>
            <?= form_error('is_active');?>
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