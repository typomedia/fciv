# File Checksum Integrity Verifier

[FCIV](https://archive.org/details/FCIV_v2_05) compatible lib for hash and verify files.

The Library is [PSR-1](https://www.php-fig.org/psr/psr-1/), [PSR-4](https://www.php-fig.org/psr/psr-4/), [PSR-12](https://www.php-fig.org/psr/psr-12/) compliant.

**Unit Tests have a Code Coverage of 100%!**

## Compatibility

- Windows
- POSIX (Linux, macOS, BSD, Solaris, etc.)

This library is fully compatible with `fciv.exe` v2.05.

## Requirements

- `>= PHP 7.4`

## Dependencies

- `none`

## Install

```
composer require typomedia/fciv
```

## Usage

### Verifier

```php
use Typomedia\Fciv\Verifier\Verifier;

$verifier = new Verifier(); // Options: string $algo = 'md5|sha1|both'
$result = $verifier->verify(file_get_contents('fciv.xml')); // Options: string $data, $exclude = [], $path = null
```

### Hasher

```php
use Typomedia\Fciv\Hasher\Hasher;

$hasher = new Hasher(); // Options: string $algo = 'md5|sha1|both', array $types = []
$hasher->setEntries('src'); // Options: string $path, array $exclude = []
$result = $hasher->getResult();
```
