<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 用途model
 */
class CompanyModel extends BaseModel{

    protected $_auto=array(
        array('status','get_default_status',1,'callback')
    );

    public function getCompanyData(){
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

    /**
     * 根据公司id(1,2)获取名称(公司1;公司2)
     * @param  string $companyIds 公司id,以 ',' 隔开
     * @return string             公司名称,以 ';' 隔开
     */
    public function getCompanysByIds($companyIds){
        foreach (explode(',', $companyIds) as $v) {
            $arr.= $this->getFieldById($v, 'company_name').';';
        }
        return trim($arr, ';');
    }

}
