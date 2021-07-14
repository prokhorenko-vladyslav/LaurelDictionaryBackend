<?php


namespace App\Traits;


trait PaginationFromLimit
{
    public function getPerPage(): int
    {
        $limit = request()->query('limit');
        return is_numeric($limit) && $limit > 0 ? $limit : $this->perPage;
    }
}
