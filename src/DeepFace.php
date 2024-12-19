<?php

namespace Astrotomic\DeepFace;

use Astrotomic\DeepFace\Data\AnalyzeResult;
use Astrotomic\DeepFace\Data\ExtractFaceResult;
use Astrotomic\DeepFace\Data\FacialArea;
use Astrotomic\DeepFace\Data\FindResult;
use Astrotomic\DeepFace\Data\RepresentResult;
use Astrotomic\DeepFace\Data\VerifyResult;
use Astrotomic\DeepFace\Enums\AnalyzeAction;
use Astrotomic\DeepFace\Enums\ColorFace;
use Astrotomic\DeepFace\Enums\Detector;
use Astrotomic\DeepFace\Enums\DistanceMetric;
use Astrotomic\DeepFace\Enums\Emotion;
use Astrotomic\DeepFace\Enums\FaceRecognitionModel;
use Astrotomic\DeepFace\Enums\FacialAttributeModel;
use Astrotomic\DeepFace\Enums\Gender;
use Astrotomic\DeepFace\Enums\Normalization;
use Astrotomic\DeepFace\Enums\Race;
use Astrotomic\DeepFace\Exceptions\DeepFaceException;
use BackedEnum;
use BadMethodCallException;
use InvalidArgumentException;
use SplFileInfo;
use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\Process;

class DeepFace
{
    protected ?string $python = null;

    public function __construct(?string $python = null)
    {
        $this->python = $python ?? (new ExecutableFinder)->find(
            name: 'python3',
            default: 'python3',
        );
    }

    public function version(): string
    {
        return $this->run(
            filepath: __DIR__.'/../scripts/version.py',
            data: [],
        );
    }

    public function buildModel(FaceRecognitionModel|FacialAttributeModel $model_name): bool
    {
        return $this->run(
            filepath: __DIR__.'/../scripts/build_model.py',
            data: [
                '{{model_name}}' => $model_name->value,
            ],
        );
    }

