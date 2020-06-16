<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        
        $user->name = 'Администратор';
        $user->email = 'admin@admin.ru';
        $user->password = Hash::make('admin');
        $user->role = 'admin';

        $user->save();
    }
}
