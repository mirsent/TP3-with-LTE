<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 系统配置controller
 */
class SysController extends AdminBaseController{
    /**
     * 支付方式管理
     */
    public function pay_type(){
        $this->assign('table', 'PayType');
        $this->display();
    }

    /**
     * 获取支付方式列表
     * @return arr 支付方式数组
     */
    public function getPayTypeInfo(){
        //获取Datatables发送的参数
        $draw = I('draw'); // 绘制计数器，Datatables发送的draw是多少那么服务器就返回多少（转成int防XXS）

        $ms = D('PayType');
        $map['status'] = array('neq', C('STATUS_N'));

        $recordsTotal = $ms->where($map)->count(); // 没有过滤的记录数

        // 搜索
        $search = I('search');
        $payType = I('p_type_name');
        if (strlen($search)>0) {
            $map['p_type_name'] = array('like', '%'.$search.'%');
        }
        if (strlen($payType)>0) {
            $map['p_type_name'] = array('like', '%'.$payType.'%');
        }

        $recordsFiltered = $ms->where($map)->count(); // 过滤后的记录数

        // 排序
        $orderObj = I('order')[0];
        $orderColumn = $orderObj['column']; // 排序列，从0开始
        $orderDir = $orderObj['dir'];       // ase desc
        if(isset(I('order')[0])){
            $i = intval($orderColumn);
            switch($i){
                case 0: $ms->order('p_type_name '.$orderDir); break;
                case 1: $ms->order('status '.$orderDir); break;
                default: break;
            }
        }

        // 分页
        $start = I('start');  // 开始的记录序号
        $limit = I('limit');  // 每页显示条数
        $page = I('page');    // 第几页

        $infos = $ms->where($map)->page($page, $limit)->select();

        echo json_encode(array(
            "draw" => intval($draw),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $infos
        ), JSON_UNESCAPED_UNICODE);
    }

    /**
     * 用途管理
     */
    public function purpose(){
        $this->assign('table', 'Purpose');
        $this->display();
    }

    /**
     * 获取用途列表
     * @return array 用途数组
     */
    public function getPurposeInfo(){
        //获取Datatables发送的参数
        $draw = I('draw'); // 绘制计数器，Datatables发送的draw是多少那么服务器就返回多少（转成int防XXS）

        $ms = D('Purpose');
        $map['status'] = array('neq', C('STATUS_N'));

        $recordsTotal = $ms->where($map)->count(); // 没有过滤的记录数

        // 搜索
        $search = I('search'); // 获取前台传过来的过滤条件
        $purpose = I('purpose_name');
        if (strlen($search)>0) {
            $map['purpose_name'] = array('like', '%'.$search.'%');
        }
        if (strlen($purpose)>0) {
            $map['purpose_name'] = array('like', '%'.$purpose.'%');
        }

        $recordsFiltered = $ms->where($map)->count(); // 过滤后的记录数

        // 排序
        $orderObj = I('order')[0];
        $orderColumn = $orderObj['column']; // 排序列，从0开始
        $orderDir = $orderObj['dir'];       // ase desc
        if(isset(I('order')[0])){
            $i = intval($orderColumn);
            switch($i){
                case 0: $ms->order('purpose_name '.$orderDir); break;
                case 1: $ms->order('status '.$orderDir); break;
                default: break;
            }
        }

        // 分页
        $start = I('start');  // 开始的记录序号
        $limit = I('limit');  // 每页显示条数
        $page = I('page');    // 第几页

        $infos = $ms->where($map)->page($page, $limit)->select();

        echo json_encode(array(
            "draw" => intval($draw),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $infos
        ), JSON_UNESCAPED_UNICODE);
    }

    /**
     * 公司管理
     */
    public function company(){
        $this->assign('table', 'Company');
        $this->display();
    }

    /**
     * 获取公司列表
     * @return array 公司数组
     */
    public function getCompanyInfo(){
        //获取Datatables发送的参数
        $draw = I('draw'); // 绘制计数器，Datatables发送的draw是多少那么服务器就返回多少（转成int防XXS）

        $ms = D('Company');
        $map['status'] = array('neq', C('STATUS_N'));

        $recordsTotal = $ms->where($map)->count(); // 没有过滤的记录数

        // 搜索
        $search = I('search'); // 获取前台传过来的过滤条件
        $company = I('company_name');
        if (strlen($search)>0) {
            $map['company_name'] = array('like', '%'.$search.'%');
        }
        if (strlen($company)>0) {
            $map['company_name'] = array('like', '%'.$company.'%');
        }

        $recordsFiltered = $ms->where($map)->count(); // 过滤后的记录数

        // 排序
        $orderObj = I('order')[0];
        $orderColumn = $orderObj['column']; // 排序列，从0开始
        $orderDir = $orderObj['dir'];       // ase desc
        if(isset(I('order')[0])){
            $i = intval($orderColumn);
            switch($i){
                case 0: $ms->order('company_name '.$orderDir); break;
                case 1: $ms->order('status '.$orderDir); break;
                default: break;
            }
        }

        // 分页
        $start = I('start');  // 开始的记录序号
        $limit = I('limit');  // 每页显示条数
        $page = I('page');    // 第几页

        $infos = $ms->where($map)->page($page, $limit)->select();

        echo json_encode(array(
            "draw" => intval($draw),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $infos
        ), JSON_UNESCAPED_UNICODE);
    }

    /**
     * 新增/编辑
     */
    public function addAndEdit(){
        $ms = D(I('table'));
        $ms->create();
        $id = I('id');
        if ($id) {
            $map['id'] = $id;
            $res = $ms->editData($map, null);
        } else {
            $res = $ms->add();
        }

        if ($res === false) {
            ajax_return(0, '新增出错');
        }
        ajax_return(1);
    }

    /**
     * 设置状态
     */
    public function setStatus(){
        $ms = D(I('table'));
        $ms->create();
        $map['id'] = I('id');
        $res = $ms->editData($map, null);

        if ($res === false) {
            ajax_return(0, '设置状态出错');
        }
        ajax_return(1);
    }

    public function admin_nav(){
        $map = array(
            'status' => array('neq',C('STATUS_N')),
            'pid' => 0
        );
        $navs = M('admin_nav')->where($map)->select();
        $assign = array(
            'table' => 'AdminNav',
            'navs' => $navs
        );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 获取菜单列表
     */
    public function getAdminNavInfo(){
        $draw = I('draw');
        $ms = D('AdminNav');
        $map['status'] = array('neq', C('STATUS_N'));

        $recordsTotal = $recordsFiltered = $ms->where($map)->count();
        $infos = $ms->where($map)->getTreeData();

        echo json_encode(array(
            "draw" => intval($draw),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $infos
        ), JSON_UNESCAPED_UNICODE);
    }

    /**
     * 新增/编辑 菜单
     */
    public function inputNav(){
        $adminNav = D('AdminNav');
        $adminNav->create();
        $id = I('id');

        if ($id) { // 编辑
            $map['id'] = $id;
            $res = $adminNav->editData($map, null);
        } else {
            $res = $adminNav->add();
        }

        if ($res === false) {
            ajax_return(0, '录入菜单出错');
        }
        ajax_return(1);
    }
}
