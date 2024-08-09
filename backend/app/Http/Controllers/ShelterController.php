<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShelterRequest;
use App\Http\Services\ErrorService;
use App\Http\Services\ShelterService;
use Exception;

class ShelterController extends Controller
{
    protected ShelterService $shelterService;

    protected ErrorService $errorService;

    public function __construct(ShelterService $shelterService, ErrorService $errorService)
    {
        $this->shelterService = $shelterService;
        $this->errorService = $errorService;

    }

    public function getAll()
    {
        try {
            return $this->shelterService->getAll();
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    public function store(ShelterRequest $request)
    {
        try {
            return $this->shelterService->create($request->validated());
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    public function show(string $id)
    {
        try {
            return $this->shelterService->getById($id);
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    public function update(ShelterRequest $request, string $id)
    {
        try {
            $shelter = $this->shelterService->update($id, $request->validated());
            if ($shelter) {
                return $shelter;
            } else {
                throw new Exception('Shelter not found');
            }
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }

    public function destroy($id)
    {
        try {
            $deleteShelter = $this->shelterService->softDelete($id);

            return response()->json([
                'message' => 'L\'shelter a été supprimé avec succès.',
                'shelter' => $deleteShelter,
            ]);

        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }
}
