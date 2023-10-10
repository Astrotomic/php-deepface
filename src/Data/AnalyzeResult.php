<?php

namespace Astrotomic\DeepFace\Data;

use Astrotomic\DeepFace\Enums\Detector;
use Astrotomic\DeepFace\Enums\Emotion;
use Astrotomic\DeepFace\Enums\Gender;
use Astrotomic\DeepFace\Enums\Race;
use JsonSerializable;

class AnalyzeResult implements JsonSerializable
{
    /**
     * @param  array<Emotion, float>|null  $emotion
     * @param  array<Gender, float>|null  $gender
     * @param  array<Race, float>|null  $race
     */
    public function __construct(
        public readonly string $img_path,
        public readonly Detector $detector_backend,
        public readonly FacialArea $facial_area,
        public readonly ?array $emotion,
        public readonly ?Emotion $dominant_emotion,
        public readonly ?int $age,
        public readonly ?array $gender,
        public readonly ?Gender $dominant_gender,
        public readonly ?array $race,
        public readonly ?Race $dominant_race,
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'img_path' => $this->img_path,
            'detector_backend' => $this->detector_backend->value,
            'region' => $this->facial_area->jsonSerialize(),
            'emotion' => $this->emotion,
            'dominant_emotion' => $this->dominant_emotion?->value,
            'age' => $this->age,
            'gender' => $this->gender,
            'dominant_gender' => $this->dominant_gender?->value,
            'race' => $this->race,
            'dominant_race' => $this->dominant_race?->value,
        ];
    }
}
