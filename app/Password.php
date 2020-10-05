<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Password extends Model
{
    //
    protected $fillable = [
        'lesson_name', 'lesson_start_at' ,'lesson_password', 'url_key',
    ];


    static public function generateUrlKey() {
        return uniqid(rand());
    }

    static public function getPasswords(){
        $passwords = DB::table('passwords')
        ->select('*')
        //降順に並べ替え
        ->orderBy('lesson_start_at','desc')
        //1ページに10件ずつ表示
        ->paginate(config('my.rows_of_passwords_list'));

        return $passwords;
    }

    static public function getPasswordByUrlKey($urlKey) {
        $result = DB::table('passwords')
        ->where('url_key', $urlKey)
        ->first();

        return $result;
    }

    static public function getPasswordbyId($passwordId) {
        $result = DB::table('passwords')
        ->where('id', $passwordId)
        ->first();

        return $result;
    }

    static public function existsPassword($urlKey) {
        $result = DB::table('passwords')
        ->where('url_key', $urlKey)
        ->count();
        //var_dump($result);
        return $result > 0;
    }
}
