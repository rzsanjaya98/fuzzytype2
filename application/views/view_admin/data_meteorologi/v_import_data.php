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

<!-- Main content -->
  <section class="content">
    <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?php echo $page_name ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <?php echo form_open_multipart();?>
            <div class="row">
                <div class="col-xs-4">     
                    <div class="form-group">
                      <label for="exampleInputFile">File Excel</label>
                      <input type="file" id="exampleInputFile"  name="document_file"/>
                      <span class="help-block">masukkan file excel</span>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary ">
                        <i class="ace-icon fa fa-paper-plane"></i>
                        <span class="bigger-110">Import</span>
                    </button>
                </div>
            </div>
                <?php echo form_close()?>
            </div>
      </div>
    </div>
  </section>
</div>