<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemsTask;

class ItemsTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ItemsTask::factory(20)->create();
    }
}
