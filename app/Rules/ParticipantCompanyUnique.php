<?php

namespace App\Rules;

use App\Manager\CompanyManager;
use App\Tenant\ManagerTenant;
use Closure;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ParticipantCompanyUnique implements Rule
{
    private $table, $column, $columnValue;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($table, $columnValue = null, $column = 'id')
    {
        $this->table = $table;
        $this->column = $column;
        $this->columnValue = $columnValue;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $companyManager = new CompanyManager();
        $companyReturn = $companyManager->getCompanyIdentify();
        $contractReturn = $companyManager->getContractDefault();

        $result = DB::table($this->table)
            ->where($attribute, $value)
            ->where('company_id', $companyReturn)
            ->where('contract_id', $contractReturn)
            ->first();

        if ($result && $result->{$this->column} == $this->columnValue){
            return true;
        }

        return is_null($result);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O Valor para :attribute ja está em uso !';
    }
}
