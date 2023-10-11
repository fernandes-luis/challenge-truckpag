<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct() {
        $this->productRepository = new ProductRepository;
    }
    public function index() {
        return $this->productRepository->getAllProductsPaginate(15);
    }

    public function update(int $code, Request $request) {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->getProductByCode($code);
            $this->productRepository->updateProduct($product, $request->all());
            DB::commit();
            $response = [
                'message' => 'Produto atualizado com sucesso',
                'success' => true,
                'code' => 201,
                'product' => $product
            ];
            return $response;
        } catch (\Exception $e) {
            DB::rollback();
            return $e->getMessage();
        }

    }

    public function show(int $code) {
        try {
            $product = $this->productRepository->getProductByCode($code);
            return $product;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(Request $request) {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->storeProducts($request->all());
            DB::commit();
            $response = [
                'message' => 'Produto cadastrado com sucesso',
                'success' => true,
                'code' => 201,
                'product' => $product
            ];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return $response;
    }

    public function destroy(int $code) {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->getProductByCode($code);
            $this->productRepository->deleteProduct($product);
            $response = [
                'message' => 'Produto deletado',
                'success' => true,
                'code' => 204
            ];
            DB::commit();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return $response;
    }
}
