<?php
namespace Common\Model;
use Common\Model\BaseModel;
/**
 * 权限规则model
 */
class AuthRuleModel extends BaseModel{

	/**
	 * 获取权限规则列表
	 */
	public function getAuthRuleList(){
		$map['status'] = C('STATUS_Y');
		$data = $this
			->where($map)
			->getField('name', true);
		return $data;
	}

}
