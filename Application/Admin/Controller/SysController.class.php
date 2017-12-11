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
        $ms = D(I('table'));
        $infos = $ms->getDTInfo();
        echo json_encode([
            "data" => $infos
        ], JSON_UNESCAPED_UNICODE);
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
            $res = $ms->where($map)->save();
        } else {
            $res = $ms->add();
        }

        if ($res === false) {
            ajax_return(0, '新增/编辑 出错');
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
        $res = $ms->where($map)->save();

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
