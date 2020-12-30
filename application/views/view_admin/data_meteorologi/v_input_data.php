<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo $page_name ?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Admin</a></li>
    <li class="active">Data Meteorologi</li>
  </ol>
</section>

<section class="content">
	<div class="box">
		<div class="box-header">
          <h3 class="box-title"><?php echo $page_name ?></h3>
      	</div>
		<div class="box-body">
			<?php echo form_open("admin/data_meteorologi/input_data");?>
			<form action="" method="post">
              <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="data_tanggal" class="form-control" placeholder="" value="<?php echo set_value('data_tanggal'); ?>">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <span style="color:red"><?php echo form_error('data_tanggal'); ?></span>
              </div>
              <div class="form-group">
                <label>Temperatur Udara (°C)</label>
                <input type="number" min="24.3" max="30.5" step="0.1" name="data_temperatur" class="form-control" placeholder="Temperatur Udara (°C)" value="<?php echo set_value('data_temperatur'); ?>">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <span style="color:red"><?php echo form_error('data_temperatur'); ?></span>
              </div>
              <div class="form-group">
                <label>Kelembapan (%)</label>
                <input type="number" min="59" max="98" step="1" name="data_kelembapan" class="form-control" placeholder="Kelembapan (%)" value="<?php echo set_value('data_kelembapan'); ?>">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <span style="color:red"><?php echo form_error('data_kelembapan'); ?></span>
              </div>
              <div class="form-group">
                <label>Lama Penyinaran Matahari (Jam)</label>
                <input type="number" min="0" max="12" step="0.1" name="data_lama_penyinaran_matahari" class="form-control" placeholder="Lama Penyinaran Matahari (Jam)" value="<?php echo set_value('data_lama_penyinaran_matahari'); ?>">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <span style="color:red"><?php echo form_error('data_lama_penyinaran_matahari'); ?></span>
              </div>
              <div class="form-group">
                <label>Kecepatan Angin (knot)</label>
                <input type="number" min="0" max="12" step="0.1" name="data_kecepatan_angin" class="form-control" placeholder="Kecepatan Angin (knot)" value="<?php echo set_value('data_kecepatan_angin'); ?>">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <span style="color:red"><?php echo form_error('data_kecepatan_angin'); ?></span>
              </div>
              <div class="form-group">
                <label>Curah Hujan (mm)</label>
                <input type="number" min="0.1" max="89.2" step="0.1" name="data_curah_hujan" class="form-control" placeholder="Curah Hujan (mm)" value="<?php echo set_value('data_curah_hujan'); ?>">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <span style="color:red"><?php echo form_error('data_curah_hujan'); ?></span>
              </div>

            	<button type="submit" class="pull-right btn btn-sm btn-primary ">
                <i class="ace-icon fa fa-paper-plane"></i>
                <span class="bigger-110">Submit</span>
            	</button>  
        			
            </form>
		</div>
	</div>
	
</section>

</div>