<?php

namespace Database\Seeders;

use App\Enums\ProfileTypeEnum;
use App\Models\{Profile, User};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{DB, Hash};

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $password = 'aranD0m||password';
            $user = User::create([
                'name' => 'Phigz Admin',
                'email' => 'admin@phigz.com',
                'username' => 'admin',
                'password' => Hash::make($password)
            ]);

            Profile::create([
                'user_id' => $user->id,
                'phone' => '2349012345678',
                'dob' => '02/11/1960',
                'state' => 'Lagos',
                'gender' => 'male',
                'type' => ProfileTypeEnum::ADMIN->value
            ]);
        });
    }
}
