<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Password;

class PasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function getShow(Request $request, $urlKey)
    {
        $password = Password::getPasswordByUrlKey($urlKey);
        return view('password.show', [ 'password' => $password]);
    }

    public function getList(Request $request)
    {
        $passwords = Password::getPasswords();

        return view('password.list', [ 'passwords' => $passwords]);
    }

    public function getCreateInput(Request $request)
    {
        return view('password.create-input');
    }

    public function postCreateConfirm(Requests\PasswordCreateRequest $request)
    {
        // 戻るボタンの処理
        if ($request->get('from') == "confirm") {
            return redirect('password/create-input')->withInput();
        }

        $password = $request->all();
        return view('password.create-confirm', ['password' => $password]);
    }

    public function postCreateFinish(Requests\PasswordCreateRequest $request)
    {
        $password = $request->all();
        $password['lesson_start_at'] = $password['lesson_start_date'] . ' ' . $password['lesson_start_time']; // つなげる 
        $password['url_key'] = Password::generateUrlKey();

        Password::create($password);

        // ブラウザリロード等での二重送信防止
        $request->session()->regenerateToken();
        return view('password.create-finish', []);
    }

    public function getEditInput(Request $request, $id)
    {
        // ミドルウェアでキーワードデータに対する認可設定を作る @todo
        $password = Password::getPasswordbyId($id);
        list($lessonStartDate, $lessonStartTime) =  explode(' ', $password->lesson_start_at);
        $password->lesson_start_date = $lessonStartDate; 
        $password->lesson_start_time = substr($lessonStartTime, 0, strlen($lessonStartTime) - 3);
        return view('password.edit-input', ['password' => $password]);
    }

    public function postEditConfirm(Requests\PasswordEditRequest $request)
    {
        // 戻るボタンの処理
        if ($request->get('from') == "confirm") {
            return redirect()->route('password/edit-input', ['id' => $request->get('id')])->withInput();
        }

        $password = $request->all();
        return view('password.edit-confirm', ['password' => $password]);
    }

    public function postEditFinish(Requests\PasswordEditRequest $request)
    {
        $password = $request->all();
        $password['lesson_start_at'] = $password['lesson_start_date'] . ' ' . $password['lesson_start_time']; // つなげる
        Password::find($password['id'])->fill($password)->save();
        // ブラウザリロード等での二重送信防止
        $request->session()->regenerateToken();
        return view('password.edit-finish', []);
    }
}
