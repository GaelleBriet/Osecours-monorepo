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
     * Display a listing of the resource.
     */
    public function getAll()
    {
        try {            
            return $this->animalService->getAll();
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

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

    public function update(AnimalUpdateRequest $request, string $id)
    {
        try {
            if(is_null(Animal::find($id))){
                throw new AnimalNotFoundException("Animal #".$id." not found");
            }
            $request->validated();
            $animalData = collect($request)->except('number')->toArray();
            $identificationData = collect($request)->only('number')->toArray();
            $animal = $this->animalService->update($id,$animalData);
            $animal->identification()->update($identificationData);
            if ($animal) {
                return new AnimalResource($animal);
            } else {
                throw new AnimalNotFoundException('Animal not found');
            }
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    public function destroy($id){
        try{
            $deleteAnimal = $this->animalService->softDelete($id);
            return response()->json([
                'message' => 'L\'animal a été supprimé avec succès.',
                'animal' => $deleteAnimal
            ]);

        }catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }
}
