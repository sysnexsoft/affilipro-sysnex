<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\WebSetting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $user = User::find(1);
        if (!$user){
            $user = new User();
            $user->name = "Super Admin";
            $user->email = "admin@gmail.com";
            $user->password = bcrypt("123456");
            $user->save();
        }



        $this->call([PermissionSeeder::class]);
    }
}
