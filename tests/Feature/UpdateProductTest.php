<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_case_update_successfully(): void
    {
        $product = Product::first();
        $response = $this->put(route("products.update", $product->getKey()),[
            "labels" => "teste",
			"cities" => "Guanambi",
			"purchase_places" => "Brasil",
        ]);

        $response->assertStatus(200)->assertJsonStructure([
                'message',
                'success',
                'code',
                'product'
        ]);

        $this->assertDatabaseHas('products',[
            "code" => $product->code,
            "labels" => "teste",
			"cities" => "Guanambi",
			"purchase_places" => "Brasil",
        ]);
    }
}
