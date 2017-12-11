<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 日报管理
 */
class InputController extends AdminBaseController{

    public function daily(){
        $this->display();
    }

    /**
     * 获取日列表
     */
    public function getDailyInfo(){
        $ms = D('Daily');
        $map = [
            'status' => C('STATUS_Y'),
            'company_id' => array('in', session(C('USER_AUTH_KEY'))['company_auth'])
        ];

        $recordsTotal = $ms->where($map)->count(); // 没有过滤的记录数

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

        $recordsFiltered = $ms->where($map)->count(); // 过滤后的记录数

        // 排序
        $orderObj = I('order')[0];
        $orderColumn = $orderObj['column']; // 排序列，从0开始
        $orderDir = $orderObj['dir'];       // ase desc
        if(isset(I('order')[0])){
            $i = intval($orderColumn);
            switch($i){
                case 0: $ms->order('account_number '.$orderDir); break;
                case 1: $ms->order('start_time '.$orderDir); break;
                case 2: $ms->order('end_time '.$orderDir); break;
                case 3: $ms->order('pay_type_id '.$orderDir); break;
                case 4: $ms->order('receivable '.$orderDir); break;
                case 5: $ms->order('actual '.$orderDir); break;
                case 6: $ms->order('discount '.$orderDir); break;
                default: break;
            }
        }

        // 分页
        $start = I('start');  // 开始的记录序号
        $limit = I('limit');  // 每页显示条数
        $page = I('page');    // 第几页

        $infos = $ms->where($map)->page($page, $limit)->select();

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
            "draw" => intval(I('draw')),
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
        $res = $daily->where(['id'=>I('id')])->save();

        if ($res === false) {
            ajax_return(0, '删除日报出错');
        }
        ajax_return(1);
    }
}
