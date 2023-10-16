<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_case_get_successfully(): void
    {
        $response = $this->get('/api/products/');

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                [
                    "code",
                    "status",
                    "imported_t",
                    "url",
                    "creator",
                    "created_t",
                    "last_modified_t",
                    "product_name",
                    "quantity",
                    "brands",
                    "categories",
                    "labels",
                    "cities",
                    "purchase_places",
                    "stores",
                    "ingredients_text",
                    "traces",
                    "serving_size",
                    "serving_quantity",
                    "nutriscore_score",
                    "nutriscore_grade",
                    "main_category",
                    "image_url"
                ]
            ]
        ]);
    }
}