    public function verify(
        string $img1_path,
        string $img2_path,
        FaceRecognitionModel $model_name = FaceRecognitionModel::VGGFACE,
        Detector $detector_backend = Detector::OPENCV,
        DistanceMetric $distance_metric = DistanceMetric::COSINE,
        bool $enforce_detection = true,
        bool $align = true,
        int $expand_percentage = 0,
        Normalization $normalization = Normalization::BASE,
        bool $silent = false,
        ?int $threshold = null,
        bool $anti_spoofing = false,
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
                '{{img1_path}}' => str_replace('\\', '/', $img1->getRealPath()),
                '{{img2_path}}' => str_replace('\\', '/', $img2->getRealPath()),
                '{{enforce_detection}}' => $enforce_detection,
                '{{anti_spoofing}}' => $anti_spoofing,
                '{{align}}' => $align,
                '{{model_name}}' => $model_name,
                '{{detector_backend}}' => $detector_backend,
                '{{distance_metric}}' => $distance_metric,
                '{{normalization}}' => $normalization,
                '{{expand_percentage}}' => $expand_percentage,
                '{{silent}}' => $silent,
                '{{threshold}}' => $threshold,
            ],
        );

        return new VerifyResult(
            verified: $output['verified'],
            distance: $output['distance'],
            threshold: $output['threshold'],
            model: FaceRecognitionModel::from($output['model']),
            detector_backend: Detector::from($output['detector_backend']),
            distance_metric: DistanceMetric::from($output['similarity_metric']),
            img1_path: $img1->getRealPath(),
            img1_facial_area: new FacialArea(...$output['facial_areas']['img1']),
            img2_path: $img2->getRealPath(),
            img2_facial_area: new FacialArea(...$output['facial_areas']['img2']),
            time: $output['time'],
        );
    }

    /**
     * @return AnalyzeResult[]
     */
    public function analyze(
        string $img_path,
        array $actions = [AnalyzeAction::EMOTION, AnalyzeAction::AGE, AnalyzeAction::RACE, AnalyzeAction::GENDER],
        bool $enforce_detection = true,
        Detector $detector_backend = Detector::OPENCV,
        bool $align = true,
        int $expand_percentage = 0,
        bool $silent = false,
        bool $anti_spoofing = false,
    ): array {
        $img = new SplFileInfo($img_path);

        if (! $img->isFile()) {
            throw new InvalidArgumentException("The path [{$img_path}] for image is not a file.");
        }

        $actions = array_map(
            fn (mixed $action): AnalyzeAction => match (true) {
                is_string($action) => AnalyzeAction::from($action),
                $action instanceof AnalyzeAction => $action,
                default => throw new InvalidArgumentException('The action ['.gettype($action).'] provided is not a valid action type.'),
            },
            $actions
        );

        $output = $this->run(
            filepath: __DIR__.'/../scripts/analyze.py',
            data: [
                '{{img_path}}' => str_replace('\\', '/', $img->getRealPath()),
                '{{actions}}' => '['.implode(',', array_map(fn (AnalyzeAction $action) => "'{$action->value}'", $actions)).']',
                '{{enforce_detection}}' => $enforce_detection,
                '{{anti_spoofing}}' => $anti_spoofing,
                '{{detector_backend}}' => $detector_backend,
                '{{align}}' => $align,
                '{{silent}}' => $silent,
                '{{expand_percentage}}' => $expand_percentage,
            ],
        );

        return array_map(
            fn (array $result) => new AnalyzeResult(
                img_path: $img->getRealPath(),
                detector_backend: $detector_backend,
                facial_area: new FacialArea(...$result['region']),
                emotion: $result['emotion'] ?? null,
                dominant_emotion: isset($result['dominant_emotion']) ? Emotion::from($result['dominant_emotion']) : null,
                age: $result['age'] ?? null,
                gender: $result['gender'] ?? null,
                dominant_gender: isset($result['dominant_gender']) ? Gender::from($result['dominant_gender']) : null,
                race: $result['race'] ?? null,
                dominant_race: isset($result['dominant_race']) ? Race::from($result['dominant_race']) : null,
            ),
            $output
        );
    }

    /**
     * @return ExtractFaceResult[]
     */
    public function extractFaces(
        string $img_path,
        Detector $detector_backend = Detector::OPENCV,
        bool $enforce_detection = true,
        bool $align = true,
        int $expand_percentage = 0,
        bool $grayscale = false,
        ColorFace $color_face = ColorFace::RGB,
        bool $normalize_face = true,
        bool $anti_spoofing = false,
    ): array {
        $img = new SplFileInfo($img_path);

        if (! $img->isFile()) {
            throw new InvalidArgumentException("The path [{$img_path}] for image is not a file.");
        }

        $output = $this->run(
            filepath: __DIR__.'/../scripts/extract_faces.py',
            data: [
                '{{img_path}}' => str_replace('\\', '/', $img->getRealPath()),
                '{{enforce_detection}}' => $enforce_detection,
                '{{anti_spoofing}}' => $anti_spoofing,
                '{{detector_backend}}' => $detector_backend,
                '{{align}}' => $align,
                '{{grayscale}}' => $grayscale,
                '{{expand_percentage}}' => $expand_percentage,
                '{{color_face}}' => $color_face,
                '{{normalize_face}}' => $normalize_face,
            ],
        );

        return array_map(
            fn (array $result) => new ExtractFaceResult(
                img_path: $img->getRealPath(),
                facial_area: new FacialArea(...$result['facial_area']),
                confidence: $result['confidence'],
                detector_backend: $detector_backend,
            ),
            $output
        );
    }

    /**
     * @return FindResult[]
     */
    public function find(
        string $img_path,
        string $db_path,
        FaceRecognitionModel $model_name = FaceRecognitionModel::VGGFACE,
        DistanceMetric $distance_metric = DistanceMetric::COSINE,
        bool $enforce_detection = true,
        Detector $detector_backend = Detector::OPENCV,
        bool $align = true,
        int $expand_percentage = 0,
        ?float $threshold = null,
        Normalization $normalization = Normalization::BASE,
        bool $silent = false,
        bool $refresh_database = true,
        bool $anti_spoofing = false,
        bool $batched = false,
    ): array {
        $img = new SplFileInfo($img_path);
        $db = new SplFileInfo($db_path);

        if (! $img->isFile()) {
            throw new InvalidArgumentException("The path [{$img_path}] for image is not a file.");
        }

        if (! $db->isDir()) {
            throw new InvalidArgumentException("The path [{$db_path}] for database is not a directory.");
        }

        $output = $this->run(
            filepath: __DIR__.'/../scripts/find.py',
            data: [
                '{{img_path}}' => str_replace('\\', '/', $img->getRealPath()),
                '{{db_path}}' => $db->getRealPath(),
                '{{model_name}}' => $model_name,
                '{{distance_metric}}' => $distance_metric,
                '{{enforce_detection}}' => $enforce_detection,
                '{{anti_spoofing}}' => $anti_spoofing,
                '{{detector_backend}}' => $detector_backend,
                '{{align}}' => $align,
                '{{normalization}}' => $normalization,
                '{{silent}}' => $silent,
                '{{expand_percentage}}' => $expand_percentage,
                '{{threshold}}' => $threshold,
                '{{refresh_database}}' => $refresh_database,
                '{{batched}}' => $batched,
            ],
        );

        $result = [];
        foreach ($output['identity'] as $i => $identity) {
            $result[] = new FindResult(
                identity_img_path: $identity,
                source_img_path: $img->getRealPath(),
                source_facial_area: new FacialArea(
                    x: $output['source_x'][$i],
                    y: $output['source_y'][$i],
                    w: $output['source_w'][$i],
                    h: $output['source_h'][$i],
                    left_eye: null,
                    right_eye: null
                ),
                model: $model_name,
                detector_backend: $detector_backend,
                distance_metric: $distance_metric,
                distance: $output["{$model_name->value}_{$distance_metric->value}"][$i],
            );
        }

        return $result;
    }

    /**
     * @return RepresentResult[]
     */
    public function represent(
        string $img_path,
        FaceRecognitionModel $model_name = FaceRecognitionModel::VGGFACE,
        bool $enforce_detection = true,
        Detector $detector_backend = Detector::OPENCV,
        bool $align = true,
        int $expand_percentage = 0,
        Normalization $normalization = Normalization::BASE,
        bool $anti_spoofing = false,
        ?int $max_faces = null,
    ): array {
        $img = new SplFileInfo($img_path);

        if (! $img->isFile()) {
            throw new InvalidArgumentException("The path [{$img_path}] for image is not a file.");
        }

        $output = $this->run(
            filepath: __DIR__.'/../scripts/represent.py',
            data: [
                '{{img_path}}' => str_replace('\\', '/', $img->getRealPath()),
                '{{model_name}}' => $model_name,
                '{{enforce_detection}}' => $enforce_detection,
                '{{anti_spoofing}}' => $anti_spoofing,
                '{{detector_backend}}' => $detector_backend,
                '{{align}}' => $align,
                '{{normalization}}' => $normalization,
                '{{expand_percentage}}' => $expand_percentage,
                '{{max_faces}}' => $max_faces,
            ],
        );

        return array_map(
            fn (array $result) => new RepresentResult(
                img_path: $img->getRealPath(),
                embedding: $result['embedding'],
                facial_area: new FacialArea(...$result['facial_area']),
                model: $model_name,
                detector_backend: $detector_backend,
            ),
            $output
        );
    }

    protected function run(string $filepath, array $data): array|bool|string
    {
        $script = $this->script($filepath, $data);
        $process = $this->process($script);

        try {
            $output = $process
                ->mustRun()
                ->getOutput();
        } finally {
            unlink($script);
        }

        $errorOutput = $process->getErrorOutput();

        if (! empty($errorOutput)) {
            if (preg_match_all('/\{(?:[^{}]|(?R))*\}/', $errorOutput, $matches)) {
                $lastJson = end($matches[0]);
                $errorResult = json_decode($lastJson, true);

                if ($errorResult !== null && isset($errorResult['error'])) {
                    throw new DeepFaceException($errorResult['error']);
                } else {
                    throw new DeepFaceException('Failed to parse error message: '.$lastJson);
                }
            }
        }

        $lines = array_values(array_filter(explode(PHP_EOL, $output), function (string $line): bool {
            json_decode($line, true);

            return json_last_error() === JSON_ERROR_NONE;
        }));

        if (empty($lines)) {
            throw new BadMethodCallException('Python deepface script has not returned with any JSON.');
        }

        $json = $lines[0];

        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }

    protected function process(string $script): Process
    {
        $process = new Process([
            $this->python,
            $script,
        ]);

        return $process
            ->setTimeout(null)
            ->setIdleTimeout(60 * 5);
    }

    protected function script(string $filepath, $data): string
    {
        $data = array_map(fn (mixed $value): string => match (true) {
            $value instanceof BackedEnum => $value->value,
            is_bool($value) => $value ? 'True' : 'False',
            is_null($value) => 'None',
            default => (string) $value,
        }, $data);

        $template = file_get_contents($filepath);

        $script = trim(strtr($template, $data));

        $py = tempnam(sys_get_temp_dir(), 'deepface');

        file_put_contents($py, $script);
        chmod($py, 0666);

        return $py;
    }
}
