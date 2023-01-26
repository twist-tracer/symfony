<?php

namespace App\Tests\Validator;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EntityValidatorTest extends KernelTestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        parent::setUp();

        $container = static::getContainer();

        $this->validator = $container->get(ValidatorInterface::class);
    }

    /**
     * @dataProvider okDataProvider
     */
    public function testUserParams(array $userParams, int $validationErrorsCount): void
    {
        $user = new User(...$userParams);

        $errors = $this->validator->validate($user);

        $this->assertEquals($validationErrorsCount, $errors->count());
    }

    public function okDataProvider(): iterable
    {
        return [
            [
                'userParams' => [
                    'name' => 'Michael'
                ],
                'validationErrorsCount' => 0
            ],
            [
                'userParams' => [
                    'name' => ''
                ],
                'validationErrorsCount' => 1
            ]
        ];
    }

}