// To make Pace works on Ajax calls
$(document).ajaxStart(function() {
    Pace.restart();
});

// niceScroll
$("body").niceScroll();

// form表单赋值
function dataToForm(obj, data) {
    $('#' + obj + ' [name]').each(function(i, element) {
        var elementName = element.name,
            dataValue = data[elementName],
            $this = $(this);
        switch (element.type) {
            case 'text':
            case 'hidden':
                $this.val(dataValue);
                break;
            case 'textarea':
                $this.text(dataValue);
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

// detail
function dataToDetail(fields, data){
    var detailHtml = '<dl class="dl-horizontal detail-item">';
    for (k in fields) {
        detailHtml += '<dt>'+fields[k]+'：</dt><dd>'+data[k]+'</dd>';
    }
    detailHtml += '</dl>';
    return detailHtml;
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
    "hideDuration": 800,
    "timeOut": 1000,
    "extendedTimeOut": 1000,
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}

// dataTables
var DTLang = {
    "sProcessing": "处理中...",
    "sLengthMenu": "每页 _MENU_ 项",
    "sZeroRecords": "没有匹配结果",
    "sInfo": "当前显示第 _START_ 至 _END_ 项，共 _TOTAL_ 项。",
    "sInfoEmpty": "当前显示第 0 至 0 项，共 0 项",
    "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
    "sInfoPostFix": "",
    "sSearch": "搜索:",
    "sUrl": "",
    "sEmptyTable": "当前没有信息...",
    "sLoadingRecords": "载入中...",
    "sInfoThousands": ",",
    "oPaginate": {
        "sFirst": "首页",
        "sPrevious": "上页",
        "sNext": "下页",
        "sLast": "末页",
        "sJump": "跳转"
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
        {
            "targets": -1,
            "data": null,
            "defaultContent":
                '<div class="btn-group">' +
                '<button type="button" class="btn btn-info" id="detail">详情</button>' +
                '<button type="button" class="btn btn-success" id="edit">编辑</button>' +
                '<button type="button" class="btn btn-danger" id="delete">删除</button>' +
                '</div>',
            "class": "text-center",
            "searchable": false
        }
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
    obj.draw(false);
}


// jquery.form
var formOptions = {
    type: 'post',
    dataType: 'json',
    timeout: 3000,
}
