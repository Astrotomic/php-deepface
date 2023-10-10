<?php

namespace Astrotomic\DeepFace\Data;

class FacialArea
{
    public function __construct(
        public readonly int $x,
        public readonly int $y,
        public readonly int $w,
        public readonly int $h,
    ) {
    }
}
