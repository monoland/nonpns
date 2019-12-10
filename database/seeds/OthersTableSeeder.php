<?php

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Verificator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OthersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $verificator = Verificator::create([
            'nip' => '197907172011011004',
            'name' => 'Ahmad Satori, SP',
            'slug' => Str::slug('Ahmad Satori, SP'),
        ]);

        $user = new User([
            'name' => 'Ahmad Satori, SP',
            'email' => '197907172011011004',
            'password' => Hash::make('54321'),
            'authent_id' => 3,
        ]);

        $verificator->user()->save($user);
    }
}
