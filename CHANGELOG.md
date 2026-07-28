# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased](https://github.com/cracksalad/PHPMailer-PGP/compare/v3.0.1...master)


## [v3.0.1](https://github.com/cracksalad/PHPMailer-PGP/compare/v3.0.0...v3.0.1) - 2026-07-28

### Changed

- Integrate Rector checks
- `PGPKeyManager::importKey()`, `PGPKeyManager::importKeyFile()` and `PGPKeyManager::deleteKey()` return bool values instead of being void

### Fixed

- Handling of `false` as a return value of `gnupg::import()`
- Compatibility to PHP <7.4 as well as >=8.5 versions


## [v3.0.0](https://github.com/cracksalad/PHPMailer-PGP/compare/v2.0.1...v3.0.0) - 2025-10-16

The only change compared to v2.0.1 is that PHPMailer v7.0 (containing breaking changes) is allowed ("phpmailer/phpmailer": "^6.0 || ^7.0").

### Changed

- Allow PHPMailer v7.0 (containing breaking changes)


## [v2.0.1](https://github.com/cracksalad/PHPMailer-PGP/compare/v2.0...v2.0.1) - 2025-09-18

### Changed

- Update tooling (psalm, phpunit, github actions)

### Fixed

- `PGPKeyManager::importKey()` allowed the import of invalid (disabled, expired, revoked) keys, which it prevents now


## [v2.0.0](https://github.com/cracksalad/PHPMailer-PGP/compare/v1.3.1...v2.0) - 2024-07-08

### Breaking Changes

- Some of the functionality of the `PHPMailerPGP`-class has been extracted to another class called `PGPKeyManager`. This new class is now responsible for `importKey()`, `importKeyFile()`, `deleteKey()`, `getKeys()` and `lookupKeyServer()`. If you are using any of these methods and you likely are, you have to change your code. Those methods have just been moved. There is no change in their signatures (other than the class name of course).
- The namespace of all classes contained in this library has changed from `PHPMailer\PHPMailer\` to `PHPMailer\PHPMailerPGP\`. This allows the developers of `PHPMailer` and us to use separated namespaces.

### Added

- There are tests now! Although the coverage is rather low right now (83 %), it will be increased in the future.


## [v1.3.1](https://github.com/cracksalad/PHPMailer-PGP/compare/v1.3...v1.3.1) - 2024-03-15

### Fixed

- syntax error in MIME encoding: A new line was missing to terminate headers of the multipart/mixed MIME container (this has caused blank e-mail content when adding attachments)
- not overwriting boundary variable from parent class (not really a problem, but a bad idea in general)
- when protecting headers with encrypted e-mails, the subject was not set correctly


## [v1.3.0](https://github.com/cracksalad/PHPMailer-PGP/compare/v1.2...v1.3) - 2024-02-24

### Added

- `deleteKey()`-method to be able to revert `importKey()`

### Changed

- Integrate Psalm type checks

### Fixed

- Some type issues and type annotations


## [v1.2.0](https://github.com/cracksalad/PHPMailer-PGP/compare/v1.1.1...v1.2) - 2024-02-23

### Added

- Key server lookup functionality with `lookupKeyServer()`


## [v1.1.1](https://github.com/cracksalad/PHPMailer-PGP/compare/v1.1...v1.1.1) - 2023-09-18

### Fixed

- Missing call to `initGNUPG()` in `getKeys()`


## [v1.1.0](https://github.com/cracksalad/PHPMailer-PGP/compare/v1.0.1...v1.1) - 2023-09-18

### Added

- New method `getKeys()` to check if there is a known encryption key for some address


## [v1.0.1](https://github.com/cracksalad/PHPMailer-PGP/compare/v1.0...v1.0.1) - 2023-09-17

### Fixed

- Deprecation warning passing null to parameter passphrase of `addsignkey`


## [v1.0.0](https://github.com/cracksalad/PHPMailer-PGP/releases/tag/v1.0) - 2023-04-24

### Added

- Composer support

### Removed

- PHPMailer itself from the repository and replaced it with a Composer dependency
