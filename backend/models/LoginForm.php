<?php
/**
 * Created by PhpStorm.
 * User: 邓伟
 * Date: 2017/4/2
 * Time: 8:39
 */

namespace backend\models;


use yii\base\Model;

class LoginForm extends Model
{
    //表单字段
    public $username;//用户名
    public $password;//密码
//    public $captchaCode;//验证码
    //自动登录
    public $rememberMe=true;
    public $my;

    /**
     * 验证规则
     * @return array
     */
    public function rules()
    {
        return [
            [['username','password'],'required'],
            [['rememberMe'],'boolean'],
            [['my'],'self'],
//            [['captchaCode'],'captcha']
        ];
    }
    /**
     * 自定义验证规则  测试
     * 当my==1时，报错
     */
    public function self($attribute)
    {
        if($this->my==1){
            return $this->addError($attribute,'千万不能为空');
        }

    }
    /**
     * 字段名
     */
    public function attributeLabels()
    {
        return [
            'username'=>'账号',
            'password'=>'密码',
            'rememberMe'=>'记住密码'
//            'captchaCode'=>'验证码'
        ];
    }
    /**
     * 验证登录
     */
    public function login()
    {
        if($this->validate()){
            //有邮箱的正则表达式来判断是用邮箱登录还是用户名
            if(preg_match('/^\w+([.-]\w+)*@\w+([.-]\w+)*\.\w+([.-]\w+)*/',$this->username)){
                //根据邮箱找到用户
                $admin=Admin::findOne(['email'=>$this->username]);
                //判断用户是否存在
                if(!$admin){
                    $this->addError('username','邮箱错误或用户不存在');
                    return false;
                }
            }else{
                //根据用户名
                $admin=Admin::findOne(['username'=>$this->username]);
                //判断用户是否存在
                if(!$admin){
                    $this->addError('username','用户名不存在');
                    return false;
                }
            }
            //判断用户密码是否正确
            if(!\Yii::$app->security->validatePassword($this->password,$admin->password_hash)){
                $this->addError('password','密码错误');
                return false;
            }

            //验证成功
            \Yii::$app->user->login($admin,$this->rememberMe ? 3600*24*30 : 0);
            //记录登录时间和IP
            $admin->last_login_ip=\Yii::$app->request->getUserIP();
            $admin->last_login_time=time();
            $admin->password_hash=$admin->password_hash_repeat=$admin->password_hash;
            /*//token
            $admin->auth_key=\Yii::$app->request->getCsrfToken();*/
            $admin->save();
            return true;
        }
    }
}