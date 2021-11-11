<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $path
 * @property string $moderation_data
 */
class Sample extends Model
{
    use HasFactory;

    public function moderationLabels() {
        return $this->hasMany(SampleModerationLabel::class, 'sample_id');
    }
}
