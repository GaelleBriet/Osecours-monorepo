<?php

namespace App\Http\Controllers;

use App\Exceptions\AnimalNotFoundException;
use App\Http\Requests\AnimalRequest;
use App\Http\Services\AnimalService;
use App\Http\Services\ErrorService;
use Exception;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;


class AnimalController extends Controller
{
    protected AnimalService $animalService;
    protected ErrorService $errorService;

    public function __construct(AnimalService $animalService, ErrorService $eService)
    {
        $this->animalService = $animalService;

        $this->errorService = $eService;
    }
    /**
     * @OA\Get(
     *     path="/animals/all",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200", description="get list of all animals")
     * 
     * )
     */
    public function getAll()
    {
        try {
            return $this->animalService->getAll();
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/animals",
     *     summary="register new animal",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Animal fields",
     *         @OA\JsonContent(
     *             required={"specie_id"},
     *             @OA\Property(property="name", type="string", example="Pupuce" , maxLength=100),
     *             @OA\Property(property="description", type="string", example="Really cute" ),
     *             @OA\Property(property="birth_date", type="date", example="Pupuce" , format="1995-04-01"),
     *             @OA\Property(property="cats_friendly", type="boolean", example=true ),
     *             @OA\Property(property="dogs_friendly", type="boolean", example=true ),
     *             @OA\Property(property="children_friendly", type="boolean", example=true ),
     *             @OA\Property(property="age", type="integer", example=4 ),
     *             @OA\Property(property="behavioral_comment", type="string", example="Love cuddle" ),
     *             @OA\Property(property="sterilized", type="boolean", example=true ),
     *             @OA\Property(property="deceased", type="boolean", example=false ),
     *             @OA\Property(property="specie_id", type="integer", example=1 ),
     *             @OA\Property(property="gender_id", type="integer", example=2 ),
     *             @OA\Property(property="color_id", type="integer", example=3 ),
     *             @OA\Property(property="sizerange_id", type="integer", example=4 ),
     *             @OA\Property(property="agerange_id", type="integer", example=2 ),
     *             @OA\Property(property="breed_id", type="integer", example=2 ),
     *             @OA\Property(property="number", type="string", example="152A5P6", maxLength=15 ),
     *   @OA\Property(property="email", type="string", example="admin-lerefugedeschimeres@osecours.org", format="email" ),
     *           @OA\Property(property="password", type="string", example="P@ssword_1" ),
     *           @OA\Property(property="association_id", type="integer", example=1 ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur créé avec succès"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Requête invalide"
     *     )
     * )
     */
    public function store(AnimalRequest $request)
    {
        try {
            return $this->animalService->create($request->validated());
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    public function show(string $id)
    {
        try {
            return $this->animalService->getById($id);
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    public function update(AnimalRequest $request, string $id)
    {
        try {
            $animal = $this->animalService->update($id, $request->validated());
            if ($animal) {
                return $animal;
            } else {
                throw new AnimalNotFoundException('Animal not found');
            }
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    public function destroy($id)
    {
        try {
            $deleteAnimal = $this->animalService->softDelete($id);
            return response()->json([
                'message' => 'L\'animal a été supprimé avec succès.',
                'animal' => $deleteAnimal
            ]);
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }
}
