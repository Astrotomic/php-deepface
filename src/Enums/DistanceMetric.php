<?php

namespace Astrotomic\DeepFace\Enums;

enum DistanceMetric: string
{
    case COSINE = 'cosine';
    case EUCLIDEAN = 'euclidean';
    case EUCLIDEAN_L2 = 'euclidean_l2';
}
