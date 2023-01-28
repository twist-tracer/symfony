<?php

namespace App\Entity;

use DateTime;
use Symfony\Component\Serializer\Annotation\SerializedName;

class Person
{
    private int $age;

    private string $name;

    private bool $sportsperson;

    private ?DateTime $createdAt;

    #[SerializedName('gender')]
    public string $sex;

    public function getAge(): int
    {
        return $this->age;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function getSex(): string
    {
        return $this->sex;
    }

    public function isSportsperson(): bool
    {
        return $this->sportsperson;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setSportsperson(bool $sportsperson): void
    {
        $this->sportsperson = $sportsperson;
    }

    public function setCreatedAt(DateTime $createdAt = null): void
    {
        $this->createdAt = $createdAt;
    }

    public function setSex(string $sex): void
    {
        $this->sex = $sex;
    }

}