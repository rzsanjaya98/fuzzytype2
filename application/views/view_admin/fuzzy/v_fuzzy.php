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
                    <th>Temperatur</th>
                    <th>Kelembapan</th>
                    <th>Lama Penyinaran Matahari</th>
                    <th>Kecepatan Angin</th>
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
                            <?php echo 'sejukU : '.$file->data_temperaturUsejuk.'<br> sejukL : '.$file->data_temperaturLsejuk.'<br> normalU : '.$file->data_temperaturUnormal.'<br> normalL : '.$file->data_temperaturLnormal.'<br> panasU : '.$file->data_temperaturUpanas.'<br> panasL : '.$file->data_temperaturLpanas.'<br>' 
                            ?>
                        </td>
                        <td>
                            <?php echo 'keringU : '.$file->data_kelembapanUkering.'<br> keringL : '.$file->data_kelembapanLkering.'<br> lembabU : '.$file->data_kelembapanUlembab.'<br> lembabL : '.$file->data_kelembapanLlembab.'<br> basahU : '.$file->data_kelembapanUbasah.'<br> basahL : '.$file->data_kelembapanLbasah.'<br>' 
                            ?>
                        </td>
                        <td>
                            <?php echo 'rendahU : '.$file->data_lama_penyinaran_matahariUrendah.'<br> rendahL : '.$file->data_lama_penyinaran_matahariLrendah.'<br> sedangU : '.$file->data_lama_penyinaran_matahariUsedang.'<br> sedangL : '.$file->data_lama_penyinaran_matahariLsedang.'<br> tinggiU : '.$file->data_lama_penyinaran_matahariUtinggi.'<br> tinggiL : '.$file->data_lama_penyinaran_matahariLtinggi.'<br>' 
                            ?>
                        </td>
                        <td>
                            <?php echo 'lambatU : '.$file->data_kecepatan_anginUlambat.'<br> lambatL : '.$file->data_kecepatan_anginLlambat.'<br> agakkencangU : '.$file->data_kecepatan_anginUagakkencang.'<br> agakkencangL : '.$file->data_kecepatan_anginLagakkencang.'<br> kencangU : '.$file->data_kecepatan_anginUkencang.'<br> kencangL : '.$file->data_kecepatan_anginLkencang.'<br>'
                            ?>
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
          <h3 class="box-title">Inference, Type Reducer dan Deffuzifikasi</h3>
          <br><br>
          <a href="<?php echo site_url('admin/fuzzy/inference');?>" class="btn-sm btn-primary">Inference dan Deffuzifikasi</a>
    </div>
    <div class="box-body">
          <div class="table-responsive">
              <table id="tableDocument" class="table table-striped table-bordered table-hover">
                <thead class="thin-border-bottom">
                  <tr >
                    <th style="width:30px; text-align: center;">No</th>
                    <th style="width:100px; text-align: center;">Tanggal</th>
                    <th>Data Curah Hujan</th>
                    <th>Data Prediksi Curah Hujan</th>
                  </tr>
                </thead>
                <tbody>
                    <?php 
                      $no=1;
                      foreach( $data_prediksi as $file ):
                    ?>
                      <tr>
                        <td>
                            <?php echo $no ?>
                        </td>
                        <td>
                            <?php echo $file->data_tanggal ?>
                        </td>
                        <td>
                            <?php
                                if($file->data_curah_hujan>0 && $file->data_curah_hujan<5)
                                {
                                  $kategori = "Ringan";
                                }else if($file->data_curah_hujan>=5 && $file->data_curah_hujan<=20)
                                {
                                  $kategori = "Sedang";
                                }else if($file->data_curah_hujan>20 && $file->data_curah_hujan<=50)
                                {
                                  $kategori = "Agak Lebat";
                                }else if($file->data_curah_hujan>50 && $file->data_curah_hujan<=100)
                                {
                                  $kategori = "Lebat";
                                }
                                echo $file->data_curah_hujan." (".$kategori.")"; 
                             ?>
                        </td>
                        <td>
                            <?php
                                if($file->data_curah_hujan_prediksi>0 && $file->data_curah_hujan_prediksi<5)
                                {
                                  $kategori = "Ringan";
                                }else if($file->data_curah_hujan_prediksi>=5 && $file->data_curah_hujan_prediksi<=20)
                                {
                                  $kategori = "Sedang";
                                }else if($file->data_curah_hujan_prediksi>20 && $file->data_curah_hujan_prediksi<=50)
                                {
                                  $kategori = "Agak Lebat";
                                }else if($file->data_curah_hujan_prediksi>50 && $file->data_curah_hujan_prediksi<=100)
                                {
                                  $kategori = "Lebat";
                                } 
                                echo $file->data_curah_hujan_prediksi." (".$kategori.")"; 
                            ?>
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

</div>