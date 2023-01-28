<?php

namespace App\Tests\Serializer;

use App\Entity\Person;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Serializer\SerializerInterface;

class SerializerTest extends KernelTestCase
{
    private SerializerInterface $serializer;

     protected function setUp(): void
    {
        parent::setUp();

        $container = static::getContainer();

        $this->serializer = $container->get(SerializerInterface::class);
    }

    /**
     * Object -> normalize to array -> encode to json
     *
     * @return void
     */
    public function testSerializeObjectToJson(): void
    {
        $person = new Person();
        $person->setName('foo');
        $person->setAge(99);
        $person->setSex('female');
        $person->setSportsperson(false);

        $this->assertEquals(
            '{"age":99,"name":"foo","gender":"female","sportsperson":false}',
            $this->serializer->serialize($person, 'json')
        );
    }

    /**
     * Xml -> decode to array -> denormalize to object
     *
     * @return void
     */
    public function testDeserializeXmlToObject(): void
    {
        $personXml = <<<EOF
<person>
    <name>foo</name>
    <age>99</age>
    <sportsperson>1</sportsperson>
    <gender>male</gender>
</person>
EOF;

        $person = new Person();
        $person->setName('foo');
        $person->setAge(99);
        $person->setSportsperson(true);
        $person->setSex('male');

        $this->assertEquals($person, $this->serializer->deserialize($personXml, Person::class, 'xml'));
    }

    public function testDeserializeDatetime(): void
    {
        $personXml = <<<EOF
<person>
    <name>foo</name>
    <age>99</age>
    <sportsperson>1</sportsperson>
    <createdAt>2020-11-18 17:30:01</createdAt>
</person>
EOF;

        $person = new Person();
        $person->setName('foo');
        $person->setAge(99);
        $person->setSportsperson(true);
        $person->setCreatedAt(new DateTime('2020-11-18 17:30:01'));

        $this->assertEquals($person, $this->serializer->deserialize($personXml, Person::class, 'xml'));
    }
}