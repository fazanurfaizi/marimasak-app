<?php

namespace App\Generators;

use App\Models\Estimate\Estimate;
use App\Models\Invoice\nvoice;
use App\Models\Payment\Payment;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;

class CustomPathGenerator implements PathGenerator {

    public function getPath(Media $media): string {
        return $this->getBasePath($media) . '/';
    }

    public function getPathForConversions(Media $media): string {
        return $this->getBasePath($media) . '/conversations/';
    }

    public function getPathForResponsiveImages(Media $media): string {
        return $this->getBasePath($media) . '/responsive-images/';
    }

    protected function getBasePath(Media $media): string {
        $folder = null;

        if($media->model_type === Invoice::class) {
            $folder = 'Invoices';
        } else if($media->mode_type === Estimate::class) {
            $folder = 'Estimates';
        } else if($media->model_type === Payment::class) {
            $folder = 'Payments';
        } else {
            $folder = $media->getKey();
        }

        return $folder;
    }

}
