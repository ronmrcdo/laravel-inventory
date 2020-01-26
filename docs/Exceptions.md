# Exceptions

Here are the list of exceptions

1. InvalidAttributeException - it means there's an error regarding the given attribute or term.

```php

use Ronmrcdo\Inventory\Exceptions\InvalidAttributeException;

if ($err instanceof InvalidAttributeException) {
    // error
}
```

2. InvalidVariantException - it means that there's an error regarding the given variation

    ex. 

    1. A variation with an attribute of size: small and color: black, then you decided to create a new variation with same attributes.
    2. A duplicate sku.
    3. double attribute with different term. ex. Color: black, Color: White, Size: Small.


