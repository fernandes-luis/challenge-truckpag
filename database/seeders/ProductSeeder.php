<?php

namespace Database\Seeders;

use App\Models\Product;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            $json = Storage::disk('local')->get('products.json');
            $products = json_decode($json, true);
            $products[0]['imported_t'] = new DateTime($products[0]['imported_t']);
            Product::create($products[0]);
        });
    }
}
