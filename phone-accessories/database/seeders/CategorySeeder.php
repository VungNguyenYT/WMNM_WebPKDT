<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;

DB::table('categories')->insert([
    ['name' => 'Ốp lưng'],
    ['name' => 'Kính cường lực'],
    ['name' => 'Cáp sạc'],
    ['name' => 'Pin dự phòng'],
    ['name' => 'Tai nghe'],
]);
