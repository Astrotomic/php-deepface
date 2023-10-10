<?php

namespace Astrotomic\DeepFace\Data;

use Astrotomic\DeepFace\Enums\Detector;
use Astrotomic\DeepFace\Enums\DistanceMetric;
use Astrotomic\DeepFace\Enums\FaceRecognitionModel;

class VerifyResult
{
    public function __construct(
        public readonly bool $verified,
        public readonly float $distance,
        public readonly float $threshold,
        public readonly FaceRecognitionModel $model,
        public readonly Detector $detector_backend,
        public readonly DistanceMetric $distance_metric,
        public readonly string $img1_path,
        public readonly FacialArea $img1_facial_area,
        public readonly string $img2_path,
        public readonly FacialArea $img2_facial_area,
        public readonly float $time,
    ) {
    }
}
