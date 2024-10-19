<?php

namespace App\Services\Country;

use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;

class CountryIndexService
{
    /**
     * @return Collection
     */
    public function execute(): Collection
    {
        return Country::all();
    }
}
