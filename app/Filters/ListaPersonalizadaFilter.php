<?php
namespace App\Filters;
use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class ListaPersonalizadaFilter extends ApiFilter {

    protected $safeParams = [
        'id' => ['eq'],
        'nombre' => ['eq'],
        'usuario_id' => ['eq']
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