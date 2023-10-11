<?php

namespace App\Repositories;

use App\Models\Product;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ProductRepository 
{
    public function getAllProducts() {
        return Product::all();
    }

    public function getAllProductsPaginate(int $paginate) {
        return Product::paginate($paginate);
    }

    public function getProductByCode(int $code) {
        $product = Product::find($code);
        throw_if(empty($product), new BadRequestException('Não foi encontrado nenhum produto'), 404);
        return $product;
    }

    public function updateProduct(Product $product, array $data) {
        return $product->update($data);
    }

    public function storeProducts(array $data) {
        return Product::create($data);
    }

    public function deleteProduct(Product $product) {
        return $product->delete();
    }
}

?>