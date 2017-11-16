<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->display();
    }

    public function getDTInfo(){
        //获取Datatables发送的参数
        $draw = I('draw'); // 绘制计数器，Datatables发送的draw是多少那么服务器就返回多少（转成int防XXS）

        $nav = D('Demo');
        $map['status'] = C('STATUS_Y');

        $recordsTotal = $nav->where($map)->count(); // 没有过滤的记录数

        // 搜索
        $search = I('search'); // 获取前台传过来的过滤条件
        $navName = I('nav_name');
        $navMca = I('nav_mca');
        if (strlen($search)>0) {
            $map['nav_name|nav_mca'] = array('like', '%'.$search.'%');
        }
        if (strlen($navName)>0) {
            $map['nav_name'] = array('like', '%'.$navName.'%');
        }
        if (strlen($navMca)>0) {
            $map['nav_mca'] = array('like', '%'.$navMca.'%');
        }

        $recordsFiltered = $nav->where($map)->count(); // 过滤后的记录数

        // 排序
        $orderObj = I('order')[0];
        $orderColumn = $orderObj['column']; // 排序列，从0开始
        $orderDir = $orderObj['dir'];       // ase desc
        if(isset(I('order')[0])){
            $i = intval($orderColumn);
            switch($i){
                case 0: $nav->order('name '.$orderDir); break;
                case 1: $nav->order('content '.$orderDir); break;
                default: break;
            }
        }

        // 分页
        $start = I('start');  // 开始的记录序号
        $limit = I('limit');  // 每页显示条数
        $page = I('page');    // 第几页

        $infos = $nav->where($map)->page($page, $limit)->select();

        echo json_encode(array(
            "draw" => intval($draw),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $infos
        ), JSON_UNESCAPED_UNICODE);
    }

    public function addSome(){
        $id = I('id');
        $demo = D('Demo');
        $demo->create();
        $demo->auth = implode(',', $demo->auth);

        if ($id) {
            $map['id'] = $id;
            $demo->where($map)->save();
        } else {
            $demo->add();
        }
        ajax_return();
    }
}
