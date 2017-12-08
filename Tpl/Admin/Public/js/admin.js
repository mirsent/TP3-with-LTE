// To make Pace works on Ajax calls
$(document).ajaxStart(function() {
    Pace.restart();
});

// form表单赋值
function dataToForm(obj, data) {
    $('#' + obj + ' [name]').each(function(i, element) {
        var elementName = element.name,
            dataValue = data[elementName],
            $this = $(this);
        switch (element.type) {
            case 'text':
            case 'number':
            case 'hidden':
            case 'textarea':
                $this.val(dataValue);
                break;
            case 'radio':
                if ($this.val() == dataValue) $this.prop('checked', true);
                break;
            case 'checkbox':
                var checkboxName = elementName.substring(0, elementName.length - 2); // 去掉name后面的[]
                if ($.inArray($this.val(), data[checkboxName].split(',')) != '-1') $this.prop('checked', true);
                break;
            default:
                $this.find('option[value="' + dataValue + '"]').prop('selected', true);
                break;
        }
    });
}

// toastr["success"]("content", "title");
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "rtl": false,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": 300,
    "hideDuration": 1000,
    "timeOut": 2000,
    "extendedTimeOut": 1000,
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

// dataTables
var DTLang = {
    "sProcessing": "处理中...",
    "sLengthMenu": "显示 _MENU_ 项结果",
    "sZeroRecords": "没有匹配结果",
    "sInfo": "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
    "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
    "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
    "sInfoPostFix": "",
    "sSearch": "搜索:",
    "sUrl": "",
    "sEmptyTable": "表中数据为空",
    "sLoadingRecords": "载入中...",
    "sInfoThousands": ",",
    "oPaginate": {
        "sFirst": "首页",
        "sPrevious": "上页",
        "sNext": "下页",
        "sLast": "末页"
    },
    "oAria": {
        "sSortAscending": ": 以升序排列此列",
        "sSortDescending": ": 以降序排列此列"
    }
}

var DTSearchGroup =
    '<div class="btn-group">' +
    '<input type="text" class="form-control pull-left fuzzy-search" placeholder="模糊查询">' +
    '<button type="button" class="btn btn-default" id="fuzzySearch"><i class="fa fa-search"></i></button>' +
    '<button type="button" class="btn btn-default" title="高级查询" data-toggle="collapse" href="#searchCollapse"><i class="fa fa-angle-double-down"></i></button>' +
    '</div>';

// default setting
$.extend($.fn.dataTable.defaults, {
    dom:
        "<'row'<'col-sm-6'l><'search-item col-sm-6'>>" +
        "<'row'<'col-sm-12'<'#searchCollapse.collapse'>>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
    language: DTLang, // 提示信息
    autoWidth: false, // 自动调整列宽
    processing: true, // 加载提示
    serverSide: true, // 服务器端分页
    searching: false, // 原生搜索
    orderMulti: false, // 多列排序
    order: [], // 默认排序查询
    pagingType: "simple_numbers", // 分页样式：simple,simple_numbers,full,full_numbers
    columnDefs: [
        // {
        //     "targets": -1,
        //     "data": null,
        //     "defaultContent":
        //         '<div class="btn-group">' +
        //         '<button type="button" class="btn btn-info" id="detail">详情</button>' +
        //         '<button type="button" class="btn btn-success" id="edit">编辑</button>' +
        //         '<button type="button" class="btn btn-danger" id="delete">删除</button>' +
        //         '</div>',
        //     "class": "text-center",
        //     "searchable": false
        // }
    ]
});

// error
$.fn.dataTable.ext.errMode = function( settings, tn, msg ) {
    console.log(msg);
}

// 获取当前行数据
function getCurRowData(obj, that) {
    return obj.row(that.closest('tr')).data();
}

// 刷新DT
function DTReload(obj) {
    obj.ajax.reload();
}
function DTdraw(obj) {
    obj.ajax.reload(null, false);
}

function set_status(title, url, data){
    swal.queue([{
        title: title,
        type: 'question',
        confirmButtonText: '确定',
        showLoaderOnConfirm: true,
        preConfirm: function () {
            return new Promise(function (resolve) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    dataType:"json",
                    success: function(result) {
                        if (result.status == 1) {
                            toastr["success"]("操作成功", "");
                            swal.close();
                            DTdraw(oTable);
                        }
                    }
                });
            })
        }
    }]).catch(swal.noop);
}

// jquery.form
var formOptions = {
    type: 'post',
    dataType: 'json',
    timeout: 3000,
}


