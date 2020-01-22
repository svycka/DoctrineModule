<?php

namespace DoctrineModule\Validator\Service;

use PHPUnit\Framework\TestCase;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\ServiceManager\ServiceLocatorAwareInterface;
use DoctrineModule\Validator\NoObjectExists;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Interop\Container\ContainerInterface;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2017-09-04 at 11:12:27.
 *
 * @coversDefaultClass DoctrineModule\Validator\Service\NoObjectExistsFactory
 * @group validator
 */
class NoObjectExistsFactoryTest extends TestCase
{
    /**
     * @var NoObjectExistsFactory
     */
    private $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new NoObjectExistsFactory;
    }

    /**
     * @coversNothing
     */
    public function testCallable()
    {
        $this->assertIsCallable($this->object);
    }

    /**
     * @covers ::__invoke
     * @covers ::container
     * @covers ::getRepository
     * @covers ::getObjectManager
     * @covers ::getFields
     */
    public function testInvoke()
    {
        $options = [
            'target_class' => 'Foo\Bar',
            'fields'       => ['test'],
        ];

        $repository = $this->prophesize(ObjectRepository::class);
        $objectManager = $this->prophesize(ObjectManager::class);
        $objectManager->getRepository('Foo\Bar')
            ->shouldBeCalled()
            ->willReturn($repository->reveal());

        $container = $this->prophesize(ContainerInterface::class);
        $container->get('doctrine.entitymanager.orm_default')
            ->shouldBeCalled()
            ->willReturn($objectManager->reveal());

        $instance = $this->object->__invoke(
            $container->reveal(),
            NoObjectExists::class,
            $options
        );
        $this->assertInstanceOf(NoObjectExists::class, $instance);
    }

    /**
     * @covers ::__invoke
     * @covers ::container
     * @covers ::getRepository
     * @covers ::getObjectManager
     * @covers ::getFields
     */
    public function testInvokeWithObjectManagerGiven()
    {
        $repository = $this->prophesize(ObjectRepository::class);
        $objectManager = $this->prophesize(ObjectManager::class);
        $objectManager->getRepository('Foo\Bar')
            ->shouldBeCalled()
            ->willReturn($repository->reveal());

        $options = [
            'target_class'   => 'Foo\Bar',
            'object_manager' => $objectManager->reveal(),
            'fields'         => ['test'],
        ];

        $container = $this->prophesize(ContainerInterface::class);
        $container->get('doctrine.entitymanager.orm_default')
            ->shouldNotBeCalled();

        $instance = $this->object->__invoke(
            $container->reveal(),
            NoObjectExists::class,
            $options
        );
        $this->assertInstanceOf(NoObjectExists::class, $instance);
    }

    /**
     * @covers ::merge
     */
    public function testInvokeWithMerge()
    {
        $options = [
            'target_class' => 'Foo\Bar',
            'fields'       => ['test'],
            'messages'     => [
                NoObjectExists::ERROR_OBJECT_FOUND => 'test',
            ]
        ];

        $repository = $this->prophesize(ObjectRepository::class);
        $objectManager = $this->prophesize(ObjectManager::class);
        $objectManager->getRepository('Foo\Bar')
            ->shouldBeCalled()
            ->willReturn($repository->reveal());

        $container = $this->prophesize(ContainerInterface::class);
        $container->get('doctrine.entitymanager.orm_default')
            ->shouldBeCalled()
            ->willReturn($objectManager->reveal());

        $instance = $this->object->__invoke(
            $container->reveal(),
            NoObjectExists::class,
            $options
        );
        $templates = $instance->getMessageTemplates();
        $this->assertArrayHasKey(NoObjectExists::ERROR_OBJECT_FOUND, $templates);
        $this->assertSame('test', $templates[NoObjectExists::ERROR_OBJECT_FOUND]);
    }

    /**
     * @covers ::getRepository
     */
    public function testInvokeWithoutTargetClass()
    {
        $this->expectException(\DoctrineModule\Validator\Service\Exception\ServiceCreationException::class);

        $container = $this->prophesize(ContainerInterface::class);
        $this->object->__invoke(
            $container->reveal(),
            NoObjectExists::class,
            []
        );
    }

    /**
     * @covers ::createService
     * @covers ::setCreationOptions
     */
    public function testCreateService()
    {
        $options = [
            'target_class' => 'Foo\Bar',
            'fields'       => ['test'],
        ];

        $repository = $this->prophesize(ObjectRepository::class);
        $objectManager = $this->prophesize(ObjectManager::class);
        $objectManager->getRepository('Foo\Bar')
            ->shouldBeCalled()
            ->willReturn($repository->reveal());

        $container = $this->prophesize(ServiceLocatorInterface::class);
        $container->get('doctrine.entitymanager.orm_default')
            ->shouldBeCalled()
            ->willReturn($objectManager->reveal());

        $this->object->setCreationOptions($options);
        $instance = $this->object->createService($container->reveal());
        $this->assertInstanceOf(NoObjectExists::class, $instance);
    }

    /**
     * @covers ::container
     */
    public function testCreateServiceWithServiceLocatorAwareInterface()
    {
        if (!interface_exists(ServiceLocatorAwareInterface::class)) {
            $this->markTestSkipped('ServiceLocatorAwareInterface not defined');
        }

        $options = [
            'target_class' => 'Foo\Bar',
            'fields'       => ['test'],
        ];

        $repository = $this->prophesize(ObjectRepository::class);
        $objectManager = $this->prophesize(ObjectManager::class);
        $objectManager->getRepository('Foo\Bar')
            ->shouldBeCalled()
            ->willReturn($repository->reveal());

        $container = $this->prophesize(ServiceLocatorInterface::class);
        $container->get('doctrine.entitymanager.orm_default')
            ->shouldBeCalled()
            ->willReturn($objectManager->reveal());

        $parentContainer = $this->prophesize(ServiceLocatorInterface::class);
        $parentContainer->willImplement(ServiceLocatorAwareInterface::class);
        $parentContainer->getServiceLocator()
            ->shouldBeCalled()
            ->willReturn($container->reveal());

        $this->object->setCreationOptions($options);
        $instance = $this->object->createService($parentContainer->reveal());
        $this->assertInstanceOf(NoObjectExists::class, $instance);
    }
}
