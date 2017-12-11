<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 支付方式model
 */
class PayTypeModel extends BaseModel{

    protected $_auto=array(
        array('status','get_default_status',1,'callback')
    );

    /**
     * 获取支付类型
     * @return arr 支付类型数组
     */
    public function getPayTypeData(){
        $data = $this
            ->where(['status'=>C('STATUS_Y')])
            ->select();
        return $data;
    }

    /**
     * 获取支付类型dt数据
     */
    public function getDataForDt(){
        $data = $this
            ->where(['status'=>array('neq',C('STATUS_N'))])
            ->select();
        return $data;
    }

}
