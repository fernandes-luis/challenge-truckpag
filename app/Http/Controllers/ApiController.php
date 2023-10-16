<?php

namespace App\Http\Controllers;

use App\Models\ImportHistory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ApiController extends Controller
{
    public function apiDetails()
    {
        try {
            DB::connection()->getPdo();
            $databaseStatus = "Conexão com a base de dados OK";
        } catch (\Exception $e) {
            $databaseStatus = "Erro na conexão com a base de dados: " . $e->getMessage();
        }

        $updateCron = ImportHistory::find(1);

        $lastCronRun = $updateCron->updated_at->format('Y-m-d H:i');

        $uptime = Cache::get('uptime', 'Não disponível');

        $memoryUsage = memory_get_usage();

        return [
            'database_status' => $databaseStatus,
            'last_cron_run' => $lastCronRun,
            'uptime' => $uptime,
            'memory_usage' => $memoryUsage,
        ];
    }

}
