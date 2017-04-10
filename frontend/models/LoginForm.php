<?php
/**
 * Created by PhpStorm.
 * User: 邓伟
 * Date: 2017/4/9
 * Time: 15:05
 */

namespace frontend\models;


use yii\base\Model;

class LoginForm extends Model
{
    //定义字段
    public $username;
    public $password;
    public $captcha;
    public $remember=true;

    public function rules()
    {
        return [
            [['username','password'],'required'],
            [['captcha'],'captcha'],
            [['remember'],'boolean']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username'=>'用户名：',
            'password'=>'密码：',
            'captcha'=>'验证码：',
            'remember'=>'保存登录信息'
        ];
    }

    /**
     * 验证登录
     */
    public function login()
    {
        //判断用户是否存在
        $user=Member::findOne(['username'=>$this->username]);
        if(!$user){
            $this->addError($this->username,'用户不存在');
            return false;
        }
        //判断用户密码是否正确
        if(!\Yii::$app->security->validatePassword($this->password,$user->password_hash)){
            $this->addError($this->password,'密码不正确');
            return false;
        }
        //保存用户信息
        if(\Yii::$app->user->login($user,$this->remember ? 3600*24*30 : 0)){
            //更新用户登录信息
            $user->last_login_ip=ip2long(\Yii::$app->request->getUserIP());
            $user->last_login_time=time();
            return $user->save(false);
        }
        return false;
    }

}