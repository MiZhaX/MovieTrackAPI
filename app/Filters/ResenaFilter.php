<?php
namespace App\Filters;
use App\Filters\ApiFilter;

class ResenaFilter extends ApiFilter {

    protected $safeParams = [
        'usuario_id' => ['eq'],
        'produccion_id' => ['eq'],
        'puntuacion' => ['eq', 'gt', 'lt']
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