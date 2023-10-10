<?php

namespace Astrotomic\DeepFace\Data;

use Astrotomic\DeepFace\Enums\Detector;
use Astrotomic\DeepFace\Enums\DistanceMetric;
use Astrotomic\DeepFace\Enums\FaceRecognitionModel;

class FindResult
{
    public function __construct(
        public readonly string $identity_img_path,
        public readonly string $source_img_path,
        public readonly FacialArea $source_facial_area,
        public readonly FaceRecognitionModel $model,
        public readonly Detector $detector_backend,
        public readonly DistanceMetric $distance_metric,
        public readonly float $distance,
    ) {
    }
}
