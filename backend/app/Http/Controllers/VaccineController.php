<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Vaccine;
use Illuminate\Http\Request;

use OpenApi\Annotations as OA;

class VaccineController extends Controller
{
    
       /**
 * @OA\Get(
 *     path="/vaccines/all",
 *   security={{"bearerAuth":{}}},
 *     operationId="getAllvaccines",
 *     tags={"Vaccines"},
 *     summary="Get all vaccines",
 *     description="Returns a list of all vaccines",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Vaccine")
 *         )
 *     )
 * )
 */
    public function getAll()
    {
        return Vaccine::all();
    }
    /**
 * @OA\Get(
 *     path="/vaccines/{id}",
 *   security={{"bearerAuth":{}}},
 *     operationId="getVaccineById",
 *     tags={"Vaccines"},
 *     summary="Get an vaccine by ID",
 *     description="Returns a single vaccine",
 *     @OA\Parameter(
 *         name="id",
 *         description="ID of the vaccine to return",
 *         required=true,
 *         in="path",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(ref="#/components/schemas/Vaccine")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Vaccine not found"
 *     )
 * )
 */

    public function show(Vaccine $Vaccine)
    {
        return $Vaccine;
    }

    
/**
 * @OA\Post(
 *     path="/vaccines",
 *   security={{"bearerAuth":{}}},
 *     operationId="storeVaccine",
 *     tags={"Vaccines"},
 *     summary="Create a new Vaccine",
 *     description="Stores a new Vaccine in the database",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Data for the new Vaccine",
 *         @OA\JsonContent(ref="#/components/schemas/Vaccine")
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Vaccine created successfully",
 *         @OA\JsonContent(ref="#/components/schemas/Vaccine")
 *     )
 * )
 */
    public function create(Request $request)
    {
        $request->validate([            
                "name" => "required",
                "description" => "nullable",
                      
        ]);
        return Vaccine::create($request->all());
    }

    /**
 * @OA\Put(
 *     path="/vaccines/{id}",
 *   security={{"bearerAuth":{}}},
 *     operationId="updateVaccine",
 *     tags={"Vaccines"},
 *     summary="Update an existing vaccine",
 *     description="Updates data of a specified vaccine",
 *     @OA\Parameter(
 *         name="id",
 *         description="ID of the vaccine to update",
 *         required=true,
 *         in="path",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\RequestBody(
 *         required=true,
 *         description="Data to update the vaccine",
 *         @OA\JsonContent(ref="#/components/schemas/Vaccine")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Vaccine updated successfully",
 *         @OA\JsonContent(ref="#/components/schemas/Vaccine")
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Vaccine not found"
 *     )
 * )
 */

    public function update(Request $request, Vaccine $Vaccine)
    {    
        return $Vaccine->update($request->all());
    }

    /**
 * @OA\Delete(
 *     path="/vaccines/{id}",
 *   security={{"bearerAuth":{}}},
 *     operationId="deleteVaccine",
 *     tags={"Vaccines"},
 *     summary="Delete an vaccine",
 *     description="Soft deletes a specified vaccine from the database",
 *     @OA\Parameter(
 *         name="id",
 *         description="ID of the vaccine to delete",
 *         required=true,
 *         in="path",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Vaccine deleted successfully",
 *         @OA\JsonContent(
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(property="Vaccine", ref="#/components/schemas/Vaccine")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Vaccine not found"
 *     )
 * )
 */

    public function delete(Vaccine $Vaccine)
    {
        return $Vaccine->delete();
    }
    /**
 * @OA\Post(
 *     path="/vaccines/{id}/animal/",
 *   security={{"bearerAuth":{}}},
 *     operationId="addVaccineToAnAnimal",
 *     tags={"Vaccines"},
 *     summary="Add vaccine to an animal",
 *     description="Add vaccine to an animal",
 *     @OA\RequestBody(
 *         required=true,
 *         description="Data for the new Vaccine",
 *        @OA\JsonContent(
 *             @OA\Property(property="animal_id", type="integer", example=1),
 *      ),
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Vaccine created successfully",
 *         @OA\JsonContent(ref="#/components/schemas/Vaccine")
 *     )
 * )
 */

    public function vacinneAnimal(Request $request,Vaccine $vaccine){
        $request->validate([
            "animal_id" => "required|integer|exists:animals,id"
        ]);
        
        $vaccine->animals()->syncWithoutDetaching($request->get("animal_id"));
     
        return Animal::find($request->get("animal_id"))->vaccines;
    }

   
}
