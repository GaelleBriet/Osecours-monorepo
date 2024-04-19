<?php

namespace App\Models;

use App\Contract\HasDocumentsInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Healthcare",
 *     description="Healthcare model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID of the healthcare record",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="date",
 *         type="string",
 *         format="date",
 *         description="Date of the healthcare consultation",
 *         example="2022-04-16"
 *     ),
 *     @OA\Property(
 *         property="report",
 *         type="string",
 *         description="Report of the healthcare consultation"
 *     ),
 *     @OA\Property(
 *         property="weight",
 *         type="number",
 *         format="float",
 *         description="Weight of the animal during the healthcare consultation",
 *         example=12.5
 *     ),
 *     @OA\Property(
 *         property="size",
 *         type="number",
 *         format="float",
 *         description="Size of the animal during the healthcare consultation",
 *         example=30.2
 *     ),
 *     @OA\Property(
 *         property="animal_id",
 *         type="integer",
 *         description="ID of the associated animal",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="document_id",
 *         type="integer",
 *         description="ID of the associated document",
 *         example=1
 *     )
 * )
 */

class Healthcare extends Model implements HasDocumentsInterface
{
    use HasFactory;

    protected $fillable = [
        "date",
        "report",
        "weight",
        "size",
        "animal_id",
        "document_id"
    ];

    public function animal(): HasOne
    {
        return $this->hasOne(Animal::class);
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function getDocuments()
    {
        return $this->belongsTo(Document::class)->get();
    }
}
