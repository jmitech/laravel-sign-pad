<?php

namespace Jmitech\LaravelSignPad;

use Jmitech\LaravelSignPad\Signature;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SignatureRequirement extends Model
{
    public $table = 'signature_requirement';

    public $fillable = [
        'signature_template_id',
        'overdue_at',
    ];

    protected function casts(): array
    {
        return [
            'overdue_at' => 'datetime',
        ];
    }

    public function template(): BelongsTo
    {
        return $this->belongsTo(SignatureTemplate::class, 'signature_template_id');
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'model_id')
            ->where('model_type', '=', Media::class);
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function signature(): Signature|MorphOne
    {
        return $this->model?->signature;
    }

    public function hasBeenSigned(): bool
    {
        return $this->model && $this->model->signature?->count() > 0;
    }

    public function isOverdue(): bool
    {
        return $this->overdue_at && $this->overdue_at < now();
    }
}
