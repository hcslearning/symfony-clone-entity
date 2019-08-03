<?php

namespace App\Tests;

//use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\Direccion;

class CloneTest extends KernelTestCase {

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    /**
     * @var Direccion
     */
    private $direccion;

    protected function setUp(): void {
        $kernel = self::bootKernel();

        $this->em = $kernel
                ->getContainer()
                ->get('doctrine')
                ->getManager()
        ;

        $this->em->createQuery('DELETE App\Entity\Direccion d')->execute();
        $this->direccion = (new Direccion())
                ->setCalle("Las Higueras")
                ->setNumero("1955")
                ->setComuna("San Joaquín")
        ;
        $this->em->persist($this->direccion);
        $this->em->flush();
    }

    protected function tearDown(): void {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }

    private function _insertarDireccion(Direccion $direccion): void {
        $this->em->persist($direccion);
        $this->em->flush();
    }

    public function testClonacion() {
        $direccion = $this->em->getRepository(Direccion::class)->find($this->direccion->getId());
        $clonado = clone $direccion;
        
        $this->em->persist($clonado);
        $this->em->flush();
        
        $this->assertTrue(true);
    }

}
