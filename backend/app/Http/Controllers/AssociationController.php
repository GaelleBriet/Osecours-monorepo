<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssociationRequest;
use App\Http\Services\AssociationService;
use App\Http\Services\ErrorService;
use App\Models\Association;
use Exception;
use Illuminate\Http\Request;

class AssociationController extends Controller
{
    protected AssociationService $associationService;
    protected ErrorService $errorService;

    public function __construct(AssociationService $associationService, ErrorService $errorService)
    {
        $this->associationService = $associationService;
        $this->errorService = $errorService;

    }


        /**
     * @OA\Get(
     *     path="/associations",
     *   security={{"bearerAuth":{}}},
     *     operationId="getAllAssociations",
     *     tags={"Associations"},
     *     summary="Get all associations",
     *     description="Returns a list of all associations",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Association")
     *         )
     *     )
     * )
     */
    public function getAll()
    {
        try {
            return $this->associationService->getAll();
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    /**
     * @OA\Post(
     *     path="/associations",
     *   security={{"bearerAuth":{}}},
     *     operationId="storeAssociation",
     *     tags={"Associations"},
     *     summary="Create a new association",
     *     description="Stores a new association in the database",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data for the new association",
     *         @OA\JsonContent(ref="#/components/schemas/Association")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Association created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Association")
     *     )
     * )
     */
    public function store(AssociationRequest $request)
    {
        try {
            return $this->associationService->create($request->validated());
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/associations/{id}",
     *   security={{"bearerAuth":{}}},
     *     operationId="getAssociationById",
     *     tags={"Associations"},
     *     summary="Get an association by ID",
     *     description="Returns a single association",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID of the association to return",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Association")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Association not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            return $this->associationService->getById($id);
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    /**
     * @OA\Put(
     *     path="/associations/{id}",
     *   security={{"bearerAuth":{}}},
     *     operationId="updateAssociation",
     *     tags={"Associations"},
     *     summary="Update an existing association",
     *     description="Updates data of a specified association",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID of the association to update",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Data to update the association",
     *         @OA\JsonContent(ref="#/components/schemas/Association")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Association updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Association")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Association not found"
     *     )
     * )
     */
    public function update(AssociationRequest $request, string $id)
    {
        try {
            $association = $this->associationService->update($id, $request->validated());
            if ($association) {
                return $association;
            } else {
                throw new Exception('Association not found');
            }
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    /**
     * @OA\Delete(
     *     path="/associations/{id}",
     *   security={{"bearerAuth":{}}},
     *     operationId="deleteAssociation",
     *     tags={"Associations"},
     *     summary="Delete an association",
     *     description="Soft deletes a specified association from the database",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID of the association to delete",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Association deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="association", ref="#/components/schemas/Association")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Association not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $deleteAssociation = $this->associationService->softDelete($id);
            return response()->json([
                'message' => 'L\'association a été supprimée avec succès.',
                'association' => $deleteAssociation
            ]);

        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    /**
     * @OA\Get(
     *     path="/associations/{id}/members",
     *   security={{"bearerAuth":{}}},
     *     tags={"Associations"},
     *     summary="Get members of an association",
     *     description="Returns a list of association members",
     *     @OA\Parameter(
     *         name="id",
     *         description="ID of the association",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not found"
     *     )
     * )
     */
    public function getMembers($id)
    {
        $association = Association::find($id);
        if (!$association) {
            return response()->json(['message' => 'Association not found'], 404);
        }

        $members = $association->users;
        return response()->json($members);
    }
}
