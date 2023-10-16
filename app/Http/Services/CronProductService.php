<?php

namespace App\Http\Services;

use App\Repositories\ImportHistoryRepository;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Repositories\ProductRepository;
use Illuminate\Support\Facades\Storage;

class CronProductService
{

    public function __construct(
        private readonly ImportHistoryRepository $importHistoryRepository,
        private readonly ProductRepository $productRepository
    )
    {

    }

    public function requestApi()
    {
        $config = config('productcron');
        return HTTP::get($config['data_files_url'])->body();
    }

    public function addProducts(array $products)
    {
        $newProducts = [];
        foreach ($products as $product) {
            $productsDataBase = $this->importHistoryRepository->getAllFiles()->pluck('file_name')->toArray();
            if (in_array($product, $productsDataBase)) continue;
            $newProducts[] = $product;
        }
        array_pop($newProducts);
        return $this->importHistoryRepository->addFiles($newProducts);
    }

    public function addFile()
    {
        $productsDataBase = $this->importHistoryRepository->getAllFiles();
        $productsDataBase->map(function ($file) {
            
            if ($file->record_count != 0) return;
            
            $this->downloadFile($file);
            $response = $this->writeFile($file);
            $this->saveData($response);
            $this->updateFile($file, 1);
            $this->deleteFile($file);
        });

        $productsDataBase->map(function ($file) {
            $this->updateFile($file, 0);
        });

    }

    private function downloadFile($product)
    {
        $config = config('productcron');
        $fileUrl = $config['data_base_url'] . $product->file_name;
        $guzzleClient =  new Client();
        $response = $guzzleClient->get($fileUrl);
        $storageDisk = Storage::disk('local');
        $storageDisk->put($product->file_name, $response->getBody()->getContents());
    }

    private function writeFile($file)
    {
        $config = config('productcron');
        $gzippedData = gzdecode(Storage::disk('local')->get($file['file_name']));
        $objects = preg_split('/(?<=})\s*,\s*(?={)/', $gzippedData);
        $objects = explode("\n", $objects[0]);
        $i = 0;
        $response = [];

        foreach ($objects as $index => $jsonObject) {
            if ($i >= $config['import_limit']) {
                break;
            }
            $jsonObject = trim($jsonObject);
            $data = json_decode($jsonObject, true);
            if (!empty($data)) {
                $response[$index] = $this->arrangeDataToSave($data);
                $i++;
            }
        }
        return $response;
    }

    private function saveData($response)
    {
        foreach ($response as $product) {
            DB::transaction(function () use ($product) {
                $this->productRepository->storeProducts($product);
            });
        }
    }

    private function updateFile($file, $status)
    {
        DB::transaction(function () use ($file, $status) {
            $this->importHistoryRepository->updateRecordCount($file, $status);
        });
    }

    private function deleteFile($file)
    {
        Storage::disk('local')->delete($file['file_name']);
    }

    private function arrangeDataToSave($product)
    {
        $data = [
            "code" => str_replace('"', "", $product['code']),
            "status" => "published",
            "imported_t" => now()->format('Y-m-d H:i:s'),
            "url" => $product['url'],
            "creator" => $product['creator'],
            "created_t" => $product['created_t'],
            "last_modified_t" => $product['last_modified_t'],
            "product_name" => $product['product_name'],
            "quantity" => $product['quantity'],
            "brands" => $product['brands'],
            "categories" => $product['categories'],
            "labels" => $product['labels'],
            "cities" => $product['cities'],
            "purchase_places" => $product['purchase_places'],
            "stores" =>  $product['stores'],
            "ingredients_text" => $product['ingredients_text'],
            "traces" => $product['traces'],
            "serving_size" => $product['serving_size'],
            "serving_quantity" => $product['serving_quantity'] ?: null,
            "nutriscore_score" => $product['nutriscore_score'] ?: null,
            "nutriscore_grade" => $product['nutriscore_grade'],
            "main_category" => $product['main_category'],
            "image_url" => $product['image_url']
        ];
        return $data;
    }

}