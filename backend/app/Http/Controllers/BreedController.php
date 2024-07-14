<?php

namespace App\Http\Controllers;

use App\Models\Breed;
use App\Models\Specie;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class BreedController extends Controller
{

    /**
     * @param Request $request
     * @return Collection|array
     * @throws Exception
     */
    public function getAll(Request $request): Collection|array
    {
        $query = Breed::with(['specie']);
        $breeds = Breed::all();

        if ($request->has('species')) {
            $species = ucfirst($request->species);
            $specieExist = Specie::where('name', $species)->first();
            if (! $specieExist) {
                throw new Exception('Specie #'.$request->species.' not found', 404);
            }
            $query->whereHas('specie', function ($query) use ($species) {
                $query->where('name', $species);
            });

            $breeds = $query->get();
        }

        return $breeds;
    }

    /**
     * @param Breed $breed
     * @return Breed
     */
    public function show(Breed $breed): Breed
    {
        return $breed;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request): mixed
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);

        return Breed::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    /**
     * @param Request $request
     * @param Breed   $breed
     * @return bool
     */
    public function update(Request $request, Breed $breed): bool
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);

        return $breed->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    /**
     * @param Request $request
     * @param Breed   $breed
     * @return bool|null
     */
    public function delete(Request $request, Breed $breed): ?bool
    {
        return $breed->delete();
    }
}
