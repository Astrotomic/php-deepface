<?php

namespace Astrotomic\DeepFace\Enums;

enum AnalyzeAction: string
{
    case EMOTION = 'emotion';
    case AGE = 'age';
    case GENDER = 'gender';
    case RACE = 'race';
}
