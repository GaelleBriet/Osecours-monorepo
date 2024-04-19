<?php

namespace App\Http\Controllers;

use App\Exceptions\AnimalNotFoundException;
use App\Http\Requests\AnimalRequest;
use App\Http\Requests\AnimalUpdateRequest;
use App\Http\Resources\AnimalResource;
use App\Http\Services\AnimalService;
use App\Http\Services\ErrorService;
use App\Models\Animal;
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
     *     tags={"Animals"},
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
     *     description="Store animal informations with identification associated",
     *     operationId="createAnimal",
     *     tags={"Animals"},
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
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Animal created successfully",
     *            @OA\JsonContent(
     *             ref="#/components/schemas/Animal"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *      @OA\Response(
     *         response=401,
     *         description="Unauthorized"
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

    /**
     * @OA\Get(
     *     path="/animals/{id}",
     *     summary="Get specific animal details",
     *     description="Return informations for an animal with specific id",
     *     operationId="getAnimalById",
     *     tags={"Animals"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="animal Id to fetch",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Animal fetched successfully",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Animal"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Animal not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server Error"
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            return $this->animalService->getById($id);
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/animals/{id}",
     *     summary="Update an animal",
     *     operationId="updateAnimalById",
     *     tags={"Animals"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="animal Id to update",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Animal fields",
     *         @OA\JsonContent(
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
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Animal created successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request"
     *     ),
     *      @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function update(AnimalUpdateRequest $request, string $id)
    {
        try {
            if (is_null(Animal::find($id))) {
                throw new AnimalNotFoundException("Animal #" . $id . " not found");
            }
            $animal = $this->animalService->update($id, $request->validated());
            return new AnimalResource($animal);
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    /**
     * @OA\Delete(
     *     path="/animals/{id}",
     *     summary="Delete specific animal (soft delete)",
     *     description="Make a soft delete for an animal with specific id",
     *     operationId="deleteAnimalById",
     *     tags={"Animals"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de l'animal à récupérer",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Animal récupéré avec succès",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/Animal"
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Animal non trouvé"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erreur interne"
     *     )
     * )
     */
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
