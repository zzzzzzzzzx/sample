<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Faker\Factory;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }


    public function create()
    {

        // 使用 factory 来创建一个 Faker\Generator 实例
        // $faker = \Faker\Factory::create();
        // var_dump($faker);
        // // 生成用户名
        // echo $faker->name; // "Janie Roob"

        // // 生成安全邮箱
        // echo $faker->safeEmail; // "claire.wuckert@example.net"

        // // 生成随机日期
        // echo $faker->date; // "2011-02-10"

        // // 生成随机时间
        // echo $faker->time; // "13:03:55"
        return view('sessions.create');
    }


    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            session()->flash('success', '欢迎回来!');
            return redirect()->intended(route('users.show', [Auth::user()]));
        } else {
            session()->flash('danger', '很抱歉, 您的邮箱和密码不匹配');
            return redirect()->back()->withInput();
        }
    }


    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已成功退出!');
        return redirect('login');
    }
}