# cakephp-libs Password tools

## Generation

Generate a complex password of 10 characters.

```php
$password = \Ecl\Auth\Password::generate();
```

Possible options :

* **size** (10): Password length
* **minimalLower** (2): Minimal wanted lowers
* **minimalUpper** (2): Minimal wanted uppers
* **minimalDigit** (2): minimal wanted digits
* **minimalSymbol** (2): minimal wanted symbols
* **lowers** (abcdefghijkmnopqrstuvwxyz): Lowers used
* **uppers** (ABCDEFGHJKLMNPQRSTUVWXYZ): Uppers used
* **digits** (1234567890): Digits used
* **symbols** (!*#+=:,-_?): Symbols used

Example:

```php
$password = \Ecl\Auth\Password::generate([
    'size' => 4,
    'minimalLower' => 1,
    'minimalUpper' => 1,
    'minimalDigit' => 1,
    'minimalSymbol' => 1,
    'lowers' => 'a',
    'uppers' => 'B',
    'digits' => '3',
    'symbols' => '#',
]);
```

This should generate a password with 4 characters with `a` `B` `3` and `#` in random positions

## Validation

You can validate your passwords with included provider.

```php
use Cake\Validation\Validator;

public function validationPassword(Validator $validator)
{
    $validator->setProvider('password', 'Ecl\Validation\Password');

    $validator->add('password', [
            'short' => [
                'rule' => ['minLength', 10],
                'message' => __d('validation', 'Le mot de passe doit contenir 10 caractères'),
            ],
            'minimalLowercase' => [
                'provider' => 'password', 'rule' => ['minimalLowercase', 1],
                'message' => __d('validation', 'Minimum 1 lettre en minuscule'),
            ],
            'minimalUppercase' => [
                'provider' => 'password', 'rule' => ['minimalUppercase', 1],
                'message' => __d('validation', 'Minimum 1 lettre en majuscule'),
            ],
            'minimalDigit' => [
                'provider' => 'password', 'rule' => ['minimalDigit', 1],
                'message' => __d('validation', 'Minimum 1 chiffre'),
            ],
            'validLowers' => [
                'provider' => 'password', 'rule' => 'validateLowers',
            ],
            'validUppers' => [
                'provider' => 'password', 'rule' => 'validateUppers',
            ],
            'validSymbols' => [
                'provider' => 'password', 'rule' => 'validateSymbols',
                'message' => __d('validation', 'Ne peut contenir que les symboles suivants : {0}', '!*#+=:,-_?'),
            ],
        ]);

    return $validator;
}
```
