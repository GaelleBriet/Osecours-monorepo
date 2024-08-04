<?php

namespace App\Repositories;

use App\Contract\AssociationRepositoryInterface;
use App\Http\Resources\AssociationResource;
use App\Models\Association;

class AssociationRepository extends BaseRepository implements AssociationRepositoryInterface
{
    public function __construct(Association $association)
    {
        parent::__construct($association);
    }

    public function all(): \Illuminate\Database\Eloquent\Collection
    {

        $associations = Association::all();

        return AssociationResource::collection($associations);
    }

    public function create($association): mixed
    {
        return Association::create($association);
    }

    public function update($id, $updatedDatas): mixed
    {
        $association = Association::find($id);
        if ($association) {
            $association->update($updatedDatas);
        }

        return $association;
    }

    public function find($id): mixed
    {
        $association = Association::withTrashed()
            ->findOrFail($id);

        return new AssociationResource($association);
    }

    public function softDelete($id): mixed
    {
        $association = Association::findOrFail($id);
        $association->delete();

        return $association;
    }
}
