<?php

namespace Tests;

use Astrotomic\DeepFace\DeepFace;
use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function deepface(): DeepFace
    {
        return new DeepFace();
    }

    protected function image(string $img): string
    {
        return realpath(__DIR__ . DIRECTORY_SEPARATOR . 'Fixtures'. DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $img);
    }
}
