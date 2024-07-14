<?php

namespace App\Http\Controllers;

use App\Contract\AgeRangeRepositoryInterface;
use App\Models\AgeRange;
use Illuminate\Http\Request;

class AgeRangeController extends Controller
{
    protected AgeRangeRepositoryInterface $ageRangeRepository;

    /**
     * @param AgeRangeRepositoryInterface $ageRangeRepository
     */
    public function __construct(AgeRangeRepositoryInterface $ageRangeRepository)
    {
        $this->ageRangeRepository = $ageRangeRepository;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll(): \Illuminate\Database\Eloquent\Collection
    {
        return AgeRange::all();
    }

    /**
     * @param AgeRange $AgeRange
     * @return AgeRange
     */
    public function show(AgeRange $AgeRange): AgeRange
    {
        return $AgeRange;
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

        return $this->ageRangeRepository->create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
    }

    /**
     * @param Request $request
     * @param AgeRange $AgeRange
     * @return bool
     */
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

    /**
     * @param AgeRange $AgeRange
     * @return bool|null
     */
    public function delete(AgeRange $AgeRange): ?bool
    {
        return $AgeRange->delete();
    }
}
