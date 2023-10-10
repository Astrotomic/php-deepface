# PHP DeepFace

## Installation

```bash
composer install astrotomic/php-deepface
```

## Configuration

```php
use Astrotomic\DeepFace\DeepFace;

$deepface = new DeepFace(
    python: '/usr/bin/python3',
);
```

## Usage

### Build Model

```php
$deepface->buildModel(\Astrotomic\DeepFace\Enums\FaceRecognitionModel::VGGFACE);
```

### Face Detection

```php
$deepface->extractFaces(
  img_path: '~/test.png',
);
```

### Face Verification

```php
$deepface->verify(
  img1_path: '~/test.png',
  img2_path: '~/id.jpg',
);
```

### Face recognition

```php
$deepface->find(
  img_path: '~/test.png',
  db_path: '~/db',
);
```

### Face Embeddings

_ToDo_

### Facial Attribute Analysis

```php
$deepface->analyze(
  img_path: '~/test.png',
);
```
