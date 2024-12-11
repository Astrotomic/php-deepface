<?php

namespace Astrotomic\DeepFace\Data;

use Astrotomic\DeepFace\Enums\Detector;
use Astrotomic\DeepFace\Enums\FaceRecognitionModel;
use JsonSerializable;

class RepresentResult implements JsonSerializable
{
    public function __construct(
        public readonly string $img_path,
        public readonly array $embedding,
        public readonly FacialArea $facial_area,
        public readonly FaceRecognitionModel $model,
        public readonly Detector $detector_backend,
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'img_path' => $this->img_path,
            'embedding' => $this->embedding,
            'facial_area' => $this->facial_area->jsonSerialize(),
            'model' => $this->model->value,
            'detector_backend' => $this->detector_backend->value,
        ];
    }
}
