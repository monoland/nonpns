<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // $this->call(FixSchoolBranchSeeder::class);

        // $this->call(AuthentsTableSeeder::class);
        // $this->call(SettingsTableSeeder::class);
        // $this->call(EducationsTableSeeder::class);
        // $this->call(SubjectsTableSeeder::class);
        // $this->call(BranchsTableSeeder::class);
        // $this->call(CitiesTableSeeder::class);
        // $this->call(SchoolsTableSeeder::class);
        // $this->call(TeachersTableSeeder::class);
        // $this->call(UsersTableSeeder::class);

        // $this->call(SKhSeeder::class);
        // $this->call(SMASeeder::class);
        // $this->call(SMKSeeder::class);

        // $this->call(UrgentSeeder::class);
        // $this->call(KCDLebakUpdateSeeder::class);
        // $this->call(KCDPandeglangUpdateSeeder::class);
        // $this->call(KCDSeragonUpdateSeeder::class);
        // $this->call(KCDKabtangUpdateSeeder::class);
        // $this->call(KCDKotangselUpdateSeeder::class);
        $this->call(RecapAllKCD::class);
    }
}
