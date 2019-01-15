<?php

namespace app\admin\model;

use think\Model;

class Member extends Model
{
    // 表名
    protected $name = 'member';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    
    // 追加属性
    protected $append = [
        'position_text',
        'logintime_text'
    ];
    

    
    public function getPositionList()
    {
        return ['ios' => __('Ios'),'android' => __('Android'),'后端' => __('后端'),'前端' => __('前端'),'UI工程师' => __('Ui工程师')];
    }     


    public function getPositionTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['position']) ? $data['position'] : '');
        $valueArr = explode(',', $value);
        $list = $this->getPositionList();
        return implode(',', array_intersect_key($list, array_flip($valueArr)));
    }


    public function getLogintimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['logintime']) ? $data['logintime'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setPositionAttr($value)
    {
        return is_array($value) ? implode(',', $value) : $value;
    }

    public function getGenderList()
    {
        return ['1' => __('Male'), '0' => __('Female')];
    }

    public function getStatusList()
    {
        return ['normal' => __('Normal'), 'hidden' => __('Hidden')];
    }

    public function getPrevtimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['prevtime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getJointimeTextAttr($value, $data)
    {
        $value = $value ? $value : $data['jointime'];
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }

    protected function setPrevtimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setLogintimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    protected function setJointimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    public function group()
    {
        return $this->belongsTo('MemberGroup', 'group_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
