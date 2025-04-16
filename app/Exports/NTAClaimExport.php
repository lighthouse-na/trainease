<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class NTAClaimExport implements FromArray
{
    protected $ramdata;

    public function __construct($data)
    {
        $this->ramdata = $data;
    }

    public function array(): array
    {
        return $this->ramdata;
    }
}
