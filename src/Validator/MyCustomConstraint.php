<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class MyCustomConstraint extends Constraint
{
    public const DATA_STRUCTURE_IS_NOT_VALID = 'c4621319-4a95-4771-bd77-778baa526e5d';
    public const NAME_IS_NOT_VALID = 'f1749c70-bd83-4b09-8397-7af99142ece6';

    public const ERROR_NAMES = [
        self::DATA_STRUCTURE_IS_NOT_VALID => 'DATA_STRUCTURE_IS_NOT_VALID',
        self::NAME_IS_NOT_VALID => 'NAME_IS_NOT_VALID',
    ];

    public string $name;
}