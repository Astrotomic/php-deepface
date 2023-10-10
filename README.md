# PHP DeepFace

## Installation

```bash
composer install astrotomic/php-deepface
```

## Configuration

Just instantiate the `Astrotomic\DeepFace\DeepFace` class, it will try to find your local python executable automatically.
```php
$deepface = new \Astrotomic\DeepFace\DeepFace();
```

In case you have a special python version you want to use, you can provide the path to the python executable as an argument.
```php
$deepface = new \Astrotomic\DeepFace\DeepFace(
    python: '/usr/bin/python3',
);
```

## Usage

### Build Model

This function builds a deepface face recognition or facial attribute model.

```php
$deepface->buildModel(\Astrotomic\DeepFace\Enums\FaceRecognitionModel::VGGFACE);
```

### Face Detection

This function applies pre-processing stages of a face recognition pipeline including detection and alignment.

```php
$deepface->extractFaces(
  img_path: '~/test.png',
);
```

### Face Verification

This function verifies an image pair is same person or different persons.
In the background, verification function represents facial images as vectors and then calculates the similarity between those vectors.
Vectors of same person images should have more similarity (or less distance) than vectors of different persons.

```php
$deepface->verify(
  img1_path: '~/test.png',
  img2_path: '~/id.jpg',
);
```

### Face recognition

This function applies verification several times and find the identities in a database.

```php
$deepface->find(
  img_path: '~/test.png',
  db_path: '~/db',
);
```

### Face Embeddings

This function represents facial images as vectors. 
The function uses convolutional neural networks models to generate vector embeddings.

_ToDo_

### Facial Attribute Analysis

This function analyzes facial attributes including age, gender, emotion and race. 
In the background, analysis function builds convolutional neural network models to classify age, gender, emotion and race of the input image.

```php
$deepface->analyze(
  img_path: '~/test.png',
);
```
