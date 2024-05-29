<?php

namespace App\Http\Controllers;

use App\Http\Services\DocumentService;
use App\Http\Resources\DocumentResource;
use App\Http\Services\ErrorService;
use App\Models\Animal;
use App\Models\Document;
use App\Models\Healthcare;
use App\Models\Shelter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class DocumentController extends Controller
{
    protected DocumentService $documentService;
    protected ErrorService $errorService;


    public function __construct(DocumentService $documentService, ErrorService $eService)
    {
        $this->documentService = $documentService;
        $this->errorService = $eService;
    }

    /**
     * @OA\Get(
     *     path="/documents",
     *   security={{"bearerAuth":{}}},
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
     *   security={{"bearerAuth":{}}},
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
     *   security={{"bearerAuth":{}}},
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
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"filename", "file"},
     *                 @OA\Property(
     *                     property="filename",
     *                     type="string",
     *                     description="Name of the file"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     description="Description of the file",
     *                     nullable=true
     *                 ),
     *                 @OA\Property(
     *                     property="file",
     *                     type="string",
     *                     format="binary",
     *                     description="File to upload"
     *                 )
     *             )
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
     *     path="/documents/find/animals/{animalId}",
     *   security={{"bearerAuth":{}}},
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
     *     path="/documents/find/healthcares/{healthcareId}",
     *   security={{"bearerAuth":{}}},
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
     *     path="/documents/find/shelters/{shelterId}",
     *   security={{"bearerAuth":{}}},
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
     *     path="/documents/store/healthcares/{healthcareId}",
     *   security={{"bearerAuth":{}}},
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
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"filename", "file"},
     *                 @OA\Property(
     *                     property="filename",
     *                     type="string",
     *                     description="Name of the file"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     description="Description of the file",
     *                     nullable=true
     *                 ),
     *                 @OA\Property(
     *                     property="file",
     *                     type="string",
     *                     format="binary",
     *                     description="File to upload"
     *                 )
     *             )
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
     *     path="/documents/store/shelters/{shelterId}",
     *   security={{"bearerAuth":{}}},
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
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"filename", "file"},
     *                 @OA\Property(
     *                     property="filename",
     *                     type="string",
     *                     description="Name of the file"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     description="Description of the file",
     *                     nullable=true
     *                 ),
     *                 @OA\Property(
     *                     property="file",
     *                     type="string",
     *                     format="binary",
     *                     description="File to upload"
     *                 )
     *             )
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
     *   security={{"bearerAuth":{}}},
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
     *            @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"filename", "file"},
     *                 @OA\Property(
     *                     property="filename",
     *                     type="string",
     *                     description="Name of the file"
     *                 ),
     *                 @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     description="Description of the file",
     *                     nullable=true
     *                 ),
     *                 @OA\Property(
     *                     property="file",
     *                     type="string",
     *                     format="binary",
     *                     description="File to upload"
     *                 )
     *             )
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
    public function update(Request $request, string $id)
    {
        
        $request->validate([
            'filename' => 'required|max:255',
            'description' => 'nullable|string',
            'size' => 'nullable|integer',
            'url' => 'nullable|url',
            'date' => 'nullable|date',
        ]);

        $updatedDocument = $this->documentService->updateDocument($id, $request->all());

        if (!$updatedDocument) {
            return response()->json(['message' => 'Document not found or update failed'], 404);
        }

        return new DocumentResource($updatedDocument);
    }

    /**
     * @OA\Delete(
     *     path="/documents/{id}",
     *   security={{"bearerAuth":{}}},
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
    public function delete($id)
    {
        try {
            $deleteDocument = $this->documentService->softDeleteDocument($id);
            return response()->json([
                'message' => 'Le document a été supprimé avec succès.',
                'document' => $deleteDocument
            ]);
        } catch (Exception $e) {
            return $this->errorService->handle($e);
        }
    }
}
