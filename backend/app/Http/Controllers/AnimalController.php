<?php

namespace App\Http\Controllers;

use App\Exceptions\AnimalNotFoundException;
use App\Http\Requests\AnimalRequest;
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
    public function all()
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

    public function update(AnimalRequest $request, string $id)
    {
        try {
            $animal = $this->animalService->update($id,$request->validated());
            if ($animal) {
                return $animal;
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
