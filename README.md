# Collections
[![Build Status](https://scrutinizer-ci.com/g/Yoshi2889/collections/badges/build.png?b=3.0)](https://scrutinizer-ci.com/g/Yoshi2889/collections/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Yoshi2889/collections/badges/quality-score.png?b=3.0)](https://scrutinizer-ci.com/g/Yoshi2889/collections/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/yoshi2889/collections/v/stable)](https://packagist.org/packages/yoshi2889/collections)
[![Latest Unstable Version](https://poser.pugx.org/yoshi2889/collections/v/unstable)](https://packagist.org/packages/yoshi2889/collections)
[![Total Downloads](https://poser.pugx.org/yoshi2889/collections/downloads)](https://packagist.org/packages/yoshi2889/collections)

Simple Collection class allowing storage of specific data, based on PHP's ArrayObject.

## Installation
You can install this class via `composer`:

```composer require yoshi2889/collections```

## Usage
To use a Collection, create a new instance:

```php
$validationClosure = function ($value)
{
    return is_string($value);
};

$initialItems = ['This is a test value!', 'This is another test value!'];

$collection = new \Yoshi2889\Collections\Collection($validationClosure, $initialItems);
```

Note that the closure passed as the first parameter to the `Collection` constructur **MUST** return a boolean value.
This function is used to validate any added data types. A returned value of true means the given value may be added to the collection.

The second parameter can contain any initial values which should be in the collection. These items will also be validated.

## License
This code is released under the MIT License. Please see `LICENSE` to read it.