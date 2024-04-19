<?php

namespace App\Http\Controllers;

use App\Http\Services\DocumentService;
use App\Models\Animal;
use App\Models\Document;
use App\Models\Healthcare;
use App\Models\Shelter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class DocumentController extends Controller
{
    protected DocumentService $documentService;

    public function __construct(DocumentService $documentService)
    {
        $this->documentService = $documentService;
    }

    /**
     * @OA\Get(
     *     path="/documents",
     *     tags={"Documents"},
     *     summary="Get all documents",
     *     description="Returns all documents",
     *     @OA\Response(
     *         response=200,
     *         description="Successful fetch",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Document")
     *         )
     *     )
     * )
     */
    public function getAll()
    {
        return Document::all();
    }

    /**
     * @OA\Get(
     *     path="/documents/{id}",
     *     tags={"Documents"},
     *     summary="Get a specific document",
     *     description="Returns a single document by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Document ID",
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(ref="#/components/schemas/Document")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Document not found"
     *     )
     * )
     */
    public function show(String $id)
    {
        return $this->documentService->findDocument($id);
    }

    /**
     * @OA\Post(
     *     path="/documents/store/animals/{animalId}",
     *     tags={"Documents"},
     *     summary="Add a document to an animal",
     *     description="Creates a new document associated with an animal",
     *     @OA\Parameter(
     *         name="animalId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Animal ID"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"filename", "file"},
     *             @OA\Property(property="filename", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="file", type="string", format="binary")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Document created",
     *         @OA\JsonContent(ref="#/components/schemas/Document")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function addDocumentForAnimal(Request $request, Animal $animal)
    {
        $validated = $request->validate([
            'filename' => 'required|max:255',
            'description' => '',
            'file' => 'required|file|mimes:jpg,bmp,png|max:2048'
        ]);
        return $this->documentService->createDocumentForAnimal($request, $animal);
    }

    /**
     * @OA\Get(
     *     path="/animals/{animalId}/documents",
     *     tags={"Documents"},
     *     summary="Retrieve all documents associated with an animal",
     *     description="Fetches a list of documents associated with a specific animal",
     *     @OA\Parameter(
     *         name="animalId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Animal ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Document")
     *         )
     *     )
     * )
     */
    public function findAllAnimalDocuments(Animal $animal)
    {
        return $this->documentService->getAllAnimalDocuments($animal);
    }

    /**
     * @OA\Get(
     *     path="/healthcares/{healthcareId}/documents",
     *     tags={"Documents"},
     *     summary="Retrieve all documents associated with a healthcare provider",
     *     description="Fetches a list of documents associated with a specific healthcare provider",
     *     @OA\Parameter(
     *         name="healthcareId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Healthcare ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Document")
     *         )
     *     )
     * )
     */
    public function findAllHealthcareDocuments(Healthcare $healthcare)
    {
        return $this->documentService->getAllHealthcareDocuments($healthcare);
    }

    /**
     * @OA\Get(
     *     path="/shelters/{shelterId}/documents",
     *     tags={"Documents"},
     *     summary="Retrieve all documents associated with a shelter",
     *     description="Fetches a list of documents associated with a specific shelter",
     *     @OA\Parameter(
     *         name="shelterId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Shelter ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Document")
     *         )
     *     )
     * )
     */
    public function findAllShelterDocuments(Shelter $shelter)
    {
        return $this->documentService->getAllShelterDocuments($shelter);
    }

    /**
     * @OA\Post(
     *     path="/healthcares/{healthcareId}/documents",
     *     tags={"Documents"},
     *     summary="Add a document to a healthcare provider",
     *     description="Creates a new document associated with a healthcare provider",
     *     @OA\Parameter(
     *         name="healthcareId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Healthcare ID"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"filename", "file"},
     *             @OA\Property(property="filename", type="string"),
     *             @OA\Property(property="description", type="string", nullable=true),
     *             @OA\Property(property="file", type="string", format="binary")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Document created",
     *         @OA\JsonContent(ref="#/components/schemas/Document")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function addDocumentForHealthCare(Request $request, Healthcare $healthcare)
    {
        $validated = $request->validate([
            'filename' => 'required|max:255',
            'description' => '',
            'file' => 'required|file|mimes:jpg,bmp,png|max:2048'
        ]);
        return $this->documentService->createDocumentForHealthCare($request, $healthcare);
    }

    /**
     * @OA\Post(
     *     path="/shelters/{shelterId}/documents",
     *     tags={"Documents"},
     *     summary="Add a document to a shelter",
     *     description="Creates a new document associated with a shelter",
     *     @OA\Parameter(
     *         name="shelterId",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Shelter ID"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"filename", "file"},
     *             @OA\Property(property="filename", type="string"),
     *             @OA\Property(property="description", type="string", nullable=true),
     *             @OA\Property(property="file", type="string", format="binary")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Document created",
     *         @OA\JsonContent(ref="#/components/schemas/Document")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *     )
     * )
     */
    public function addDocumentForShelter(Request $request, Shelter $shelter)
    {
        $validated = $request->validate([
            'filename' => 'required|max:255',
            'description' => '',
            'file' => 'required|file|mimes:jpg,bmp,png|max:2048'
        ]);
        return $this->documentService->createDocumentForShelter($request, $shelter);
    }


    /**
     * @OA\Put(
     *     path="/documents/{id}",
     *     tags={"Documents"},
     *     summary="Update a document",
     *     description="Updates an existing document",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Document ID"
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="filename", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="file", type="string", format="binary")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Document updated",
     *         @OA\JsonContent(ref="#/components/schemas/Document")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Document not found"
     *     )
     * )
     */
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => '',
            'size' => '',
            'url' => '',
            'date' => '',
        ]);
        return $document->update([
            'name' => $request->name,
            'description' => $request->description,
            'size' => $request->size,
            'url' => $request->url,
            'date' => $request->date,
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/documents/{id}",
     *     tags={"Documents"},
     *     summary="Delete a document",
     *     description="Deletes a specific document",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="Document ID"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Document deleted",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Document deleted successfully.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Document not found"
     *     )
     * )
     */
    public function delete(Request $request, Document $document)
    {
        return $document->delete();
    }
}
