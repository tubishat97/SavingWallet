<?php

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            ['name' => 'كمبريسر هواء', 'quantity' => 5],
            ['name' => 'طابه b2', 'quantity' => 13],
            ['name' => '3b طابه', 'quantity' => 15],
            ['name' => '3b طابه سلم', 'quantity' => 8],
            ['name' => 'كمبريسر هواء راسين', 'quantity' => 2],
            ['name' => 'سنوليد رباعي', 'quantity' => 9],
            ['name' => 'سنوليد ثماني', 'quantity' => 6],
            ['name' => 'كتوات 200 امبير', 'quantity' => 17],
            ['name' => 'ساعه زيت', 'quantity' => 18],
            ['name' => 'ريموات 6 حركات', 'quantity' => 14],
            ['name' => 'ريموات 8 حركات', 'quantity' => 7],
            ['name' => 'ريموات 12 حركه', 'quantity' => 2],
            ['name' => 'ريموات 10 حركات', 'quantity' => 3],
            ['name' => 'ريموات 4 حركات', 'quantity' => 17],
            ['name' => 'ريموات سلك', 'quantity' => 1],
            ['name' => 'نبل كوع نص\\12', 'quantity' => 11],
            ['name' => 'نبل كوع ربع\\6 ميل', 'quantity' => 10],
            ['name' => 'نبل كوع ربع\\\\12', 'quantity' => 23],
            ['name' => 'سدادات مشكل', 'quantity' => 51],
            ['name' => 'تي 12', 'quantity' => 12],
            ['name' => 'فيوزات', 'quantity' => 8],
            ['name' => 'بطاريات', 'quantity' => 9],
            ['name' => 'براشر سوتش', 'quantity' => 20],
            ['name' => '2b طابه سلم', 'quantity' => 10],
        ];

        foreach ($products as $data) {
            $product = new Product();
            $product->name = $data['name'];
            $product->save();

            $product->increment('quantity', $data['quantity']);
        }
    }
}
