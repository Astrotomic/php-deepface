# PHP DeepFace: Advanced Face Recognition for PHP

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

Welcome to PHP DeepFace, a powerful face recognition and facial attribute analysis package for PHP. With PHP DeepFace, you can effortlessly integrate cutting-edge deep learning models into your PHP applications for a wide range of face-related tasks. Here's how you can get started:

## Installation

To get started, you'll need to install the [deepface](https://github.com/serengil/deepface/tree/master#installation--) Python framework. You can do this using pip:

```bash
pip install deepface
```

Once you've installed deepface, you can then install the PHP adapter via Composer:

```bash
composer install astrotomic/php-deepface
```

## Configuration

Configuring PHP DeepFace is a breeze. Simply instantiate the `Astrotomic\DeepFace\DeepFace` class, and it will automatically detect your local Python executable:

```php
$deepface = new \Astrotomic\DeepFace\DeepFace();
```

If you have a specific Python version you'd like to use, you can provide the path to the Python executable as an argument:

```php
$deepface = new \Astrotomic\DeepFace\DeepFace(
    python: '/usr/bin/python3',
);
```

## Usage

PHP DeepFace provides a wide range of functionalities for face recognition and facial attribute analysis. Here are some key features:

### Build Model

You can build a deepface face recognition or facial attribute model with ease:

```php
$deepface->buildModel(\Astrotomic\DeepFace\Enums\FaceRecognitionModel::VGGFACE);
```

### Face Detection

Perform face detection and alignment using this function:

```php
$deepface->extractFaces(
  img_path: '~/test.png',
);
```

### Face Verification

Verify whether two images belong to the same person or different persons. This function calculates the similarity between facial image vectors:

```php
$deepface->verify(
  img1_path: '~/test.png',
  img2_path: '~/id.jpg',
);
```

### Face Recognition

Find identities in a database by applying verification multiple times:

```php
$deepface->find(
  img_path: '~/test.png',
  db_path: '~/db',
);
```

### Face Embeddings

Generate vector embeddings for facial images using convolutional neural networks models (To Do).

### Facial Attribute Analysis

Analyze facial attributes including age, gender, emotion, and race. This function builds convolutional neural network models to classify these attributes:

```php
$deepface->analyze(
  img_path: '~/test.png',
);
```

## Testing

Run tests to ensure everything is working as expected:

```bash
composer fix
```

## Contributing

We welcome contributions! Please see our [CONTRIBUTING](https://github.com/Astrotomic/.github/blob/master/CONTRIBUTING.md) guidelines for details. You may also want to review our [CODE OF CONDUCT](https://github.com/Astrotomic/.github/blob/master/CODE_OF_CONDUCT.md).

### Security

If you discover any security-related issues, please follow the steps outlined in our [SECURITY](https://github.com/Astrotomic/.github/blob/master/SECURITY.md) guidelines to report them.

## Credits

- [Tom Herrmann](https://github.com/Gummibeer)
- [Sefik Ilkin Serengil](https://github.com/serengil), the creator of [deepface](https://github.com/serengil/deepface)
- [All Contributors](../../contributors)

## License

PHP DeepFace is released under the MIT License. Please see the [License File](LICENSE.md) for more information.

## Treeware

You're free to use this package, but if it makes it to your production environment, we kindly request that you contribute to a greener world by planting a tree.
Trees play a vital role in combating climate change and preserving our environment.
You can buy trees at [offset.earth/treeware](https://plant.treeware.earth/Astrotomic/php-deepface). Help us make a positive impact! 🌳
