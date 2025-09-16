<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Models\Empresas;
use Illuminate\Console\Command;

class AlterTableUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:alter-table-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $companiesDB = Company::query()->get();

        foreach ($companiesDB as $itemCompany) {
            $empresa = Empresas::query()->where('fantasy_name', 'like', '%'.$itemCompany['fantasy_name'].'%')->first();
            if($empresa) {
                $itemCompany->email = $empresa['email'];
                $itemCompany->phone = $empresa['phone'];
                $itemCompany->employer_number= $empresa['employer_number'];
                $itemCompany->save();
            }
        }
    }
}
