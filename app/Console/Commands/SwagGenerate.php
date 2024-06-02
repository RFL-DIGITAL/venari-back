<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SwagGenerate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swag:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Генерация Swagger-файла';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $p = @\OpenApi\Generator::scan([app_path()]);
        print_r($p->toJson());
        file_put_contents(__DIR__.'/../../../public/build/swag.json',$p->toJson());
        file_put_contents(__DIR__.'/../../../swag.yaml',$p->toYaml());

        return 0;
    }
}
