<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo C('title');?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="stylesheet" href="/TP3-with-LTE/Public/statics/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/TP3-with-LTE/Public/statics/font-awesome/css/font-awesome.min.css">
  <!-- pace -->
  <link rel="stylesheet" href="/TP3-with-LTE/Public/statics/pace/pace.min.css">
  <!-- toastr -->
  <link rel="stylesheet" href="/TP3-with-LTE/Public/statics/toastr/toastr.min.css">
  <!-- dataTables -->
  <!-- <link rel="stylesheet" href="/TP3-with-LTE/Public/statics/datatables/css/jquery.dataTables.min.css"> -->
  <link rel="stylesheet" href="/TP3-with-LTE/Public/statics/datatables/css/dataTables.bootstrap.min.css">
  <!-- layui   -->
  <link rel="stylesheet" href="/TP3-with-LTE/Public/statics/layui/css/layui.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="/TP3-with-LTE/Tpl//Admin/Public/css/AdminLTE.min.css">
  <link rel="stylesheet" href="/TP3-with-LTE/Tpl//Admin/Public/css/skins/_all-skins.min.css">
  <link rel="stylesheet" href="/TP3-with-LTE/Tpl//Admin/Public/css/admin.css">

  

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <!-- header -->
    <header class="main-header">
      <!-- Logo -->
      <a href="index2.html" class="logo">
        <span class="logo-mini"><b>A</b>LT</span>
        <span class="logo-lg"><b>Admin</b>LTE</span>
      </a>
      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-warning">10</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">你有10条提醒</li>
                <li>
                  <ul class="menu">
                    <li>
                      <a href="#">
                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="footer"><a href="#">查看全部</a></li>
              </ul>
            </li>
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- <img src="" class="user-image" alt="User Image"> -->
                <span class="hidden-xs">Admin</span>
              </a>
              <ul class="dropdown-menu">
                <li class="user-header">
                  <!-- <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> -->
                  <p>
                    Alexander Pierce - Web Developer
                    <small>Member since Nov. 2012</small>
                  </p>
                </li>
                <li class="user-footer">
                  <div class="text-center">
                    <a href="#" class="btn btn-default btn-flat">退出登录</a>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <!-- sidebar -->
    <aside class="main-sidebar">
      <section class="sidebar">
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
            </span>
          </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu -->
        <ul class="sidebar-menu" data-widget="tree">
          <li class="header">MAIN NAVIGATION</li>
          <li class="active treeview">
            <a href="#">
              <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="active">
                <a href="index.html"><i class="fa fa-circle-o text-red"></i> Dashboard v1</a>
              </li>
              <li>
                <a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a>
              </li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-files-o"></i>
              <span>Layout Options</span>
              <span class="pull-right-container">
                <span class="label label-primary pull-right">4</span>
              </span>
            </a>
          </li>
        </ul>
        <!-- /.sidebar menu -->
      </section>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
      <section class="content-header">
        <h1>

          标题

        </h1>
      </section>

      <section class="content">

        
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">描述</h3>
            <div class="box-tools">

            </div>
        </div>
        <div class="box-body">
            <dl class="dl-horizontal detail-item">
                <dt>标题：</dt>
                <dd>这是非得标题</dd>
                <dt>标题：</dt>
                <dd>这是标题</dd>
            </dl>
        </div>
    </div>



      </section>
    </div>

    <!-- footer -->
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.0.1
      </div>
      <strong>Copyright &copy; 2014-2016 <a href="https://github.com/mirsent/mirse">Mirse</a>.</strong> All rights
      reserved.
    </footer>
  </div>

  <script src="/TP3-with-LTE/Public/statics/jquery/dist/jquery.min.js"></script>
  <script src="/TP3-with-LTE/Public/statics/jquery-ui/jquery-ui.min.js"></script>
  <script src="/TP3-with-LTE/Public/statics/bootstrap/js/bootstrap.min.js"></script>
  <!-- pace -->
  <script src="/TP3-with-LTE/Public/statics/pace/pace.min.js"></script>
  <!-- nicescroll -->
  <script src="/TP3-with-LTE/Public/statics/nicescroll/jquery.nicescroll.min.js"></script>
  <!-- validate -->
  <script src="/TP3-with-LTE/Tpl//Admin/Public/js/jquery.form.js"></script>
  <script src="/TP3-with-LTE/Public/statics/validate/jquery.validate.min.js"></script>
  <!-- toastr -->
  <script src="/TP3-with-LTE/Public/statics/toastr/toastr.min.js"></script>
  <!-- dataTables -->
  <script src="/TP3-with-LTE/Public/statics/datatables/js/jquery.dataTables.min.js"></script>
  <script src="/TP3-with-LTE/Public/statics/datatables/js/dataTables.bootstrap.min.js"></script>
  <!-- layui -->
  <script src="/TP3-with-LTE/Public/statics/layui/layui.js"></script>

  <!-- custom js -->
  <script src="/TP3-with-LTE/Tpl//Admin/Public/js/adminlte.min.js"></script>
  <script src="/TP3-with-LTE/Tpl//Admin/Public/js/admin.js"></script>

  
    <script type="text/javascript">

    </script>

</body>
</html>