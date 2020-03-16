<?php

use Illuminate\Database\Seeder;
use \App\Name;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Name::class, 50)->create();
    }
}
