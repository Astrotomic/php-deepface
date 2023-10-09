<?php

namespace Astrotomic\DeepFace\Enums;

enum Normalization: string
{
    case BASE = 'base';
    case RAW = 'raw';
    case FACENET = 'Facenet';
    case FACENET2018 = 'Facenet2018';
    case VGGFACE = 'VGGFace';
    case VGGFACE2 = 'VGGFace2';
    case ARCFACE = 'ArcFace';
}
