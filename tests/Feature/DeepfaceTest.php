<?php

use Astrotomic\DeepFace\Data\AnalyzeResult;
use Astrotomic\DeepFace\Data\ExtractFaceResult;
use Astrotomic\DeepFace\Data\RepresentResult;
use Astrotomic\DeepFace\Enums\Emotion;
use Astrotomic\DeepFace\Enums\Gender;
use Astrotomic\DeepFace\Enums\Race;
use PHPUnit\Framework\Assert;

it('version', function (): void {
    $version = $this->deepface()->version();

    Assert::assertSame('0.0.93', $version);
});

describe('verify', function (): void {
    it('verify: img1', function (): void {
        $img1 = $this->image('img1.jpg');
        $img2 = $this->image('img2.jpg');
        $result = $this->deepface()->verify($img1, $img2);

        Assert::assertTrue($result->verified);
        Assert::assertSame($img1, $result->img1_path);
        Assert::assertSame(339, $result->img1_facial_area->x);
        Assert::assertSame(218, $result->img1_facial_area->y);
        Assert::assertSame(768, $result->img1_facial_area->w);
        Assert::assertSame(768, $result->img1_facial_area->h);
        Assert::assertSame($img2, $result->img2_path);
        Assert::assertSame(524, $result->img2_facial_area->x);
        Assert::assertSame(201, $result->img2_facial_area->y);
        Assert::assertSame(491, $result->img2_facial_area->w);
        Assert::assertSame(491, $result->img2_facial_area->h);
    });
});

describe('analyze', function (): void {
    it('analyzes: img1', function (): void {
        $img = $this->image('img1.jpg');
        $results = $this->deepface()->analyze($img);

        Assert::assertCount(1, $results);
        Assert::assertContainsOnlyInstancesOf(AnalyzeResult::class, $results);

        $result = $results[0];

        Assert::assertSame($img, $result->img_path);
        Assert::assertSame(339, $result->facial_area->x);
        Assert::assertSame(218, $result->facial_area->y);
        Assert::assertSame(768, $result->facial_area->w);
        Assert::assertSame(768, $result->facial_area->h);
        Assert::assertSame(Emotion::HAPPY, $result->dominant_emotion);
        Assert::assertSame(Gender::WOMAN, $result->dominant_gender);
        Assert::assertSame(Race::LATINO_HISPANIC, $result->dominant_race);
    });
});

describe('extractFaces', function (): void {
    it('extractFaces: img1', function (): void {
        $img = $this->image('img1.jpg');
        $results = $this->deepface()->extractFaces($img);

        Assert::assertCount(1, $results);
        Assert::assertContainsOnlyInstancesOf(ExtractFaceResult::class, $results);

        $result = $results[0];

        Assert::assertSame($img, $result->img_path);
        Assert::assertSame(339, $result->facial_area->x);
        Assert::assertSame(218, $result->facial_area->y);
        Assert::assertSame(768, $result->facial_area->w);
        Assert::assertSame(768, $result->facial_area->h);
    });
});

describe('represent', function (): void {
    it('represent: img1', function (): void {
        $img = $this->image('img1.jpg');
        $results = $this->deepface()->represent($img);

        Assert::assertCount(1, $results);
        Assert::assertContainsOnlyInstancesOf(RepresentResult::class, $results);

        $result = $results[0];

        Assert::assertSame($img, $result->img_path);
        Assert::assertSame(339, $result->facial_area->x);
        Assert::assertSame(218, $result->facial_area->y);
        Assert::assertSame(768, $result->facial_area->w);
        Assert::assertSame(768, $result->facial_area->h);
        Assert::assertCount(4096, $result->embedding);
    });
});
