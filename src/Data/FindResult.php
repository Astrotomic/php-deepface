<?php

namespace Astrotomic\DeepFace\Data;

use Astrotomic\DeepFace\Enums\Detector;
use Astrotomic\DeepFace\Enums\DistanceMetric;
use Astrotomic\DeepFace\Enums\FaceRecognitionModel;
use JsonSerializable;

class FindResult implements JsonSerializable
{
    public function __construct(
        public readonly string $identity_img_path,
        public readonly string $source_img_path,
        public readonly FacialArea $source_facial_area,
        public readonly FaceRecognitionModel $model,
        public readonly Detector $detector_backend,
        public readonly DistanceMetric $distance_metric,
        public readonly float $distance,
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'identity_img_path' => $this->identity_img_path,
            'source_img_path' => $this->source_img_path,
            'source_facial_area' => $this->source_facial_area->jsonSerialize(),
            'model' => $this->model->value,
            'detector_backend' => $this->detector_backend->value,
            'distance_metric' => $this->distance_metric->value,
            'distance' => $this->distance,
        ];
    }
}
