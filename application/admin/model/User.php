<?php

namespace app\admin\model;

use think\Model;
use think\model\concern\SoftDelete;

class User extends Model
{
    use SoftDelete;

    public function isLogin()  //返回登录用户名
    {
        return session('?user');
    }

    public function logout()  //退出登录  将session中的用户名制空
    {
        if ($this->isLogin())
        {
            session('user', null);
        }
    }

    public function formatPassword($password)  //将密码md5编码
    {
        return md5($password);
    }

    public function getId()  //返回用户id
    {
        return session('user.id');
    }

    public function login($username, $password)  //判断是否登录 用model/User的verifier()方法来进行登录信息的验证
    {
        $userValidate = new \app\admin\validate\User();
        $isLoginDataAright = $userValidate->scene('login')->check([
            'username'  => $username,
            'password'  => $password
        ]);
        if (false == $isLoginDataAright) { throw new \Exception($userValidate->getError(), 1);}

        $user = $this->verifier($username, $password);
        if(false ==  $user) {
            throw new \Exception('用户名或密码错误');
        }
        session('user', [
            'id'        => $user->id,
            'username'  => $user->username,
        ]);
    }

    public function getInfo()  //返回用户id与用户名
    {
        $user = $this->find(session('id'));
        return [
            'id'        => $user->id,
            'username'  => $user->username,
        ];
    }

    private function verifier($username, $password)  //验证登录的合法性
    {
        $user = $this->where('username', $username)->find();
        if(isset($user) && $user->password === $this->formatPassword($password)) return $user;
        return false;
    }
}
