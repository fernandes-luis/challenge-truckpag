<?php

namespace App\Console\Commands;

use App\Http\Services\CronProductService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CronProduct extends Command
{
    public function __construct(
        private readonly CronProductService $cronProductService
    )
    {
        parent::__construct();
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar dados do Open Food Facts uma vez ao dia';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $files = explode("\n", $this->cronProductService->requestApi());
            $this->cronProductService->addProducts($files);
            $this->cronProductService->addFile();
            return Log::info('Cron products executado com sucesso em: ' . now());
        } catch (\Throwable $th) {
            return Log::info(json_encode(get_defined_vars()));
        }
       
    }
}