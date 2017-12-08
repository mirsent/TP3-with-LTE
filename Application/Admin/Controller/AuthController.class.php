<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
class AuthController extends AdminBaseController {

    /***********************************************************************************************
        规则管理
     **********************************************************************************************/
    public function rule(){
        $cond = array(
            'status' => C('STATUS_Y'),
            'pid' => 0
        );
        $pRules = M('auth_rule')->where($cond)->select();
        $assign = array(
            'table' => 'AuthRule',
            'pRules' => $pRules
        );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 查看权限规则信息
     */
    public function getAuthRuleInfo(){
        $draw = I('draw');
        $ms = D('AuthRule');
        $map['status'] = array('neq', C('STATUS_N'));

        $recordsTotal = $recordsFiltered = $ms->where($map)->count();
        $infos = $ms->where($map)->getTreeData('tree', '', 'title');

        echo json_encode(array(
            "draw" => intval($draw),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $infos
        ), JSON_UNESCAPED_UNICODE);
    }

    /**
     * 新增,编辑 权限规则
     */
    public function inputRule(){
        $authRule = D('AuthRule');
        $authRule->create();
        $id = I('id');

        if ($id) { // 编辑
            $map['id'] = $id;
            $res = $authRule->editData($map, null);
        } else {
            $res = $authRule->add();
        }

        if ($res === false) {
            ajax_return(0, '录入权限出错');
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

    /***********************************************************************************************
        用户组管理
     **********************************************************************************************/
    public function group(){
        $authRule = M('auth_rule');
        $map = array(
            'status' => C('STATUS_Y'),
            'pid' => 0
        );
        $rules = $authRule->where($map)->field('id, title')->order('id')->select();
        foreach ($rules as $key => $value) {
            $map['pid'] = $value['id'];
            $rules[$key]['_data'] = $authRule->where($map)->field('id, title')->order('id')->select();
        }

        $assign = array(
            'table' => 'AuthGroup',
            'rules' => $rules
        );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 获取权限分组信息
     */
    public function getAuthGroupInfo(){
        //获取Datatables发送的参数
        $draw = I('draw'); // 绘制计数器，Datatables发送的draw是多少那么服务器就返回多少（转成int防XXS）

        $ms = D('AuthGroup');
        $map['status'] = array('neq', C('STATUS_N'));

        $recordsTotal = $ms->where($map)->count(); // 没有过滤的记录数

        // 搜索
        $payType = I('p_type_name');
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
                case 0: $ms->order('title '.$orderDir); break;
                case 1: $ms->order('rules '.$orderDir); break;
                case 1: $ms->order('status '.$orderDir); break;
                default: break;
            }
        }

        // 分页
        $start = I('start');  // 开始的记录序号
        $limit = I('limit');  // 每页显示条数
        $page = I('page');    // 第几页

        $infos = $ms->where($map)->page($page, $limit)->select();
        foreach ($infos as $key => $value) {
            $infos[$key]['group_id'] = $value['id'];
            $infos[$key]['rules_arr'] = $this->getMultiSelectArr($value['rules']);
            $infos[$key]['rules'] = $this->getAuthById($value['rules']);
        }

        echo json_encode(array(
            "draw" => intval($draw),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $infos
        ), JSON_UNESCAPED_UNICODE);
    }

    /**
     * 组合权限 （父权限id,权限id）
     */
    public function getMultiSelectArr($rules){
        $arr = [];
        foreach (explode(',', $rules) as $v) {
            $cond = array(
                'status' => array('neq', C('STATUS_N')),
                'id' => $v
            );
            $pid = M('auth_rule')->where($cond)->getField('pid');
            array_push($arr, $pid.','.$v);
        }
        return $arr;
    }

    /**
     * 根据id获取规则
     */
    public function getAuthById($rules){
        foreach (explode(',', $rules) as $v) {
            $arr.= M('auth_rule')->getFieldById($v, 'title').';';
        }
        return trim($arr, ';');
    }

    /**
     * 新增/编辑 用户组
     */
    public function inputGroup(){
        $authGroup = D('AuthGroup');
        $authGroup->create();
        $authGroup->rules = implode(',', array_unique(explode(',', implode(',', I('rules')))));

        $id = I('id');
        if ($id) { // 编辑
            $map['id'] = $id;
            $res = $authGroup->editData($map, null);
        } else {
            $res = $authGroup->add();
        }
        if ($res === false) {
            ajax_return(0, '新增/编辑出错');
        }

        ajax_return(1);
    }

    /***********************************************************************************************
        用户管理
     **********************************************************************************************/

    public function user(){
        $map['status'] =  C('STATUS_Y');
        $groups = M('auth_group')->where($map)->select();
        $assign = array(
            'groups' => $groups
        );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 获取用户权限信息
     */
    public function getAuthUserInfo(){
        $draw = I('draw');

        $ms = D('AuthGroupAccess');
        $recordsTotal = $ms->count(); // 没有过滤的记录数

        // 搜索
        $realName = I('real_name');
        $groupName = I('group_name');
        if (strlen($realName)>0) {
            $map['u.real_name'] = array('like', '%'.$realName.'%');
        }
        if (strlen($groupName)>0) {
            $map['ag.title'] = array('like', '%'.$groupName.'%');
        }

        // 排序
        $orderObj = I('order')[0];
        $orderColumn = $orderObj['column']; // 排序列，从0开始
        $orderDir = $orderObj['dir'];       // ase desc
        if(isset(I('order')[0])){
            $i = intval($orderColumn);
            switch($i){
                case 0: $ms->order('uid '.$orderDir); break;
                case 1: $ms->order('group_id '.$orderDir); break;
                case 2: $ms->order('company_id '.$orderDir); break;
                default: break;
            }
        }

        // 分页
        $start = I('start');  // 开始的记录序号
        $limit = I('limit');  // 每页显示条数
        $page = I('page');    // 第几页

        $infos = $ms->alias('aga')
            ->join('__AUTH_GROUP__ ag ON ag.id = aga.group_id')
            ->join('__USER__ u ON u.id = aga.uid')
            ->join('__COMPANY__ c ON c.id = u.company_id')
            ->field('aga.*,ag.title as group_name,u.real_name,u.company_id,u.company_auth,c.company_name')
            ->where($map)
            ->page($page, $limit)
            ->select();

        $recordsFiltered = count($infos); // 过滤后

        foreach ($infos as $key => $value) {
            $infos[$key]['company_auth_arr'] = explode(',', $value['company_auth']);
            $infos[$key]['company_auth_name'] = $this->getCompanyById($value['company_auth']);
        }

        echo json_encode(array(
            "draw" => intval($draw),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $infos
        ), JSON_UNESCAPED_UNICODE);
    }

    static function getCompanyById($companys){
        foreach (explode(',', $companys) as $v) {
            $arr.= M('company')->getFieldById($v, 'company_name').';';
        }
        return trim($arr, ';');
    }

    /**
     * 修改用户权限
     */
    public function editAccess(){
        $tran_result = true;
        $trans = M();
        $trans->startTrans();   // 开启事务

        // 修改用户组
        $authGroupAccess = D('AuthGroupAccess');
        $authGroupAccess->create();
        $map['uid'] = $map_user['id'] = I('uid');
        $res = $authGroupAccess->editData($map, null);

        // 修改用户信息
        $user = D('User');
        $data = [
            'company_id' => I('company_id'),
            'company_auth' => implode(',', I('company_auth'))
        ];
        $userRes = $user->editData($map_user, $data);

        if ($res === false || $userRes === false) {
            $tran_result = false;
        }

        if ($tran_result === false) {
            $trans->rollback();
            ajax_return(0, '编辑用户权限出错');
        } else {
            $trans->commit();
            ajax_return(1);
        }
    }

    /**
     * 删除用户
     */
    public function deleteUser(){
        $tran_result = true;
        $trans = M();
        $trans->startTrans();   // 开启事务

        $userId = I('uid');

        // 删除用户权限
        if ($userId) {
            $map['uid'] = $userId;
            $res = M('auth_group_access')->where($map)->delete();
        }

        // 修改用户状态
        $map_user['id'] = $userId;
        $data_user['status'] = C('STATUS_N');
        $userRes = D('User')->editData($map_user,$data_user);

        if ($res === false || $userRes === false) {
            $tran_result = false;
        }

        if ($tran_result === false) {
            $trans->rollback();
            ajax_return(0, '删除用户出错');
        } else {
            $trans->commit();
            ajax_return(1);
        }
    }
}
