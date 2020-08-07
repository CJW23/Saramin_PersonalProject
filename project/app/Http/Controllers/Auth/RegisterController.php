<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Logic\EncryptionModule;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    private $encrypt;
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->encrypt = new EncryptionModule();
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        //검증하기 전에 email을 암호하 진행

        $data['email'] = EncryptionModule::encrypt($data['email']);
        $message = [
            'name.max' => '10자이하로 입력하세요',
            'password.regex' => '8-15자 숫자+영문+특수문자 비밀번호를 입력하세요',
            'password.min' =>'8-15자 숫자+영문+특수문자 비밀번호를 입력하세요',
            'password.max' => '8-15자 숫자+영문+특수문자 비밀번호를 입력하세요',
            'password.confirmed' => '비밀번호가 같지 않습니다',
            'email.unique' => '이미 이메일이 존재합니다',
            'nickname.unique' => '이미 닉네임이 존재합니다'
        ];
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:10'],
            'email' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'max:15', 'confirmed', 'regex:/(?=.*\d{1,50})(?=.*[~`!@#$%\^&*()-+=]{1,50})(?=.*[a-zA-Z]{2,50}).{8,50}$/'],
            'nickname' => ['required', 'string', 'max:10', 'unique:users'],
        ], $message);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => EncryptionModule::encrypt($data['email']),
            'phone' => encrypt($data['phone']),
            'nickname' =>$data['nickname'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
