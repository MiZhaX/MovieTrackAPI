<?php

namespace App\Filters;

use Illuminate\Http\Request;

class ApiFilter
{

    protected $safeParams = [];
    protected $columnMap = [];
    protected $operatorMap = [];

    public function transform(Request $request, $query = null)
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
