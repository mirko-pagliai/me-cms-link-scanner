# 1.x branch
## 1.5 branch
### 1.5.0
* the old `MenuHelper` class has been removed and replaced with `LinkScannerMenuHelper`. The helper is set in the
  bootstrap, with the `'MeCms/LinkScanner.MenuHelpers` config key, as requested by `me-cms` 2.32.0;
* fixed little bug, cache files are no longer erroneously shown, but only the files in the main directory.

## 1.4 branch
### 1.4.2
* updated for me-cms 2.31.9.

### 1.4.1
* updated for mirko-pagliai/cakephp-link-scanner 1.1.16.

### 1.4.0
* updated for me-cms 2.31.1;
* removed useless `AppView` class.

## 1.3 branch
### 1.3.4
* fixed a small bug in sorting results by date in the admin panel.

### 1.3.3
* updated for me-cms 2.30.10.

### 1.3.2-RC3
* improved `LinkScannerController::index()` method;
* small and numerous improvements of descriptions, tags and code suggested
  by PhpStorm.

### 1.3.1-RC2
* updated for me-cms 2.30.8-RC5.

### 1.3.0-RC1
* numerous code adjustments for improvement and adaptation to PHP 7.4 new features;
* updated for PHP 8.1 Requires at least PHP 7.4.

## 1.2 branch
### 1.2.1
* improvement of function descriptions and tags, increased the level of `phpstan`.

### 1.2.0
* changed namespace: `MeCms\LinkScanner`. The new i18n domain is `me_cms/link_scanner`;
* ready for `phpunit` 9.0.

## 1.1 branch
### 1.1.2
* updated for `me-cms` 2.29.5 and `php-tools` 1.4.5;
* added `phpstan`.

### 1.1.1
* updated dependencies.

### 1.1.0
* updated for `cakephp` 4 and `phpunit` 8;
* added pot template and italian translation.

## 1.0 branch
### 1.0.2
* little fixes;
* added tests.

### 1.0.1
* updated for `me-cms` `2.27`.

### 1.0.0-beta1
* first release.
