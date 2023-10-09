<?php

namespace Astrotomic\DeepFace\Enums;

enum Detector: string
{
    case OPENCV = 'opencv';
    case SSD = 'ssd';
    case DLIB = 'dlib';
    case MTCNN = 'mtcnn';
    case RETINAFACE = 'retinaface';
    case MEDIAPIPE = 'mediapipe';
    case YOLOV8 = 'yolov8';
    case YUNET = 'yunet';
}
