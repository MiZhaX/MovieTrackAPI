<?php
namespace App\Filters;
use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class ProduccionFilter extends ApiFilter {

    protected $safeParams = [
        'titulo' => ['eq', 'like'],
        'titulo_original' => ['eq', 'like'],
        'tipo' => ['eq'],
        'genero_id' => ['eq'],
        'duracion' => ['eq', 'gt', 'lt'],
        'fecha_estreno' => ['eq', 'gt', 'lt'],
        'puntuacion_critica' => ['eq', 'gt', 'lt'],
        'puntuacion_usuarios' => ['eq', 'gt', 'lt']
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