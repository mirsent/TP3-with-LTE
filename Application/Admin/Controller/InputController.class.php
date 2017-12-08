<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 日报管理
 */
class InputController extends AdminBaseController{

    /**
     * 获取日列表
     */
    public function getDailyInfo(){
        //获取Datatables发送的参数
        $draw = I('draw');
        $mirse = D('Daily');
        $map = [
            'status' => C('STATUS_Y'),
            'company_id' => array('in', session(C('SNAME'))['company_auth'])
        ];

        $recordsTotal = $mirse->where($map)->count(); // 没有过滤的记录数

        // 搜索
        $search = I('search');
        $payType = I('pay_type_id');
        $searchDate = I('search_date');
        if (strlen($search)>0) {
            $map['account_number'] = array('like', '%'.$search.'%');
        }
        if (strlen($payType)>0) {
            $map['pay_type_id'] = $payType;
        }
        if (strlen($searchDate)>0) {
            $dayStart = strtotime($searchDate);
            $dayEnd = $dayStart + 86400;
            $map['start_time'] = array('between', [$dayStart, $dayEnd]);
        }

        $recordsFiltered = $mirse->where($map)->count(); // 过滤后的记录数

        // 排序
        $orderObj = I('order')[0];
        $orderColumn = $orderObj['column']; // 排序列，从0开始
        $orderDir = $orderObj['dir'];       // ase desc
        if(isset(I('order')[0])){
            $i = intval($orderColumn);
            switch($i){
                case 0: $mirse->order('account_number '.$orderDir); break;
                case 1: $mirse->order('start_time '.$orderDir); break;
                case 2: $mirse->order('end_time '.$orderDir); break;
                case 3: $mirse->order('pay_type_id '.$orderDir); break;
                case 4: $mirse->order('receivable '.$orderDir); break;
                case 5: $mirse->order('actual '.$orderDir); break;
                case 6: $mirse->order('discount '.$orderDir); break;
                default: break;
            }
        }

        // 分页
        $start = I('start');  // 开始的记录序号
        $limit = I('limit');  // 每页显示条数
        $page = I('page');    // 第几页

        $infos = $mirse->where($map)->page($page, $limit)->select();

        $payType = M('pay_type')->where(['status'=>C('STATUS_Y')])->getField('id,p_type_name');
        $company = M('company')->where(['status'=>C('STATUS_Y')])->getField('id,company_name');
        foreach ($infos as $key => $value) {
            $pTypeName = '';
            foreach (explode(',', $value['pay_type_id']) as $k => $v) {
                $pTypeName .= ','.$payType[$v];
            }
            $infos[$key]['p_type_name'] = trim($pTypeName, ',');
            $infos[$key]['company_name'] = $company[$value['company_id']];
            $infos[$key]['start_time_f'] = date('m-d H:m', $value['start_time']);
            $infos[$key]['start_time'] = date('Y-m-d H:m:s', $value['start_time']);
            $infos[$key]['end_time_f'] = date('m-d H:m', $value['end_time']);
            $infos[$key]['end_time'] = date('Y-m-d H:m:s', $value['end_time']);
        }

        echo json_encode(array(
            "draw" => intval($draw),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $infos
        ), JSON_UNESCAPED_UNICODE);
    }

    public function daily_detail(){
        $map['id'] = I('id');
        $info = M('daily')->where($map)->find();
        $this->assign('info',$info);
        $this->display();
    }

    /**
     * 录入日报
     */
    public function inputDaily(){
        $daily = D('Daily');
        $daily->create();

        $startTime = $daily->start_time;
        $endTime = $daily->end_time;
        $receivable = $daily->receivable;
        $actual = $daily->actual;
        $payTypeId = $daily->pay_type_id;

        $daily->start_time = strtotime($startTime);
        $daily->end_time = strtotime($endTime);
        $daily->discount = floatval($receivable) - floatval($actual);
        $daily->pay_type_id = implode(',', $payTypeId);

        $id = I('id');
        if ($id) {
            $map['id'] = $id;
            $res = $daily->editData($map, null);
        } else {
            $res = $daily->add();
        }

        if ($res === false) {
            ajax_return(0, '录入日报出错');
        }
        ajax_return(1);
    }

    /**
     * 删除日报
     */
    public function deleteDaily(){
        $daily = D('Daily');
        $daily->create();
        $map['id'] = I('id');
        $daily->status = C('STATUS_N');
        $res = $daily->editData($map, null);

        if ($res === false) {
            ajax_return(0, '删除日报出错');
        }
        ajax_return(1);
    }






    /**************************************** 支出 ******************************************/

    public function getExpensesInfo(){
        //获取Datatables发送的参数
        $draw = I('draw');

        $mirse = D('Expenses');
        $map['status'] = C('STATUS_Y');

        $recordsTotal = $mirse->where($map)->count(); // 没有过滤的记录数

        // 搜索
        $search = I('search');
        $purpose = I('purpose_id');
        $searchDate = I('search_date');
        if (strlen($search)>0) {
            $map['remarks'] = array('like', '%'.$search.'%');
        }
        if (strlen($purpose)>0) {
            $map['purpose_id'] = $purpose;
        }
        if (strlen($searchDate)>0) {
            $map['spending_time'] = strtotime($searchDate);
        }

        $recordsFiltered = $mirse->where($map)->count(); // 过滤后的记录数

        // 排序
        $orderObj = I('order')[0];
        $orderColumn = $orderObj['column']; // 排序列，从0开始
        $orderDir = $orderObj['dir'];       // ase desc
        if(isset(I('order')[0])){
            $i = intval($orderColumn);
            switch($i){
                case 0: $mirse->order('purpose_id '.$orderDir); break;
                case 1: $mirse->order('spending_time '.$orderDir); break;
                case 2: $mirse->order('remarks '.$orderDir); break;
                default: break;
            }
        }

        // 分页
        $start = I('start');  // 开始的记录序号
        $limit = I('limit');  // 每页显示条数
        $page = I('page');    // 第几页

        $infos = $mirse->where($map)->page($page, $limit)->select();
        $payType = M('purpose')->where(['status'=>C('STATUS_Y')])->getField('id, purpose_name');
        $company = M('company')->where(['status'=>C('STATUS_Y')])->getField('id,company_name');
        foreach ($infos as $key => $value) {
            $infos[$key]['purpose_name'] = $payType[$value['purpose_id']];
            $infos[$key]['company_name'] = $company[$value['company_id']];
            $infos[$key]['spending_time'] = date('Y-m-d', $value['spending_time']);
        }

        echo json_encode(array(
            "draw" => intval($draw),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $infos
        ), JSON_UNESCAPED_UNICODE);
    }

    /**
     * 录入支出
     */
    public function inputExpenses(){
        $expenses = D('Expenses');
        $expenses->create();
        $spendingTime = $expenses->spending_time;
        $expenses->spending_time = strtotime($spendingTime);

        $id = I('id');
        if ($id) {
            $map['id'] = $id;
            $res = $expenses->editData($map, null);
        } else {
            $res = $expenses->add();
        }

        if ($res === false) {
            ajax_return(0, '录入支出出错');
        }
        ajax_return(1);
    }

    /**
     * 删除支出
     */
    public function deleteExpenses(){
        $expenses = D('Expenses');
        $expenses->create();
        $map['id'] = I('id');
        $expenses->status = C('STATUS_N');
        $res = $expenses->editData($map, null);

        if ($res === false) {
            ajax_return(0, '删除支出出错');
        }
        ajax_return(1);
    }
}
