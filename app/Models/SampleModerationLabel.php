<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property float $confidence
 * @property integer $sample_id
 */
class SampleModerationLabel extends Model
{
    use HasFactory;

    public $fillable = ['name', 'confidence'];
}
