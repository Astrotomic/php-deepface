<?php

namespace Astrotomic\DeepFace\Data;

class FaceArea
{
    public function __construct(
        public readonly int $x,
        public readonly int $y,
        public readonly int $w,
        public readonly int $h,
    ) {
    }
}
