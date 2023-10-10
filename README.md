# PHP DeepFace

[![Latest Version](http://img.shields.io/packagist/v/astrotomic/php-deepface.svg?label=Release&style=for-the-badge)](https://packagist.org/packages/astrotomic/php-deepface)
[![MIT License](https://img.shields.io/github/license/Astrotomic/php-deepface.svg?label=License&color=blue&style=for-the-badge)](https://github.com/Astrotomic/php-deepface/blob/master/LICENSE)
[![Offset Earth](https://img.shields.io/badge/Treeware-%F0%9F%8C%B3-green?style=for-the-badge)](https://plant.treeware.earth/Astrotomic/php-deepface)
[![Larabelles](https://img.shields.io/badge/Larabelles-%F0%9F%A6%84-lightpink?style=for-the-badge)](https://www.larabelles.com/)

[![PHP Version](https://img.shields.io/packagist/dependency-v/astrotomic/php-deepface/php?style=flat-square&label=PHP)](https://packagist.org/packages/astrotomic/php-deepface)
[![Symfony Version](https://img.shields.io/packagist/dependency-v/astrotomic/php-deepface/symfony/process?style=flat-square&label=Symfony)](https://packagist.org/packages/astrotomic/php-deepface)

[![pint](https://img.shields.io/github/actions/workflow/status/Astrotomic/php-deepface/pint.yml?style=flat-square&logo=github&logoColor=white&label=CS)](https://github.com/Astrotomic/php-deepface/actions/workflows/pint.yml)
[![Total Downloads](https://img.shields.io/packagist/dt/astrotomic/php-deepface.svg?label=Downloads&style=flat-square)](https://packagist.org/packages/astrotomic/php-deepface)
[![Trees](https://img.shields.io/ecologi/trees/astrotomic?style=flat-square)](https://forest.astrotomic.info)
[![Carbon](https://img.shields.io/ecologi/carbon/astrotomic?style=flat-square)](https://forest.astrotomic.info)

## Installation

First you have to install the [deepface](https://github.com/serengil/deepface/tree/master#installation--) python framework.
```bash
pip install deepface
```

After that you can install the PHP adapter via composer.
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


## Testing

```bash
composer fix
```

## Contributing

Please see [CONTRIBUTING](https://github.com/Astrotomic/.github/blob/master/CONTRIBUTING.md) for details. You could also be interested in [CODE OF CONDUCT](https://github.com/Astrotomic/.github/blob/master/CODE_OF_CONDUCT.md).

### Security

If you discover any security related issues, please check [SECURITY](https://github.com/Astrotomic/.github/blob/master/SECURITY.md) for steps to report it.

## Credits

-   [Tom Herrmann](https://github.com/Gummibeer)
-   [Sefik Ilkin Serengil](https://github.com/serengil) _the creator of [deepface](https://github.com/serengil/deepface)_
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Treeware

You're free to use this package, but if it makes it to your production environment I would highly appreciate you buying the world a tree.

It’s now common knowledge that one of the best tools to tackle the climate crisis and keep our temperatures from rising above 1.5C is to [plant trees](https://www.bbc.co.uk/news/science-environment-48870920). If you contribute to my forest you’ll be creating employment for local families and restoring wildlife habitats.

You can buy trees at [offset.earth/treeware](https://plant.treeware.earth/Astrotomic/php-deepface)
