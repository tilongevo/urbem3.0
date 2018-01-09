# CodeItNow Barcode Generator
Symfony2 Barcode generator library by [CodeItNow](http://www.codeitnow.in). You can use it with Custom PHP application or any PHP Framework such as Laravel, Cakephp, Yii, Codeigneter etc.

## Installation - 
CodeItNow Barcode Generator can install by composer.

```
composer require codeitnowin/barcode
``` 

## Uses -
Symfony2 Barcode Generator library give output as base64 encoded png image.

### Example - Code128:
```php
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

$barcode = new BarcodeGenerator();
$barcode->setText("0123456789");
$barcode->setType(BarcodeGenerator::Code128);
$barcode->setScale(2);
$barcode->setThickness(25);
$code = $barcode->generate();

echo '<img src="data:image/png;base64,'.$code.'" />';
```

### Example - Codabar:
```php
$barcode->setText("A0123456789C");
$barcode->setType(BarcodeGenerator::Codabar);
```

### Example - Code11:
```php
$barcode->setText("0123456789");
$barcode->setType(BarcodeGenerator::Code11);
```

### Example - Code39:
```php
$barcode->setText("0123456789");
$barcode->setType(BarcodeGenerator::Code39);
```

### Example - Code39-Extended:
```php
$barcode->setText("0123456789");
$barcode->setType(BarcodeGenerator::Code39Extended);
```

### Example - Ean128:
```php
$barcode->setText("00123456789012345675");
$barcode->setType(BarcodeGenerator::Ean128);
```

### Example - Gs1128:
```php
$barcode->setText("00123456789012345675");
$barcode->setType(BarcodeGenerator::Gs1128);
```

### Example - I25:
```php
$barcode->setText("00123456789012345675");
$barcode->setType(BarcodeGenerator::I25);
```

### Example - Isbn:
```php
$barcode->setText("0012345678901");
$barcode->setType(BarcodeGenerator::Isbn);
```

### Example - Msi:
```php
$barcode->setText("0012345678901");
$barcode->setType(BarcodeGenerator::Msi);
```

### Example - Postnet:
```php
$barcode->setText("01234567890");
$barcode->setType(BarcodeGenerator::Postnet);
```

### Example - S25:
```php
$barcode->setText("012345678901");
$barcode->setType(BarcodeGenerator::S25);
```

### Example - Upca:
```php
$barcode->setText("012345678901");
$barcode->setType(BarcodeGenerator::Upca);
```

### Example - Upca:
```php
$barcode->setText("012345");
$barcode->setType(BarcodeGenerator::Upce);
```