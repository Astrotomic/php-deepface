<?php

use Astrotomic\DeepFace\Data\AnalyzeResult;
use Astrotomic\DeepFace\Enums\Emotion;
use Astrotomic\DeepFace\Enums\Gender;
use Astrotomic\DeepFace\Enums\Race;
use PHPUnit\Framework\Assert;

describe('analyze', function ():void {
    it('analyzes: img1', function ():void {
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
