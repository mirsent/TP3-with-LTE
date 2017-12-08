<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 日报model
 */
class DailyModel extends BaseModel{

    protected $_auto=array(
        array('status','get_default_status',1,'callback'),
        array('user_id','get_user_id',1,'callback'),
        array('company_id','get_company_id',1,'callback'),
        array('account_number','get_account_number',1,'callback')
    );

    static function get_user_id(){
        return session(C('SNAME'))['id'];
    }

    static function get_company_id(){
        return session(C('SNAME'))['company_id'];
    }

    static function get_account_number(){
        return date('YmdHms').rand(0,9);
    }



    /**
     * 获取应收总计
     */
    public function getReceivableTotal($map){
        $data = $this
            ->where($map)
            ->sum('receivable');
        return $data?$data:0;
    }

    /**
     * 获取实收总计
     */
    public function getActualTotal($map){
        $data = $this
            ->where($map)
            ->sum('actual');
        return $data?$data:0;
    }

    /**
     * 获取优惠总计
     */
    public function getDiscountTotal($map){
        $data = $this
            ->where($map)
            ->sum('discount');
        return $data?$data:0;
    }

    /**
     * 计算支付方式比例
     */
    public function getPayTypeRadio($map){
        $total = $this->getActualTotal($map);
        $payType = D('PayType')->getPayTypeData();
        foreach ($payType as $key => $value) {
            $map['pay_type_id'] = $value['id'];
            $everyTypeNumber = $this->getActualTotal($map);
            if ($total == 0)
                $radio = 0;
            else
                $radio = round(($everyTypeNumber/$total*100), 2);
            $data[$key] = [
                'pay_type_name' => $value['p_type_name'],
                'money' => $everyTypeNumber,
                'number' => $radio,
                'radio' => $radio.'%'
            ];
        }
        return $data;
    }

    public function getPayTypeRadio1($map){
        $total = $this->getActualTotal($map);
        $dailys = D('Daily')->where($map)->getField('pay_type_id, actual',true);
        foreach ($dailys as $types => $actual) {
            $payTypeArr = explode(',',$types);
            foreach ($payTypeArr as $type_id) {
                $money[$type_id]['money'] =  floatval($money[$type_id]['money']) + $actual;
            }
        }
        $payType = D('PayType')->getPayTypeData();
        foreach ($payType as $key => $value) {
            $everyMoney = $money[$value['id']]['money'];
            // 还没有日报时,比例为0
            if ($total == 0)
                $radio = 0;
            else
                $radio = round(($everyMoney/$total*100), 2);

            $data[$key] = [
                'pay_type_name' => $value['p_type_name'],
                'money' => $everyMoney,
                'number' => $radio,
                'radio' => $radio.'%'
            ];
        }
        return $data;
    }

    /**
     * 获取账单明细占比
     */
    public function getDailyDetailsRadio($map){
        $details = $this
            ->where($map)
            ->getField('details',true);
        foreach ($details as $value) {
            if ($value) $data .= ','.$value;
        }
        $data = explode(',', trim($data,','));
        return array_count_values($data);
    }
}
