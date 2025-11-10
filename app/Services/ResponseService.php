<?php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ResponseService
{
    public function success(int $code, string $message, $data = [], $extra = [])
    {
        return response()->json([
            'data'    => $data,
            'error'   => null,
            'errors'  => null,
            'extra'   => $extra
        ], $code);
    }

    public function successPaginated(LengthAwarePaginator $paginator, string $message = 'Retrieved successfully', int $code = 200)
    {
        $total = [];
        foreach ($paginator->items() as $item) {
            $currency = $item->currency;
            $amount = $item->amount;

            $total[$currency] = isset($total[$currency]) ? $total[$currency] + $amount : $amount;
        }

        return response()->json([
            'data' => $paginator->items(),
            'total' => $total,
            'error' => null,
            'errors' => null,
            'extra' => [
                'meta' => [
                    'current_page' => $paginator->currentPage(),
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                    'last_page' => $paginator->lastPage(),
                ]
            ]
        ], $code);
    }

    public function error(int $code, string $message, $errors = [], $extra = [])
    {
        return response()->json([
            'data'    => null,
            'error'   => $message,
            'errors'  => $errors,
            'extra'   => $extra
        ], $code);
    }
}
