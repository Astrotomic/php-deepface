<?php

namespace Astrotomic\DeepFace\Data;

use Astrotomic\DeepFace\Enums\Detector;
use Astrotomic\DeepFace\Enums\FaceRecognitionModel;

class RepresentResult
{
    public function __construct(
        public readonly string $img_path,
        public readonly array $embedding,
        public readonly FacialArea $facial_area,
        public readonly FaceRecognitionModel $model,
        public readonly Detector $detector_backend,
    ) {
    }
}
