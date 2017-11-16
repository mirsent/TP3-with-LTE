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
                <button type="button" class="btn btn-primary" id="add">添加</button>
            </div>
        </div>
        <div class="box-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>标题</th>
                        <th>内容</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <script type="text/html" id="actionModal">
        <form class="layui-form" id="actionForm">
            <div class="layui-form-item">
                <label class="layui-form-label">输入框</label>
                <div class="layui-input-block">
                    <input type="text" name="name" required lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">选择框</label>
                <div class="layui-input-block">
                    <select name="type_id" lay-verify="required" lay-search>
                        <option value=""></option>
                        <option value="0">北京</option>
                        <option value="1">上海</option>
                        <option value="2">广州</option>
                        <option value="3">深圳</option>
                        <option value="4">杭州</option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">复选框</label>
                <div class="layui-input-block">
                    <input type="checkbox" name="auth[]" value="1" title="写作" lay-skin="primary">
                    <input type="checkbox" name="auth[]" value="2" title="阅读" lay-skin="primary">
                    <input type="checkbox" name="auth[]" value="3" title="发呆" lay-skin="primary">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">单选框</label>
                <div class="layui-input-block">
                    <input type="radio" name="status" value="1" title="正常" checked>
                    <input type="radio" name="status" value="0" title="删除">
                </div>
            </div>
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">文本域</label>
                <div class="layui-input-block">
                    <textarea name="content" placeholder="请输入内容" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
            <input type="hidden" name="id">
        </form>
    </script>

    <script type="text/html" id="detailModal">
        <dl class="dl-horizontal detail-item">
            <dt>标题：</dt>
            <dd>这是非得标题</dd>
            <dt>标题：</dt>
            <dd>这是标题</dd>
        </dl>
    </script>


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
        $(document).ready(function() {
            oTable = $(".table").DataTable({
                ajax: function(data, callback, settings) {
                    param = {
                        draw: data.draw, // 绘制计数器
                        limit: data.length, // 每页显示多少条数据
                        start: data.start, // 开始的记录序号
                        page: (data.start / data.length) + 1, // 当前页码
                        order: data.order, // 排序
                        search: $('.fuzzy-search').val(), // 模糊搜索

                        nav_name: $('[name="nav_name"]').val(),
                        nav_mca: $('[name="nav_mca"]').val()
                    };
                    $.ajax({
                        type: "POST",
                        url: "<?php echo U('Index/getDTInfo');?>",
                        data: param,
                        dataType: "json",
                        success: function(result) {
                            var returnData = {
                                draw: data.draw, // Datatables发送的draw是多少服务器就返回多少
                                recordsTotal: result.recordsTotal, // 返回数据全部记录数
                                recordsFiltered: result.recordsFiltered, // 返回过滤后记录数
                                data: result.data // 返回的数据列表
                            };
                            callback(returnData); // 调用DataTables提供的callback方法，代表数据传回DataTables进行渲染
                        }
                    });
                },
                columns: [
                    { "data": "name" },
                    { "data": "content" },
                    {
                        "data": "status",
                        "class": 'text-center',
                        render: function(data, type, row, meta) {
                            return data == <?php echo C('STATUS_Y');?> ? '<span class="text-success">正常</span>' : '<span class="text-danger">删除</span>';
                        }
                    },
                    null
                ],
                initComplete: function(settings, json) {
                    // 高级搜索
                    var advancedHtml = '<form class="form-inline well advanced-form">',
                        searchArr = { 'nav_name': '标题', 'nav_mca': '内容' };
                    for (k in searchArr) {
                        advancedHtml += '<div class="form-group"><label>' + searchArr[k] + ' ：</label>';
                        advancedHtml += '<input type="text" class="form-control" name="' + k + '" placeholder="' + searchArr[k] + '"></div>';
                    }
                    advancedHtml += '<button type="button" class="btn btn-default" id="advancedSearch"><i class="fa fa-search"></i>查询</button></form>';
                    $('.search-item').append(DTSearchGroup);
                    $('#searchCollapse').append(advancedHtml);
                }
            });
        });

        /************************* document ready end *****************************/

        // 模糊搜索
        $('.box-body').on('click', '#fuzzySearch', function() {
            DTReload(oTable);
        });
        // 高级搜索
        $('.box-body').on('click', '#advancedSearch', function() {
            DTReload(oTable);
        });

        layui.use(['layer', 'form'], function() {
            layer = layui.layer,
            form = layui.form;

            form.on('submit(formDemo)', function(data) {
                formOptions.url = "<?php echo U('Index/addSome');?>";
                formOptions.success = function(responseText, statusText) {
                    if (responseText.status == 1) {
                        toastr["success"]("添加成功", "OK");
                        oTable.ajax.reload();
                        layer.closeAll();
                    }
                }
                $('#actionForm').ajaxSubmit(formOptions);
                return false;
            });
        });

        $('#add').on('click', function() {
            layer.open({
                type: 1,
                title: '标题',
                content: $('#actionModal').html(),
                skin: 'layui-layer-lan',
                area: '40%',
            });
            form.render();
        });

        // 编辑
        $('.table').on('click', '#edit', function() {
            var data = getCurRowData(oTable, $(this));
            layer.open({
                type: 1,
                title: '标题',
                content: $('#actionModal').html(),
                skin: 'layui-layer-lan',
                area: '40%',
                success: function(layero, index){
                    dataToForm('actionForm', data);
                }
            });
            form.render();

        });

        // 详情
        $('.table').on('click', '#detail', function() {
            var data = getCurRowData(oTable, $(this));
            var detailArr = { 'name': '标题', 'content': '内容' };

            layer.open({
                type: 1,
                title: '详情',
                content: dataToDetail(detailArr, data),
                skin: 'layui-layer-lan',
                area: '35%',
                success: function(layero, index){
                    dataToForm('test', data);
                }
            });
            form.render();
        });
    </script>

</body>
</html>