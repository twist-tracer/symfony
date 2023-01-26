<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MyCustomConstraintValidator extends ConstraintValidator
{
    /**
     * @param MyCustomConstraint $constraint
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!is_array($value)) {
            $this
                ->context
                ->buildViolation('Must be an array!')
                ->setCode(MyCustomConstraint::DATA_STRUCTURE_IS_NOT_VALID)
                ->addViolation();
        }

        foreach (['name', 'complex-value'] as $prop) {
            if (!isset($value[$prop])) {
                $this
                    ->context
                    ->buildViolation("The $prop must be set")
                    ->setCode(MyCustomConstraint::DATA_STRUCTURE_IS_NOT_VALID)
                    ->addViolation();
            }
        }

        if (!is_array($value['complex-value'])) {
            $this
                ->context
                ->buildViolation('The complex-structure must be an array!')
                ->setCode(MyCustomConstraint::DATA_STRUCTURE_IS_NOT_VALID)
                ->addViolation();
        }

        if ($value['name'] !== $constraint->name) {
            $this
                ->context
                ->buildViolation("The name must be {$constraint->name}")
                ->setCode(MyCustomConstraint::NAME_IS_NOT_VALID)
                ->addViolation();
        }
    }
}
