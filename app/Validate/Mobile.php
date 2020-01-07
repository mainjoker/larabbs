<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/1/6
 * Time: 8:45
 */

namespace App\Validate;

class Mobile
{
    public function validate($attribute,$value,$parameters,$validator)
    {
        $rule='/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199)\d{8}$/';
        return preg_match($rule, $value);
    }

}