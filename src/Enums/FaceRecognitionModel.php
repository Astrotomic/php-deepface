<?php

namespace Astrotomic\DeepFace\Enums;

enum FaceRecognitionModel: string
{
    case VGGFACE = 'VGG-Face';
    case FACENET = 'Facenet';
    case FACENET512 = 'Facenet512';
    case OPENFACE = 'OpenFace';
    case DEEPFACE = 'DeepFace';
    case DEEPID = 'DeepID';
    case ARCFACE = 'ArcFace';
    case DLIB = 'Dlib';
    case SFACE = 'SFace';
}
