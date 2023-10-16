<?php

namespace App\Repositories;

use App\Models\ImportHistory;
use Illuminate\Support\Facades\DB;

class ImportHistoryRepository
{

    public function getAllFiles()
    {
        return DB::transaction(function (){
            return ImportHistory::all();
        });
    }
    public function addFiles(array $productsFiles)
    {
        foreach ($productsFiles as $productFile) {
            ImportHistory::create(['file_name' => $productFile,
                                   'record_count' => 0]);
        };
        return true;
    }

    public function updateRecordCount($importHistory, $status)
    {
        return $importHistory->update(['record_count' => $status]);
    }
  
}