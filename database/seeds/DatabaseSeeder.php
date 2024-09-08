<?php

use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanDirectories();

        if (App::environment() === 'production') {
            echo ("Production mode seeding \n");
            $this->call($this->getProductionModeSeeders());
        } else {
            echo ("Development mode seeding \n");

            $productionSeeders = $this->getProductionModeSeeders();
            $developmentSeeders = $this->getDevelopmentModeSeeders();

            $seeders = array_merge($productionSeeders, $developmentSeeders);

            $this->call($seeders);
        }
    }

    public function cleanDirectories()
    {
        echo ("Cleaning Directories\n");
        $file = new Filesystem;

        $file->cleanDirectory('storage/app/public/user');
    }

    public function getProductionModeSeeders()
    {
        return [
            TruncateAllTables::class,
            RolesTableSeeder::class,
            UserSeeder::class,
            ProductSeeder::class
        ];
    }

    public function getDevelopmentModeSeeders()
    {
        return [
            CategorySeeder::class,
            WalletSeeder::class
        ];
    }
}
