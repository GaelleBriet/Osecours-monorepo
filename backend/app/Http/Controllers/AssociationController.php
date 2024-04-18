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

    public function getAll()
    {
        try {            
            return $this->associationService->getAll();
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    public function store(AssociationRequest $request)
    {
        try {            
            return $this->associationService->create($request->validated());
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    public function show(string $id)
    {
        try {            
            return $this->associationService->getById($id);
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    public function update(AssociationRequest $request, string $id)
    {
        try {
            $shelter = $this->associationService->update($id,$request->validated());
            if ($shelter) {
                return $shelter;
            } else {
                throw new Exception('Shelter not found');
            }
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    public function destroy($id){
        try{
            $deleteShelter = $this->associationService->softDelete($id);
            return response()->json([
                'message' => 'L\'shelter a été supprimé avec succès.',
                'shelter' => $deleteShelter
            ]);

        }catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

}
