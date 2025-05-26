<?php
namespace App\Filters;
use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class MarcarProduccionesFilter extends ApiFilter {

    protected $safeParams = [
        'usuario_id' => ['eq'],
        'produccion_id' => ['eq'],
        'marca' => ['eq'],
        'favorita' => ['eq']
    ];
    protected $columnMap = [];
    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>='
    ];

}