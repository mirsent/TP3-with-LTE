<?php
namespace Admin\Controller;
use Common\Controller\AdminBaseController;
/**
 * 统计管理
 */
class TotalController extends AdminBaseController{

    /**
     * 当日日报统计
     */
    public function day(){
        $auth=new \Think\Auth();
        $rule_name='Admin/ShowMenu/Total';
        $has_total_auth = $auth->check($rule_name,$_SESSION[C('SNAME')]['id']);

        // 获取公司
        $map_company = array(
            'status' => C('STATUS_Y'),
            'id' => array('in', session(C('SNAME'))['company_auth'])
        );
        $company = M('company')
            ->where($map_company)
            ->select();

        // 日报
        $daily = D('Daily');
        $day = I('d');
        if ($day) {
            $time = strtotime($day);
        } else {
            $time = strtotime(date('Y-m-d'));
        }
        $map = [
            'status' => C('STATUS_Y'),
            'start_time' => array('between', [$time, $time+86400])
        ];

        // 总计
        $total = [
            'receivable' => $daily->getReceivableTotal($map),
            'actual'     => $daily->getActualTotal($map),
            'discount'   => $daily->getDiscountTotal($map),
            'radio'      => $daily->getPayTypeRadio($map),
        ];

        // 各公司情况
        foreach ($company as $key => $value) {
            $map['company_id'] = $value['id'];
            // 公司信息
            $companys[$key] = array(
                'company_id'   => $value['id'],
                'company_name' => $value['company_name']
            );
            // 日报信息
            $info[$key] = array(
                'company_id'   => $value['id'],
                'receivable'   => $daily->getReceivableTotal($map),
                'actual'       => $daily->getActualTotal($map),
                'discount'     => $daily->getDiscountTotal($map),
                'radio'        => $daily->getPayTypeRadio($map),
            );
        }

        $assign = array(
            'hasTotalAuth' => $has_total_auth,
            'total'        => $total,
            'companys'     => $companys,
            'info'         => $info
        );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 获取当日日报折线图数据
     */
    public function getDailyChart(){
        $daily = D('Daily');
        $day = I('day');
        if ($day) {
            $start_time = strtotime($day);
        } else {
            $start_time = strtotime(date('Y-m-d'));
        }

        for($i=0; $i < 24; $i++){
            $hours[] = $start_time+$i*3600; //每隔一小时赋值给数组
        }

        $companyId = I('company_id');
        if ($companyId) {
            $map['company_id'] = $companyId;
        }
        $map['status'] = C('STATUS_Y');
        foreach ($hours as $key => $value) {
            $map['start_time'] = array('between', [$value, $value+3599]);
            $actual[] = floatval($daily->getActualTotal($map)); // 实收
        }
        $data = array(
            'actual' => $actual,
        );
        echo json_encode($data);
    }

    /**
     * 获取餐品明细图表数据
     */
    public function getDailyDetailsChart(){
        $day = I('day');

        if ($day) {
            $start_time = strtotime($day);
        } else {
            $start_time = strtotime(date('Y-m-d'));
        }

        $map = [
            'status' => C('STATUS_Y'),
            'start_time' => array('between', [$start_time, $start_time+86399])
        ];
        $daily = D('Daily');
        $companyId = I('company_id');
        if ($companyId) {
            $map['company_id'] = $companyId;
        }
        $radio = $daily->getDailyDetailsRadio($map);
        $legend = [];
        foreach ($radio as $key => $value) {
            array_push($legend, $key);
            $series[] = [
                'name' => $key,
                'value' => $value
            ];
        }
        $data = [
            'legend' => $legend,
            'series' =>$series
        ];
        echo json_encode($data);
    }


    /**
     * 当月统计
     */
    public function month(){
        // 获取公司列表
        $map_company = array(
            'status' => C('STATUS_Y'),
            'id' => array('in', session(C('SNAME'))['company_auth'])
        );
        $company = M('company')
            ->where($map_company)
            ->select();

        $month = I('d');
        if ($month) {
            $month_start = strtotime($month);
            $month_end = mktime(23, 59, 59, date('m', strtotime($month))+1, 00);
        } else {
            $month_start = mktime(0,0,0,date('m'),1,date('Y'));
            $month_end = mktime(23,59,59,date('m'),date('t'),date('Y'));
        }
        $map = [
            'status' => C('STATUS_Y'),
            'start_time' => array('between', [$month_start, $month_end]),
            'spending_time' => array('between', [$month_start, $month_end]),
        ];

        $daily = D('Daily');
        $expenses = D('Expenses');

        $total = [
            // 日报总计
            'receivable'    => $daily->getReceivableTotal($map),
            'actual'        => $daily->getActualTotal($map),
            'discount'      => $daily->getDiscountTotal($map),
            'radio'         => $daily->getPayTypeRadio($map),
            // 支出总计
            'expenses'      => $expenses->getExpensesTotal($map),
            'purpose_radio' => $expenses->getPurposeRadio($map)
        ];


        foreach ($company as $key => $value) {
            $map['company_id'] = $value['id'];
            $companys[$key] = array(
                'company_id'   => $value['id'],
                'company_name' => $value['company_name']
            );

            $info[$key] = array(
                'company_id'    => $value['id'],
                // 日报各公司情况
                'receivable'    => $daily->getReceivableTotal($map),
                'actual'        => $daily->getActualTotal($map),
                'discount'      => $daily->getDiscountTotal($map),
                'radio'         => $daily->getPayTypeRadio($map),
                // 支出各公司情况
                'expenses'      => $expenses->getExpensesTotal($map),
                'purpose_radio' => $expenses->getPurposeRadio($map)
            );
        }

        $assign = array(
            'total'    => $total,
            'companys' => $companys,
            'info'     => $info
        );
        $this->assign($assign);
        $this->display();
    }

    /**
     * 月日报折线图
     */
    public function getMonthDailyChart(){
        $month = I('month');
        // 获取月份天数、月份开始第一天
        if ($month) {
            $monthN = date("t",strtotime($month));
            $start_time = strtotime($month);
        } else {
            $monthN = date("t");
            $start_time = strtotime(date('Y-m-01'));
        }

        // 获取具体日期
        for($i=0; $i < $monthN; $i++){
            $days[] = $start_time + $i*86400; //每隔一天赋值给数组
        }

        // 日报
        $daily = D('Daily');
        $companyId = I('company_id');
        if ($companyId) {
            $map['company_id'] = $companyId;
        }
        $map['status'] = C('STATUS_Y');
        foreach ($days as $key => $value) {
            $map['start_time'] = array('between', [$value, $value+86400]);
            $actual[] = floatval($daily->getActualTotal($map)); // 实收
        }
        $data = array(
            'xAxis' => $monthN,
            'actual' => $actual,
        );
        echo json_encode($data);
    }

    /**
     * 获取餐品明细图表数据
     */
    public function getMonthDailyDetailsChart(){
        $month = I('month');
        if ($month) {
            $month_start = strtotime($month);
            $month_end = mktime(23, 59, 59, date('m', strtotime($month))+1, 00);
        } else {
            $month_start = mktime(0,0,0,date('m'),1,date('Y'));
            $month_end = mktime(23,59,59,date('m'),date('t'),date('Y'));
        }

        $map = [
            'status' => C('STATUS_Y'),
            'start_time' => array('between', [$month_start, $month_end])
        ];
        $daily = D('Daily');
        $companyId = I('company_id');
        if ($companyId) {
            $map['company_id'] = $companyId;
        }
        $radio = $daily->getDailyDetailsRadio($map);
        $legend = [];
        foreach ($radio as $key => $value) {
            array_push($legend, $key);
            $series[] = [
                'name' => $key,
                'value' => $value
            ];
        }
        $data = [
            'legend' => $legend,
            'series' =>$series
        ];
        echo json_encode($data);
    }

    /**
     * 月支出折线图
     */
    public function getMonthExpensesChart(){
        $month = I('month');
        // 获取月份天数、月份开始第一天
        if ($month) {
            $monthN = date("t",strtotime($month));
            $start_time = strtotime($month);
        } else {
            $monthN = date("t");
            $start_time = strtotime(date('Y-m-01'));
        }

        // 获取具体日期
        for($i=0; $i < $monthN; $i++){
            $days[] = $start_time+$i*86400; //每隔一天赋值给数组
        }

        $expenses = D('Expenses');
        $companyId = I('company_id');
        if ($companyId) {
            $map['company_id'] = $companyId;
        }
        $map['status'] = C('STATUS_Y');
        foreach ($days as $key => $value) {
            $map['spending_time'] = array('between', [$value, $value+86399]);
            $actual[] = floatval($expenses->getExpensesTotal($map));
        }
        $data = array(
            'xAxis' => $monthN,
            'actual' => $actual,
        );
        echo json_encode($data);
    }
}
