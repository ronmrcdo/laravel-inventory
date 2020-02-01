# Attribute and Terms

Product attributes are options to enable product to have a variation

### Creating Product attribute and term

There are two built-in functions in creating a product attribute. if there's an error occured during the creation of attribute or term it will throw an ```InvalidAttributeException```

```php

// Create single attribute
$product->addAttribute('size');

// Create multiple attribute
$product->addAttributes([
    ['name' => 'size'],
    ['name' => 'color']
]);
```

### Adding Term on attributes

Terms are the values of attribute e.g for size (attribute) - small, medium, large (terms) and for color (attribute) - white, black and etc. (terms)


```php

/**
 * @param string $attribute
 * @param array[String] $terms
 **/
$product->addAttributeTerm('size', ['small', 'medium', 'large']);
```

### Removing Product Attribute and Terms

Any error that will occur during removal of attribute or term will throw an ```InvalidAttributeException```

```php
// Remove Attribute, take note that terms, skus, and stocks will also be deleted when
// attribute is already established in the database.
$product->removeAttribute('size');

// Remove Attribute, take note that skus, and stocks will also be deleted when
// attribute term is already established in the database.
// Don't delete attributes or terms when it's already inserted in stocks or product skus
$product->removeAttributeTerm('size', 'small');
```

### Buil-in functions questions and others.

```php
// check if product has a attributes
$product->hasAttributes(); 

// check if product has a given attribute
$product->hasAttribute('size');

// Load product attributes and it's terms
$product->loadAttributes();
```