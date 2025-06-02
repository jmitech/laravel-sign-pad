<?php

namespace Jmitech\LaravelSignPad;

use Spatie\MediaLibrary\HasMedia;
use App\Traits\HasDefaultThumbnails;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Jmitech\LaravelSignPad\Factories\SignatureTemplateFactory;

class SignatureTemplate extends Model implements HasMedia
{
    use Notifiable,
        HasFactory,
        SoftDeletes,
        InteractsWithMedia,
        HasDefaultThumbnails;

    public const collectionName = 'signature-templates';

    public $fillable = [
        'name',
        'config',
    ];

    protected function casts(): array
    {
        return [
            'config' => 'array',
        ];
    }

    public function receivesBroadcastNotificationsOn(): string
    {
        return 'signaturetemplates.' . $this->id;
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->defaultMediaConversions();
    }

    public function sample_pdf(): HasOne
    {
        return $this->hasOne(Media::class, 'model_id')->where('model_type', self::class);
    }
    
    protected static function newFactory()
    {
        return SignatureTemplateFactory::new();
    }
}
