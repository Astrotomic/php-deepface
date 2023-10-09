<?php

namespace Astrotomic\DeepFace\Data;

use Astrotomic\DeepFace\Enums\Detector;
use Astrotomic\DeepFace\Enums\DistanceMetric;
use Astrotomic\DeepFace\Enums\Model;

class VerifyResult
{
    public function __construct(
        public readonly bool $verified,
        public readonly float $distance,
        public readonly float $threshold,
        public readonly Model $model,
        public readonly Detector $detector_backend,
        public readonly DistanceMetric $similarity_metric,
        public readonly string $img1_path,
        public readonly FaceArea $img1_facial_area,
        public readonly string $img2_path,
        public readonly FaceArea $img2_facial_area,
        public readonly float $time,
    ) {
    }
}
