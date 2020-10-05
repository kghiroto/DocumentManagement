<?php

namespace App;

use DB;

class Dashboard
{
    static public function getNumbersOfActivePassword() {
        $result = DB::table('passwords')
        ->whereRaw('lesson_start_at >  NOW() AND lesson_start_at < NOW() + interval 1 day')
        ->count();
        //->toSql();
        return $result;
    }

}
