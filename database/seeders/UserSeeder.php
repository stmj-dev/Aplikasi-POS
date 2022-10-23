<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = ['admin','zidan'];
        foreach($arr as $a => $val){
            $user = new User();
            $user->name = $val;
            $user->email = $val . '@gmail.com';
            $user->password = Hash::make($val);
            $user->save();
        }
    }
}
