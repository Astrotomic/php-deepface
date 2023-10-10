<?php

namespace Astrotomic\DeepFace\Data;

use Astrotomic\DeepFace\Enums\Emotion;
use Astrotomic\DeepFace\Enums\Gender;
use Astrotomic\DeepFace\Enums\Race;

class AnalyzeResult
{
    /**
     * @param  array<Emotion, float>|null  $emotion
     * @param  array<Gender, float>|null  $gender
     * @param  array<Race, float>|null  $race
     */
    public function __construct(
        public readonly FacialArea $region,
        public readonly ?array $emotion,
        public readonly ?Emotion $dominant_emotion,
        public readonly ?int $age,
        public readonly ?array $gender,
        public readonly ?Gender $dominant_gender,
        public readonly ?array $race,
        public readonly ?Race $dominant_race,
    ) {
    }
}
