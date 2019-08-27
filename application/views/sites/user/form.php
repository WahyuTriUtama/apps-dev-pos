<?php
	$group = [
		'admin' => 'Admin',
		'purchase' => 'Purchase',
		'sales' => 'Sales',
		'inventory' => 'Inventory',
	];

	$status = [
		'1' => 'Active',
		'0'	=> 'Non Active'
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
          <label for="name" class="col-sm-2 control-label">Nama</label>
          <div class="col-sm-6">
            <input type="text" name="name" value="<?= set_value('name', isset($model->name) && $model->name ? $model->name : '');?>" class="form-control" id="name" placeholder="">
            <?= form_error('name');?>
          </div>
        </div>

        <div class="form-group">
          <label for="group" class="col-sm-2 control-label">Grup</label>
          <div class="col-sm-6">
          	<?= form_dropdown('group', $group, isset($model->group) && $model->group ? $model->group: 'admin', ['class' => 'form-control select2']); ?>
            <?= form_error('group');?>
          </div>
        </div>

        <div class="form-group">
          <label for="group" class="col-sm-2 control-label">Status</label>
          <div class="col-sm-6">
          	<?= form_dropdown('is_active', $status, isset($model->is_active) ? $model->is_active: '', ['class' => 'form-control select2']); ?>
            <?= form_error('is_active');?>
          </div>
        </div>

        <div class="form-group"></div>

        <div class="form-group">
          <label for="username" class="col-sm-2 control-label">Username</label>
          <div class="col-sm-6">
            <input type="text" name="username" value="<?= set_value('username', isset($model->username) && $model->username ? $model->username : '');?>" class="form-control" id="username" placeholder="" <?= isset($model->username) && $model->username ? 'readonly':'';?>>
            <?= form_error('username');?>
          </div>
        </div>

        <div class="form-group">
          <label for="password" class="col-sm-2 control-label">Password</label>
          <div class="col-sm-6">
            <input type="password" name="password" class="form-control" id="password" placeholder="">
            <?= form_error('password');?>
          </div>
        </div>

        <div class="form-group">
          <label for="password" class="col-sm-2 control-label">Confirm Password</label>
          <div class="col-sm-6">
            <input type="password" name="cpassword" class="form-control" id="cpassword" placeholder="">
            <?= form_error('cpassword');?>
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