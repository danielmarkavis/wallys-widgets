<?php

namespace Database\Seeders;

use App\Models\Widget;
use Illuminate\Database\Seeder;

class WidgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Widget::factory(['size' => 250])->create();
        Widget::factory(['size' => 500])->create();
        Widget::factory(['size' => 1000])->create();
        Widget::factory(['size' => 2000])->create();
        Widget::factory(['size' => 5000])->create();
    }
}
