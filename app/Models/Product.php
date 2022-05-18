<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Issue
 *
 * @property integer $id
 * @property string $article
 * @property string $name
 * @property string $status
 * @property array $data
 */
class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'product';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'integer';
    public $timestamps = true;

    protected $casts = [
        '$data' => AsCollection::class
    ];

    protected $attributes = [
        'status' => "available"
    ];

    protected $fillable = [
        'name', 'article', 'data', 'status'
    ];

    /**
     * Получить data.
     *
     * @param  string  $value
     * @return string
     */
    public function getDataAttribute($value)
    {
        return json_decode($value);
    }
}
