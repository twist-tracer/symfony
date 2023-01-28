<?php

namespace App\Serializer\ObjectNormalizer;

use DateTime;
use Exception;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\PropertyAccess\PropertyPathInterface;

class MyPropertyAccessor extends PropertyAccessor
{
    /**
     * @throws Exception
     */
    public function setValue(object|array &$objectOrArray, PropertyPathInterface|string $propertyPath, mixed $value)
    {
        $propertyPath === 'createdAt' && $value !== null
            ? parent::setValue($objectOrArray, $propertyPath, new DateTime($value))
            : parent::setValue($objectOrArray, $propertyPath, $value);
    }

    public function getValue(object|array $objectOrArray, PropertyPathInterface|string $propertyPath): mixed
    {
        if ($propertyPath === 'createdAt' && $objectOrArray->getCreatedAt() instanceof DateTime) {
            return $objectOrArray->getCreatedAt()->format('Y-m-d H:i:s');
        }

        return parent::getValue($objectOrArray, $propertyPath);
    }
}