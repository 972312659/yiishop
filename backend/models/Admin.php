<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $last_login_time
 * @property string $last_login_ip
 */
class Admin extends \yii\db\ActiveRecord implements IdentityInterface
{
    //验证使用的密码
    public $password_hash_repeat;
    //角色
    public $roles;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
    }

    /**
     * @inheritdoc
     */
//    public function rules()
/*    {
        return [
            [['username', 'password_hash','password_hash_repeat', 'email'], 'required'],
//            [['username','password_hash','email'], 'string', 'max' => 255],
//            [['auth_key'],'string','max'=>32],
//            [['last_login_ip'], 'string', 'max' => 20],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['password_reset_token'], 'unique'],
            [['created_at', 'updated_at', 'last_login_time','auth_key','last_login_ip','status','password_reset_token'],'safe'],
            [['password_hash'],'string','min'=>8],
            [['password_hash'],'compare']//验证密码
        ];
    }*/
    //username password_hash email status password_reset_token
    //last_login_ip last_login_time created_at updated_at  auth_key
    public function rules()
    {
        return [
            [['username', 'password_hash','password_hash_repeat', 'email'], 'required'],
            [['username','email'],'unique'],
            [['email'], 'email'],
            [['password_hash'],'compare'],//验证密码
            [['created_at', 'updated_at', 'last_login_time','auth_key','last_login_ip','status','password_reset_token','roles'],'safe'],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'auth_key' => '自动登录令牌',
            'password_hash' => '确认密码',
            'password_hash_repeat' => '密码',
            'password_reset_token' => '密码重置',
            'email' => 'Email',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
            'last_login_time' => '最后登录时间',
            'last_login_ip' => '最后登陆IP',
            'roles'=>'角色'
        ];
    }
    /**
     * 自动添加时间
     */
    public function behaviors()
    {
        return [
            'inputtime'=>[
                'class'=>TimestampBehavior::className(),
                'attributes'=>[
                    self::EVENT_BEFORE_INSERT => ['created_at'],
                ],
            ],
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::findOne(['id'=>$id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey()==$authKey;
    }
    /**
     * 得到角色选择数组
     */
    public static function rolesOption()
    {
        $roles=Yii::$app->authManager->getRoles();
        return ArrayHelper::map($roles,'name','description');
    }
    /**
     * 根据权限显示菜单列表方法
     */
    public function getMenuItems()
    {
        $menuItems=[];
        foreach(Menu::find()->where(['parent_id'=>0])->all() as $parent){
            $items=[];
            $n=0;//如果大项目下所有都没有权限，则所有都不显示
            foreach($parent->children as $son){
                //有权限才显示
                if(Yii::$app->user->can($son->url)){
                    $items[]=['label'=>$son->name,'url'=>[$son->url]];
                    $n++;
                }
            }
            if($n!=0){
                $menuItems[]=[
                    'label' => $parent->name,
                    'items'=>$items,
                ];
            }
        }
        return $menuItems;
    }

}
