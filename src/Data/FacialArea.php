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
        public readonly ?int $left_eye,
        public readonly ?int $right_eye,
    ) {
    }

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
