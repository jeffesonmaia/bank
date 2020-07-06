<?php

use App\Models\Agency;
use Illuminate\Database\Seeder;

class AgencySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Agency::class, 2)->create()->make();
    }
}
