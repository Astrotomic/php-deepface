<?php

namespace Astrotomic\DeepFace;

use Astrotomic\DeepFace\Data\FaceArea;
use Astrotomic\DeepFace\Data\VerifyResult;
use Astrotomic\DeepFace\Enums\Detector;
use Astrotomic\DeepFace\Enums\DistanceMetric;
use Astrotomic\DeepFace\Enums\Model;
use Astrotomic\DeepFace\Enums\Normalization;
use InvalidArgumentException;
use SplFileInfo;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

class DeepFace
{
    protected ?string $python = null;

    public function __construct(string $python = null)
    {
        $this->python = $python ?? (new ExecutableFinder)->find(
            name: 'python3',
            default: 'python3',
        );
    }

    public function verify(
        string $img1_path,
        string $img2_path,
        bool $enforce_detection = true,
        bool $align = true,
        Model $model_name = Model::VGGFACE,
        Detector $detector_backend = Detector::OPENCV,
        DistanceMetric $distance_metric = DistanceMetric::COSINE,
        Normalization $normalization = Normalization::BASE,
    ): VerifyResult {
        $img1 = new SplFileInfo($img1_path);
        $img2 = new SplFileInfo($img2_path);

        if (! $img1->isFile()) {
            throw new InvalidArgumentException("The path [{$img1_path}] for image#1 is not a file.");
        }
        if (! $img2->isFile()) {
            throw new InvalidArgumentException("The path [{$img2_path}] for image#2 is not a file.");
        }

        $output = $this->run(
            filepath: __DIR__.'/../scripts/verify.py',
            data: [
                '{{img1_path}}' => $img1->getRealPath(),
                '{{img2_path}}' => $img2->getRealPath(),
                '{{enforce_detection}}' => $enforce_detection ? 'True' : 'False',
                '{{align}}' => $align ? 'True' : 'False',
                '{{model_name}}' => $model_name->value,
                '{{detector_backend}}' => $detector_backend->value,
                '{{distance_metric}}' => $distance_metric->value,
                '{{normalization}}' => $normalization->value,
            ],
            timeout: 60 * 5
        );

        return new VerifyResult(
            verified: $output['verified'] === 'True',
            distance: $output['distance'],
            threshold: $output['threshold'],
            model: Model::from($output['model']),
            detector_backend: Detector::from($output['detector_backend']),
            similarity_metric: DistanceMetric::from($output['similarity_metric']),
            img1_path: $img1->getRealPath(),
            img1_facial_area: new FaceArea(...$output['facial_areas']['img1']),
            img2_path: $img2->getRealPath(),
            img2_facial_area: new FaceArea(...$output['facial_areas']['img2']),
            time: $output['time'],
        );
    }

    protected function run(string $filepath, array $data, int $timeout): array
    {
        $script = $this->script($filepath, $data);
        $process = $this->process($script, $timeout);

        $output = $process->mustRun()->getOutput();

        return json_decode($output, true, 512, JSON_THROW_ON_ERROR);
    }

    protected function process(string $script, int $timeout): Process
    {
        $process = new Process([
            $this->python,
            '-c',
            $script,
        ]);

        return $process->setTimeout($timeout);
    }

    protected function script(string $filepath, $data): string
    {
        $template = file_get_contents($filepath);

        $script = trim(strtr($template, $data));

        return str_replace(PHP_EOL, ' ', $script);
    }
}
