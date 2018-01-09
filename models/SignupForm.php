<?php
namespace app\models;

use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $cellphone;
    public $password;

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'username' => '用户名',
            'cellphone' => '手机号码',
            'password' => '登录密码',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => '用户名已经被占用.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['cellphone', 'trim'],
            ['cellphone', 'required'],
            ['cellphone', 'string', 'length' => 11],
            ['cellphone', 'unique', 'targetClass' => '\app\models\User', 'message' => '手机号码已经被占用.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->cellphone = $this->cellphone;
        $user->setPassword($this->password);
        //添加用户登录token
        $user->generateAuthKey();
        $user->generateAccessToken();
        $user->expired_at = time()+3600*24;
        
        return $user->save() ? $user : null;
    }
}
