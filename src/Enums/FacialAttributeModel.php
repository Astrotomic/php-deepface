<?php

namespace Astrotomic\DeepFace\Enums;

enum FacialAttributeModel: string
{
    case EMOTION = 'Emotion';
    case AGE = 'Age';
    case GENDER = 'Gender';
    case RACE = 'Race';
}
