<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultCategories = [
            'Housing',
            'Transportation',
            'Food',
            'Utilities',
            'Insurance',
            'Medical & Healthcare',
            'Saving, Investing, & Debt Payments',
            'Personal Spending'
        ];

        foreach ($defaultCategories as $categoryName) {
            $category = new Category();
            $category->name = $categoryName;
            $category->save();
        }
    }
}
