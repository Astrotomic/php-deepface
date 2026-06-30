<?php

namespace Astrotomic\DeepFace\Data;

use JsonSerializable;

class FacialArea implements JsonSerializable
{
    public function __construct(
        public readonly int $x,
        public readonly int $y,
        public readonly int $w,
        public readonly int $h,
        public readonly int|array|null $left_eye,
        public readonly int|array|null $right_eye,
        public readonly int|array|null $nose,
        public readonly int|array|null $mouth_left,
        public readonly int|array|null $mouth_right,
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'x' => $this->x,
            'y' => $this->y,
            'w' => $this->w,
            'h' => $this->h,
        ];
    }
}
