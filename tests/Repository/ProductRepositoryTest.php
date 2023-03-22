<?php

namespace App\Tests\Repository;

use App\Entity\Category;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Tests\TestCase;
use Doctrine\ORM\EntityManagerInterface;

class ProductRepositoryTest extends TestCase
{
    protected bool $refreshDataBase = true;
    private ?EntityManagerInterface $entityManager;

    private ProductRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $container = static::getContainer();
        $this->repository = $container->get(ProductRepository::class);
        $this->entityManager = $container->get(EntityManagerInterface::class);
    }

    public function testProductCreated(): void
    {
        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);

        $this->repository->save($product, true);

        $this->assertSame($product, $this->repository->findOneBy(['name' => 'Keyboard']));
    }

    public function testProductUpdated(): void
    {
        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);

        $this->repository->save($product, true);

        $product->setPrice(2500);
        $this->entityManager->flush(); // it's necessary for update

        $this->assertSame($product, $this->repository->findOneBy(['name' => 'Keyboard']));
    }

    public function testProductDelete(): void
    {
        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);

        $this->repository->save($product, true);

        $this->repository->remove($product, true);

        $this->assertNull($this->repository->findOneBy(['name' => 'Keyboard']));
    }

    public function testAddProductToCategory(): void
    {
        $category = new Category();
        $category->setName('common');

        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);
        $product->setCategory($category);

        $this->entityManager->persist($category);
        $this->entityManager->persist($product);
        $this->entityManager->flush();

        $this->assertSame($product, $this->repository->findOneBy(['name' => 'Keyboard']));
    }

    protected function tearDown(): void
    {
        $this->entityManager->close();
        $this->entityManager = null;

        parent::tearDown();
    }
}
