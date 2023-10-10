<?php

namespace Astrotomic\DeepFace\Data;

use Astrotomic\DeepFace\Enums\Detector;
use Astrotomic\DeepFace\Enums\DistanceMetric;
use Astrotomic\DeepFace\Enums\FaceRecognitionModel;
use JsonSerializable;

class VerifyResult implements JsonSerializable
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

    public function jsonSerialize(): array
    {
        return [
            'verified' => $this->verified,
            'distance' => $this->distance,
            'model' => $this->model->value,
            'detector_backend' => $this->detector_backend->value,
            'distance_metric' => $this->distance_metric->value,
            'img1_path' => $this->img1_path,
            'img1_facial_area' => $this->img1_facial_area->jsonSerialize(),
            'img2_path' => $this->img2_path,
            'img2_facial_area' => $this->img2_facial_area->jsonSerialize(),
            'time' => $this->time,
        ];
    }
}
