<?php

namespace App\Http\Controllers;

use App\Models\Healthcare;
use Illuminate\Http\Request;

class HealthcareController extends Controller
{
           /**
 * @OA\Get(
 *     path="/healthcares/all",
 *   security={{"bearerAuth":{}}},
 *     operationId="getAllHealthcares",
 *     tags={"Healthcares"},
 *     summary="Get all healthcare",
 *     description="Returns a list of all healthcare",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Healthcare")
 *         )
 *     )
 * )
 */
    public function getAll()
    {
        return Healthcare::all();
    }

               /**
 * @OA\Get(
 *     path="/healthcares/{id}",
 *   security={{"bearerAuth":{}}},
 *     operationId="getSpecificHealthcare",
 *     tags={"Healthcares"},
 *     summary="Get specific healthcare",
 *     description="Return finded healthcare",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Healthcare")
 *         )
 *     )
 * )
 */
    public function show(Healthcare $Healthcare)
    {

        return $Healthcare;
    }

    /**
 * @OA\Post(
 *     path="/healthcares",
 *   security={{"bearerAuth":{}}},
 *     operationId="storeHealthcare",
 *     tags={"Healthcares"},
 *     summary="Create a new Healthcare",
 *     description="Stores a new Healthcare in the database",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Data for the new Healthcare",
 *         @OA\JsonContent(ref="#/components/schemas/Healthcare")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Healthcare created successfully",
 *         @OA\JsonContent(ref="#/components/schemas/Healthcare")
 *     )
 * )
 */
    public function create(Request $request)
    {
        $request->validate([            
                "date" => "required|date",
                "report" => "required",
                "weight" => "nullable",
                "size" => "nullable",
                "animal_id" => "required|integer",
                "document_id" => "nullable|integer"            
        ]);
        return Healthcare::create($request->all());
    }

        /**
 * @OA\Put(
 *     path="/healthcares/{id}",
 *   security={{"bearerAuth":{}}},
 *     operationId="updateHealthcare",
 *     tags={"Healthcares"},
 *     summary="Update an existing Healthcare",
 *     description="Updates data of a specified Healthcare",
 *     @OA\Parameter(
 *         name="id",
 *         description="ID of the Healthcare to update",
 *         required=true,
 *         in="path",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Data to update the Healthcare",
 *         @OA\JsonContent(ref="#/components/schemas/Healthcare")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Healthcare updated successfully",
 *         @OA\JsonContent(ref="#/components/schemas/Healthcare")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Healthcare not found"
 *     )
 * )
 */
    public function update(Request $request, Healthcare $Healthcare)
    {    
        return $Healthcare->update($request->except(['animal_id']));
    }

        /**
 * @OA\Delete(
 *     path="/healthcares/{id}",
 *   security={{"bearerAuth":{}}},
 *     operationId="deleteHealthcare",
 *     tags={"Healthcares"},
 *     summary="Delete an Healthcare",
 *     description="Soft deletes a specified Healthcare from the database",
 *     @OA\Parameter(
 *         name="id",
 *         description="ID of the Healthcare to delete",
 *         required=true,
 *         in="path",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Healthcare deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(property="Healthcare", ref="#/components/schemas/Healthcare")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Healthcare not found"
 *     )
 * )
 */

    public function delete(Healthcare $Healthcare)
    {
        return $Healthcare->delete();
    }
}
