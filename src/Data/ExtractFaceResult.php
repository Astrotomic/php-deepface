<?php

namespace Astrotomic\DeepFace\Data;

use Astrotomic\DeepFace\Enums\Detector;
use JsonSerializable;

class ExtractFaceResult implements JsonSerializable
{
    public function __construct(
        public readonly string $img_path,
        public readonly FacialArea $facial_area,
        public readonly float $confidence,
        public readonly Detector $detector_backend,
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'img_path' => $this->img_path,
            'facial_area' => $this->facial_area->jsonSerialize(),
            'confidence' => $this->confidence,
            'detector_backend' => $this->detector_backend->value,
        ];
    }
}