// 水印
function watermark(settings) {
    //默认设置
    var defaultSettings={
        watermark_txt:"text",
        watermark_x:250,//水印起始位置x轴坐标
        watermark_y:60,//水印起始位置Y轴坐标
        watermark_rows:20,//水印行数
        watermark_cols:20,//水印列数
        watermark_x_space:100,//水印x轴间隔
        watermark_y_space:100,//水印y轴间隔
        watermark_color:'#000',//水印字体颜色
        watermark_alpha:0.2,//水印透明度
        watermark_fontsize:'14px',//水印字体大小
        watermark_font:'微软雅黑',//水印字体
        watermark_width:150,//水印宽度
        watermark_height:80,//水印长度
        watermark_angle:15//水印倾斜度数
    };
    //采用配置项替换默认值，作用类似jquery.extend
    if(arguments.length===1&&typeof arguments[0] ==="object" ) {
        var src=arguments[0]||{};
        for(key in src) {
            if(src[key]&&defaultSettings[key]&&src[key]===defaultSettings[key])
                continue;
            else if(src[key])
                defaultSettings[key]=src[key];
        }
    }

    var oTemp = document.createDocumentFragment();

    //获取页面最大宽度
    var page_width = Math.max(document.body.scrollWidth,document.body.clientWidth);
    //获取页面最大长度
    var page_height = Math.max(document.body.scrollHeight,document.body.clientHeight);

    //如果将水印列数设置为0，或水印列数设置过大，超过页面最大宽度，则重新计算水印列数和水印x轴间隔
    if (defaultSettings.watermark_cols == 0 ||
        (parseInt(defaultSettings.watermark_x
　　　　+ defaultSettings.watermark_width *defaultSettings.watermark_cols
　　　　+ defaultSettings.watermark_x_space * (defaultSettings.watermark_cols - 1))
　　　　> page_width)) {
        defaultSettings.watermark_cols =
　　　　　　parseInt((page_width
　　　　　　　　　　-defaultSettings.watermark_x
　　　　　　　　　　+defaultSettings.watermark_x_space)
　　　　　　　　　　/ (defaultSettings.watermark_width
　　　　　　　　　　+ defaultSettings.watermark_x_space));
        defaultSettings.watermark_x_space =
　　　　　　parseInt((page_width
　　　　　　　　　　- defaultSettings.watermark_x
　　　　　　　　　　- defaultSettings.watermark_width
　　　　　　　　　　* defaultSettings.watermark_cols)
　　　　　　　　　　/ (defaultSettings.watermark_cols - 1));
    }
    //如果将水印行数设置为0，或水印行数设置过大，超过页面最大长度，则重新计算水印行数和水印y轴间隔
    if (defaultSettings.watermark_rows == 0 ||
        (parseInt(defaultSettings.watermark_y
　　　　+ defaultSettings.watermark_height * defaultSettings.watermark_rows
　　　　+ defaultSettings.watermark_y_space * (defaultSettings.watermark_rows - 1))
　　　　> page_height)) {
        defaultSettings.watermark_rows =
　　　　　　parseInt((defaultSettings.watermark_y_space
　　　　　　　　　　　+ page_height - defaultSettings.watermark_y)
　　　　　　　　　　　/ (defaultSettings.watermark_height + defaultSettings.watermark_y_space));
        defaultSettings.watermark_y_space =
　　　　　　parseInt((page_height
　　　　　　　　　　- defaultSettings.watermark_y
　　　　　　　　　　- defaultSettings.watermark_height
　　　　　　　　　　* defaultSettings.watermark_rows)
　　　　　　　　　/ (defaultSettings.watermark_rows - 1));
    }
    var x;
    var y;
    for (var i = 0; i < defaultSettings.watermark_rows; i++) {
        y = defaultSettings.watermark_y + (defaultSettings.watermark_y_space + defaultSettings.watermark_height) * i;
        for (var j = 0; j < defaultSettings.watermark_cols; j++) {
            x = defaultSettings.watermark_x + (defaultSettings.watermark_width + defaultSettings.watermark_x_space) * j;

            var mask_div = document.createElement('div');
            mask_div.id = 'mask_div' + i + j;
            mask_div.appendChild(document.createTextNode(defaultSettings.watermark_txt));
            //设置水印div倾斜显示
            mask_div.style.webkitTransform = "rotate(-" + defaultSettings.watermark_angle + "deg)";
            mask_div.style.MozTransform = "rotate(-" + defaultSettings.watermark_angle + "deg)";
            mask_div.style.msTransform = "rotate(-" + defaultSettings.watermark_angle + "deg)";
            mask_div.style.OTransform = "rotate(-" + defaultSettings.watermark_angle + "deg)";
            mask_div.style.transform = "rotate(-" + defaultSettings.watermark_angle + "deg)";
            mask_div.style.visibility = "";
            mask_div.style.position = "fixed";
            mask_div.style.left = x + 'px';
            mask_div.style.top = y + 'px';
            mask_div.style.overflow = "hidden";
            mask_div.style.zIndex = "9999";
            mask_div.style.opacity = defaultSettings.watermark_alpha;
            mask_div.style.fontSize = defaultSettings.watermark_fontsize;
            mask_div.style.fontFamily = defaultSettings.watermark_font;
            mask_div.style.color = defaultSettings.watermark_color;
            mask_div.style.textAlign = "center";
            mask_div.style.width = defaultSettings.watermark_width + 'px';
            mask_div.style.height = defaultSettings.watermark_height + 'px';
            mask_div.style.display = "block";
            mask_div.style.pointerEvents = "none";
            oTemp.appendChild(mask_div);
        };
    };
    document.body.appendChild(oTemp);
}
