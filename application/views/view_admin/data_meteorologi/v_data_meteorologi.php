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
<br>
<!-- alert  -->
<?php
  if($this->session->flashdata('info')){
      if( $this->session->flashdata('info')['from'] ){
          echo"
          <div class=' alert alert-success alert-dismissible'>
          <h4><i class='icon fa fa-globe'></i> Information!</h4>".
          $this->session->flashdata('info')["message"].
          "</div>
          ";
      }else{
          echo"
          <div class='alert alert-danger alert-dismissible'>
          <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
          <h4><i class='icon fa fa-ban'></i> Alert!</h4>".
          $this->session->flashdata('info')["message"].
          "</div>
          ";
      }
    }
  ?>
<!-- alert  -->
<!-- Main content -->
  <section class="content">
    <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?php echo $page_name ?></h3>
          <br>
          <br>
          <!-- Button trigger modal -->
          <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#InputDataModal">
            Input Data
          </button> -->
          <a href="<?php echo site_url('admin/data_meteorologi/input_data');?>" class="btn-sm btn-primary">Input Data</a>
          <a href="<?php echo site_url('admin/data_meteorologi/import_data');?>" class="btn-sm btn-info">Import Data</a>
          <a href="<?php echo site_url('admin/data_meteorologi/deleteAll');?>" class="pull-right btn-sm btn-danger">Kosongkan Data</a>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
              <table id="tableDocument" class="table table-striped table-bordered table-hover">
                <thead class="thin-border-bottom">
                  <tr >
                    <th style="width:30px; text-align: center;">No</th>
                    <th style="width:100px; text-align: center;">Tanggal</th>
                    <th>Temperatur (°C)</th>
                    <th>Kelembapan (%)</th>
                    <th>Lama Penyinaran Matahari (%)</th>
                    <th>Kecepatan Angin (knot)</th>
                    <th>Curah Hujan (mm)</th>
                    <th colspan="2" style="text-align: center;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                      $no=1;
                      foreach( $data_meteorologi as $file ):
                    ?>
                      <tr>
                        <td>
                            <?php echo $no?>
                        </td>
                        <td>
                            <?php echo $file->data_tanggal  ?>
                        </td>
                        <td>
                            <?php echo $file->data_temperatur ?>
                        </td>
                        <td>
                            <?php echo $file->data_kelembapan ?>
                        </td>
                        <td>
                            <?php echo $file->data_lama_penyinaran_matahari ?>
                        </td>
                        <td>
                            <?php echo $file->data_kecepatan_angin ?>
                        </td>
                        <td>
                            <?php echo $file->data_curah_hujan ?>
                        </td>
                        <td>
                            <a href="<?php echo site_url('admin/data_meteorologi/update_data/').$file->data_id;?>" class="btn-sm btn-primary" >Edit</a>
                        </td>
                        <td>
                          <a href="<?php echo site_url('admin/data_meteorologi/delete_data/').$file->data_id;?>" class="btn-sm btn-danger">Hapus</a>
                        </td>
                        
                      </tr>
                    <?php 
                      $no++;
                    endforeach;?>
                </tbody>
              </table>
          </div>   
      </div>
    </div>

   <!--  <div class="box">
        <div class="box-header">
          <h3 class="box-title">Normalisasi Data</h3>
          <br>
          <br>
          <a href="<?php echo site_url('admin/data_testing/normalize');?>" class="btn-sm btn-primary">Normalisasi Data</a>
          
        </div> -->
        <!-- /.box-header -->
        <!-- <div class="box-body">
          <div class="table-responsive">
              <table id="tableDocument" class="table table-striped table-bordered table-hover">
                <thead class="thin-border-bottom">
                  <tr >
                    <th style="width:50px">No</th>
                    <th>Nama</th>
                    <th>IPK </th>
                    <th>Semester</th>
                    <th>Gaji Orang Tua</th>
                    <th>Tanggungan Orang Tua</th>
                    <th>UKT</th>
                    <th>Label</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                      $no=1;
                      foreach( $files_normalized as $file ):
                    ?>
                      <tr>
                        <td>
                            <?php echo $no?>
                        </td>
                        <td>
                            <?php echo $file->data_name  ?>
                        </td>
                        <td>
                            <?php echo $file->data_IPK ?>
                        </td>
                        <td>
                            <?php echo $file->data_semester ?>
                        </td>
                        <td>
                            <?php echo $file->data_gaji_ortu ?>
                        </td>
                        <td>
                            <?php echo $file->data_tanggungan ?>
                        </td>
                        <td>
                            <?php echo $file->data_UKT ?>
                        </td>
                        <td>
                            <?php echo  ( $file->data_label == 1 )? "LULUS" : ( ( $file->data_label == 0 )? "TIDAK LULUS" : "BELUM DI UJI"   )  ?>
                        </td>
                      </tr>
                    <?php 
                      $no++;
                    endforeach;?>
                </tbody>
              </table>
          </div>   
      </div> -->
    <!-- </div> -->
  </section>
</div>