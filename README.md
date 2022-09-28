
## Installation

Install with composer:
   
    composer require lbacik/object-collection

## Example

### Declaration

```php

use App\MyObject;
use Sushi\ObjectCollection

class MyObjectCollection extends ObjectCollection
{
    static string $type = MyObject::class;
}

```

### Usage

```php

$myCollection = new MyObjectCollection([
    new MyObject('foo'),
    new MyObject('bar'),
]);

```
