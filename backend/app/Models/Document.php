<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Document",
 *     description="Document model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the document",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="filename",
 *         type="string",
 *         description="Name of the file",
 *         example="document.pdf"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Description of the document",
 *         example="A document describing the health status"
 *     ),
 *     @OA\Property(
 *         property="size",
 *         type="integer",
 *         description="Size of the document in bytes",
 *         example=1024
 *     ),
 *     @OA\Property(
 *         property="url",
 *         type="string",
 *         description="URL of the document",
 *         example="http://example.com/document.pdf"
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date",
 *         description="Date of the document",
 *         example="2024-04-16"
 *     ),
 *     @OA\Property(
 *         property="mimetype_id",
 *         type="integer",
 *         description="ID of the MIME type",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="doctype_id",
 *         type="integer",
 *         description="ID of the document type",
 *         example=1
 *     )
 * )
 */

class Document extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'filename',
        'description',
        'size',
        'url',
        'date',
        'mimetype_id',
        'doctype_id'
    ];

    public function doctype(): BelongsTo
    {
        return $this->belongsTo(Doctype::class);
    }

    public function mimetype(): BelongsTo
    {
        return $this->belongsTo(Mimetype::class);
    }

    public function healthcare(): HasOne
    {
        return $this->hasOne(Healthcare::class);
    }

    public function animals(): BelongsToMany
    {
        return $this->belongsToMany(Animal::class);
    }

    public function shelters(): BelongsToMany
    {
        return $this->belongsToMany(Shelter::class);
    }
}
