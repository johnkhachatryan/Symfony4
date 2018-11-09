<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    public function __construct()
    {
        $registers = new Collection();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $barcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $cost;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Register", mappedBy="product")
     * @ORM\JoinColumn(nullable=false)
     */
    private $registers;

    /**
     * @ORM\Column(type="integer")
     */
    private $vatclass;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    /**
     * @param string $barcode
     * @return Product
     */
    public function setBarcode(string $barcode): self
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param $cost
     * @return Product
     */
    public function setCost($cost): self
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getVatclass(): ?int
    {
        return $this->vatclass;
    }

    /**
     * @param int $vatclass
     * @return Product
     */
    public function setVatclass(int $vatclass): self
    {
        $this->vatclass = $vatclass;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getRegisters()
    {
        return $this->registers;
    }

    /**
     * @param mixed $registers
     */
    public function setRegisters($registers): void
    {
        $this->registers = $registers;
    }
}
