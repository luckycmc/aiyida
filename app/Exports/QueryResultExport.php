<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;

class QueryResultExport implements FromCollection
{
    protected $results;

    public function __construct(array $results)
    {
        $this->results = collect($results);
    }

    public function collection()
    {
        return $this->results;
    }
}
