<?php

namespace App\Http\Controllers;

use App\Name;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use stdClass;

class NameController extends Controller
{
    use ApiResponser;

    /**
     * Find in database for given string.
     * make array single dimension.
     * make array unique if $dupes is true
     *
     * @param string $terms
     * @param bool $dupes
     * @return JsonResponse
     */
    public function show(string $terms, bool $dupes = true): JsonResponse
    {
        try {
            $names = $this->searchLastNameAndGetFullNameFor($terms);

            //get all names in single dimension array in same alphabetical order coming from db query
            $fullNames = [];
            foreach ($names as $name) {
                array_push($fullNames, $name->fullname);
            }

            //if dupes flag is true, it will remove duplicate entries
            $fullNames = $dupes === true ? array_unique($fullNames) : $fullNames;

            return $this->successResponse($fullNames);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Search in database for $terms in lastname column,
     * returns fullname ordered by lastname and firstname
     *
     * @codeCoverageIgnore
     * @param string $terms
     * @return Collection|stdClass
     */
    public function searchLastNameAndGetFullNameFor(string $terms)
    {
        return Name::query()
            ->selectRaw("CONCAT(firstname, ' ' , lastname) AS fullname")
            ->where('lastname', 'LIKE', "%$terms%")
            ->orderByRaw('CONCAT(lastname, firstname)')
            ->get();
    }
}
