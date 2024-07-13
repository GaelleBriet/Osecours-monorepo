<?php

namespace App\Http\Controllers;

use App\Contract\AgeRangeRepositoryInterface;
use App\Models\AgeRange;
use Illuminate\Http\Request;

class AgeRangeController extends Controller
{
    protected AgeRangeRepositoryInterface $ageRangeRepository;

    public function __construct(AgeRangeRepositoryInterface $ageRangeRepository)
    {
        $this->ageRangeRepository = $ageRangeRepository;
    }

    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return AgeRange::all();
    }

    public function show(AgeRange $AgeRange): AgeRange
    {
        return $AgeRange;
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);

        return $this->ageRangeRepository->create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function update(Request $request, AgeRange $AgeRange): bool
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
        ]);

        return $AgeRange->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    public function delete(AgeRange $AgeRange): ?bool
    {
        return $AgeRange->delete();
    }
}
