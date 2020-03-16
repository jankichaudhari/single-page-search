<?php

namespace App\Http\Controllers;

use App\Name;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use \Illuminate\Database\Eloquent\Collection;
use \Illuminate\Database\Eloquent\Builder;

class NameController extends Controller
{
    use ApiResponser;

    /**
     * Searches in db table names
     * @param string $terms
     * @param bool $dupes
     * @return JsonResponse
     */
    public function show(string $terms, bool $dupes = true): JsonResponse
    {
        $names = $this->searchLastNameAndGetFullNameFor($terms);

        //get all names in single dimention array in same alphabetical order coming from db query
        $fullNames = [];
        foreach ($names as $name) {
            array_push($fullNames, $name->fullname);
        }

        //if dupes flag is true, it will remove duplicate entries
       $fullNames = $dupes === true ? array_unique($fullNames) : $fullNames;

        return $this->successResponse($fullNames);
    }

    /**
     * Search in database for $terms in lastname column,
     * returns fullname ordered by lastname and firstname
     *
     * @param string $terms
     * @return Builder[]|Collection
     */
    private function searchLastNameAndGetFullNameFor(string $terms)
    {
        return  Name::query()
            ->selectRaw("CONCAT(firstname, ' ' , lastname) AS fullname")
            ->where('lastname', 'LIKE', "%$terms%")
            ->orderByRaw('CONCAT(lastname, firstname)')
            ->get();
    }
}
