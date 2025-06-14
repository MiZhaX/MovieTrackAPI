<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter
{

    protected $safeParams = [];
    protected $columnMap = [];
    protected $operatorMap = [];

    public function transform(Request $request) {
        $query = [];

        foreach ($this->safeParams as $param => $operators) {
            $value = $request->query($param);
            if (!isset($value)) {
                continue;
            }

            $column = $this->columnMap[$param] ?? $param;

            foreach ($operators as $operator) {
                if (!isset($value[$operator])) {
                    continue;
                }

                $operatorSymbol = $this->operatorMap[$operator];

                if ($column === 'nombre' && $operatorSymbol === 'like') {
                    $query[] = ['nombre', 'like', '%' . $value['like'] . '%'];
                } else {
                    $filterValue = $operatorSymbol === 'like'
                        ? '%' . $value[$operator] . '%'
                        : $value[$operator];
                    $query[] = [$column, $operatorSymbol, $filterValue];
                }
            }
        }

        return $query;
    }

    public function transformProduction(Request $request, $query = null)
    {
        foreach ($this->safeParams as $parm => $operators) {
            $value = $request->query($parm);
            if (!isset($value)) {
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;

            foreach ($operators as $operator) {
                if (!isset($value[$operator])) {
                    continue;
                }

                $operatorSymbol = $this->operatorMap[$operator];

                // Filtro para el titulo de las producciones
                if ($column === 'titulo' && $operatorSymbol === 'like') {
                    $query->where(function ($subquery) use ($value, $operatorSymbol) {
                        $likeValue = '%' . $value['like'] . '%';
                        $subquery->where('titulo', $operatorSymbol, $likeValue)
                            ->orWhere('titulo_original', $operatorSymbol, $likeValue);
                    });
                } else {
                    $filterValue = $operatorSymbol === 'like'
                        ? '%' . $value[$operator] . '%'
                        : $value[$operator];

                    $query->where($column, $operatorSymbol, $filterValue);
                }
            }
        }

        return $query;
    }
}
