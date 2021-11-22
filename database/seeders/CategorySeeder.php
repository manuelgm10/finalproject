<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Income'],
            ['name' => 'Miscellaneous'],
            ['name' => 'Entertainment'],
            ['name' => 'Education'],
            ['name' => 'Shopping'],
            ['name' => 'Personal Care'],
            ['name' => 'Health & Fitness'],
            ['name' => 'Kids'],
            ['name' => 'Food & Dining'],
            ['name' => 'Gifts & Donations'],
            ['name' => 'Investments'],
            ['name' => 'Bills & Utilities'],
            ['name' => 'Auto & Transport'],
            ['name' => 'Travel'],
            ['name' => 'Fees & Charges'],
            ['name' => 'Business Services'],
            ['name' => 'Taxes'],
            ['name' => 'Others'],
        ]);

        Category::factory(5)->create(); //It is only to complete a requirement :)

    }
}
