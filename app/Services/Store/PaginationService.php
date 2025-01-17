<?php

namespace App\Services\Store;


use Illuminate\Pagination\LengthAwarePaginator;

class PaginationService
{
    public function paginate($query, int $perPage = 30, int $page = 1): LengthAwarePaginator
    {
        $total = (clone $query)->distinct('p.id')->count('p.id');
        $offset = ($page - 1) * $perPage;
        $data = $query->limit($perPage)->offset($offset)->get()->map(fn($item) => (array) $item);

        return new LengthAwarePaginator(
            $data,
            $total,
            $perPage,
            $page,
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );
    }
}
