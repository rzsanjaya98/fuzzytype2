<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?php echo $page_name ?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Admin</a></li>
    <li class="active">Fuzzy</li>
  </ol>
</section>

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

<section class="content">
	<div class="box">
		<div class="box-header">
          <h3 class="box-title">Fuzzifikasi</h3>
          <br><br>
          <a href="<?php echo site_url('admin/fuzzy/fuzzifikasi');?>" class="btn-sm btn-primary">Fuzzifikasi Data</a>
		</div>
    <div class="box-body">
          <div class="table-responsive">
              <table id="tableDocument" class="table table-striped table-bordered table-hover">
                <thead class="thin-border-bottom">
                  <tr >
                    <th style="width:30px; text-align: center;">No</th>
                    <th style="width:100px; text-align: center;">Tanggal</th>
                    <th>TemperaturUsejuk</th>
                    <th>TemperaturLsejuk</th>
                    <th>TemperaturUnormal</th>
                    <th>TemperaturLnormal</th>
                    <th>TemperaturUpanas</th>
                    <th>TemperaturLpanas</th>
                    <th>KelembapanUkering</th>
                    <th>KelembapanLkering</th>
                    <th>KelembapanUlembab</th>
                    <th>KelembapanLlembab</th>
                    <th>KelembapanUbasah</th>
                    <th>KelembapanLbasah</th>
                    <th>LamaPenyinaranMatahariUrendah</th>
                    <th>LamaPenyinaranMatahariLrendah</th>
                    <th>LamaPenyinaranMatahariUsedang</th>
                    <th>LamaPenyinaranMatahariLsedang</th>
                    <th>LamaPenyinaranMatahariUtinggi</th>
                    <th>LamaPenyinaranMatahariLtinggi</th>
                    <th>KecepatanAnginUlambat</th>
                    <th>KecepatanAnginLlambat</th>
                    <th>KecepatanAnginUagakkencang</th>
                    <th>KecepatanAnginLagakkencang</th>
                    <th>KecepatanAnginUkencang</th>
                    <th>KecepatanAnginLkencang</th>
                    <th>TekananUdaraUrendah</th>
                    <th>TekananUdaraLrendah</th>
                    <th>TekananUdaraUsedang</th>
                    <th>TekananUdaraLsedang</th>
                    <th>TekananUdaraUtinggi</th>
                    <th>TekananUdaraLtinggi</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                      $no=1;
                      foreach( $data_fuzzifikasi as $file ):
                    ?>
                      <tr>
                        <td>
                            <?php echo $no?>
                        </td>
                        <td>
                            <?php echo $file->data_tanggal ?>
                        </td>
                        <td>
                            <?php echo $file->data_temperaturUsejuk  ?>
                        </td>
                        <td>
                            <?php echo $file->data_temperaturLsejuk ?>
                        </td>
                        <td>
                            <?php echo $file->data_temperaturUnormal  ?>
                        </td>
                        <td>
                            <?php echo $file->data_temperaturLnormal ?>
                        </td>
                        <td>
                            <?php echo $file->data_temperaturUpanas  ?>
                        </td>
                        <td>
                            <?php echo $file->data_temperaturLpanas ?>
                        </td>
                        <td>
                            <?php echo $file->data_kelembapanUkering ?>
                        </td>
                        <td>
                            <?php echo $file->data_kelembapanLkering ?>
                        </td>
                        <td>
                            <?php echo $file->data_kelembapanUlembab ?>
                        </td>
                        <td>
                            <?php echo $file->data_kelembapanLlembab ?>
                        </td>
                        <td>
                            <?php echo $file->data_kelembapanUbasah ?>
                        </td>
                        <td>
                            <?php echo $file->data_kelembapanLbasah ?>
                        </td>
                        <td>
                            <?php echo $file->data_lama_penyinaran_matahariUrendah ?>
                        </td>
                        <td>
                            <?php echo $file->data_lama_penyinaran_matahariLrendah ?>
                        </td>
                        <td>
                            <?php echo $file->data_lama_penyinaran_matahariUsedang ?>
                        </td>
                        <td>
                            <?php echo $file->data_lama_penyinaran_matahariLsedang ?>
                        </td>
                        <td>
                            <?php echo $file->data_lama_penyinaran_matahariUtinggi ?>
                        </td>
                        <td>
                            <?php echo $file->data_lama_penyinaran_matahariLtinggi ?>
                        </td>
                        <td>
                            <?php echo $file->data_kecepatan_anginUlambat ?>
                        </td>
                        <td>
                            <?php echo $file->data_kecepatan_anginLlambat ?>
                        </td>
                        <td>
                            <?php echo $file->data_kecepatan_anginUagakkencang ?>
                        </td>
                        <td>
                            <?php echo $file->data_kecepatan_anginLagakkencang ?>
                        </td>
                        <td>
                            <?php echo $file->data_kecepatan_anginUkencang ?>
                        </td>
                        <td>
                            <?php echo $file->data_kecepatan_anginLkencang ?>
                        </td>
                        <td>
                            <?php echo $file->data_tekanan_udaraUrendah ?>
                        </td>
                        <td>
                            <?php echo $file->data_tekanan_udaraLrendah ?>
                        </td>
                        <td>
                            <?php echo $file->data_tekanan_udaraUsedang ?>
                        </td>
                        <td>
                            <?php echo $file->data_tekanan_udaraLsedang ?>
                        </td>
                        <td>
                            <?php echo $file->data_tekanan_udaraUtinggi ?>
                        </td>
                        <td>
                            <?php echo $file->data_tekanan_udaraLtinggi ?>
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
</section>

<section class="content">
  <div class="box">
    <div class="box-header">
          <h3 class="box-title">Inference dan Deffuzifikasi</h3>
          <br><br>
          <a href="<?php echo site_url('admin/fuzzy/inference');?>" class="btn-sm btn-primary">Inference dan Deffuzifikasi</a>
    </div>
    <div class="box-body">
          <div class="table-responsive">
              <table id="tableDocument" class="table table-striped table-bordered table-hover">
                <thead class="thin-border-bottom">
                  <tr >
                  </tr>
                </thead>
                <tbody>
                    <?php 
                      // $no=1;
                      // foreach( $data_fuzzifikasi as $file ):
                    ?>
                      <tr>
                        <td>
                            <!-- <?php echo $file->data_tekanan_udaraLtinggi ?> -->
                        </td>
                      </tr>
                    <?php 
                      // $no++;
                    // endforeach;?>
                </tbody>
              </table>
          </div>   
      </div>
  </div>
</section>

</div>