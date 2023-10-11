<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProductCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Os produtos foram atualizados com sucesso';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
    }
}
