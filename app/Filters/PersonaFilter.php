<?php
namespace App\Filters;
use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class PersonaFilter extends ApiFilter {

    protected $safeParams = [
        'nombre' => ['eq', 'like'],
        'fecha_nacimiento' => ['eq', 'gt', 'lt']
    ];
    protected $columnMap = [];
    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'like' => 'like'
    ];
}