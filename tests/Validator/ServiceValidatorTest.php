<?php

namespace App\Tests\Validator;

use App\Validator\MyCustomConstraint;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ServiceValidatorTest extends KernelTestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $container = static::getContainer();

        $this->validator = $container->get(ValidatorInterface::class);
    }

    public function testParam(): void
    {
        $errors = $this->validator->validate('string', new Assert\EqualTo('strong'));

        $this->assertEquals(1, $errors->count());
    }

    public function testParams(): void
    {
        $errors = $this->validator->validate(
            [
                'name' => 'string'
            ],
            new Assert\Collection([
                'name' => new Assert\EqualTo('strong')
            ])
        );

        $this->assertEquals(1, $errors->count());
    }

    public function testCustomConstraint(): void
    {
        $errors = $this->validator->validate(
            [
                'name' => 'string',
                'complex-value' => ['one' => ['two' => 'tree']]
            ],
            new MyCustomConstraint([
                'name' => 'strong'
            ])
        );

        $this->assertEquals(1, $errors->count());
    }
}