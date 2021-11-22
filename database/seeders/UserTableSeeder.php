<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;

        $user->name = 'Admin';
        $user->email = 'admin@example.com';
        $user->assignRole('admin');
        $user->status = 'active';
        $user->group = 'admin';
        $user->password = Hash::make('admin12345');
        $user->available_chars = config('tts.free_chars');
        $user->email_verified_at = now();
        $user->job_role = 'Administrator';
        $user->save();
    }
}
