<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <!-- <?php echo var_dump($grafik)?> -->
    <?php echo $page_name ?>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i>Admin</a></li>
    <li class="active">Beranda</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <div class="row"> 
  <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
<!--       <h3>Selamat Datang :)</h3> -->
      <!-- small box -->
      <div class="small-box bg-yellow">
        <div class="inner">
          <h3><?php echo $data_meteorologi_count ?></h3>

          <p>Data Meteorologi</p>
        </div>
        <div class="icon">
          <i class="ion ion-android-list"></i>
        </div>
        <a href="<?php echo site_url("admin/data_meteorologi") ?>" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <!-- <div class="col-lg-3 col-xs-6"> -->
      <!-- small box -->
      <!-- <div class="small-box bg-primary">
        <div class="inner">
          <h3><?php echo $data_uji_count ?><sup style="font-size: 20px"></sup></h3>

          <p>Data Uji</p>
        </div>
        <div class="icon">
          <i class="ion ion-person"></i>
        </div>
        <a href="<?php echo site_url("admin/data_uji") ?>" class="small-box-footer">Lihat <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div> -->
    
    <!-- ./col -->
    <!-- <div class="col-lg-3 col-xs-6">
      <div class="small-box bg-red">
        <div class="inner">
          <h3>65</h3>

          <p>Tidak diterima</p>
        </div>
        <div class="icon">
          <i class="fa fa-hand-paper-o"></i>
        </div>
        <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div> -->
    <!-- ./col -->
  </div>

  <div class="row">
    <div class="col-lg-10 connectedSortable">
      <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <li class="pull-left header"><i class="fa fa-inbox"></i> <?php echo $chart_name ?></li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
              <div id="graph"></div>
                <link rel="stylesheet" href="<?php echo base_url();?>assets/lib/morris.css">
                <script src="<?php echo base_url();?>assets/lib/jquery.min.js"></script>
                <script src="<?php echo base_url();?>assets/lib/raphael-min.js"></script>
                <script src="<?php echo base_url();?>assets/lib/morris.min.js"></script>
                <script>
                  Morris.Bar({
                    element: 'graph',
                    data: <?php echo $grafik; ?>,
                    xkey: 'data_tanggal',
                    ykeys: ['data_curah_hujan', 'data_curah_hujan_prediksi'],
                    labels: ['Data Curah Hujan', 'Data Prediksi Curah Hujan'],
                    barColors: ["#B21516", "#1531B2"]
                  });
                </script>
            </div>        
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6">
      <h3>Root Mean Square Error = <?php if($rmse != '') echo $rmse ?></h3>
      <!-- <h3>Mean Absolute Error = <?php if($mae != '')echo $mae ?></h3> -->
      
    </div>
  </div>

</section>
<!-- /.content -->
</div>