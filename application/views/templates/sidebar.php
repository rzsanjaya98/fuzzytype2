<?php
  $menus = array(
    array(
      'menuId' => "home",
      'menuName' => "Beranda",
      // 'menuPath' => site_url("home"),
      'menuPath' => site_url("admin/home"),
      'menuIcon' => "fa fa-file-archive-o"
    ),

    array(
      'menuId' => "data_meteorologi",
      'menuName' => "Data Meteorologi",
      'menuPath' => site_url("admin/data_meteorologi"),
      'menuIcon' => 'fa fa-server'
    ),

    array(
      'menuId' => "fuzzy",
      'menuName' => "Fuzzy",
      'menuPath' => site_url("admin/fuzzy"),
      'menuIcon' => 'fa fa-gears'
    )

    // array(
    //   'menuId' => "data_uji",
    //   'menuName' => "Data Uji",
    //   'menuPath' => site_url("admin/data_uji"),
    //   'menuIcon' => 'fa fa-server'
    // )
  );

?>

<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo base_url() ?>assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->userdata('user_profile_fullname')?></p>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU</li>
      <?php
        foreach($menus as $menu):
        ?>
        <li id="<?php echo $menu['menuId'] ?>">
          <a href="<?php echo $menu['menuPath'] ?>">
          <i class="menu-icon <?php echo $menu['menuIcon'] ?>"></i>
          <span class="menu-text"> <?php echo $menu['menuName'] ?> </span>
          </a>
          <b class="arrow"></b>
        </li>
        <?php
          endforeach;
      ?>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <script type="text/javascript">
    function menuActive( id ){
        // var a =document.getElementById("menu").children[num-1].className="active";
        if( id == "" )
          var a =document.getElementById("home").className="active";
        else
          var a =document.getElementById(id).className="active";
        console.log(a);
    }
</script>