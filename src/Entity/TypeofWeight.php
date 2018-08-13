<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeofWeightRepository")
 */
class TypeofWeight
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $Weight;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tournament", mappedBy="TypeOfEvent")
     */
    private $Game;

    /**
     * @return mixed
     */
    public function getGame()
    {
        return $this->Game;
    }

    /**
     * @param mixed $Game
     */
    public function setTournament($Game): void
    {
        $this->Game = $Game;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getWeight()
    {
        return $this->Weight;
    }

    public function setWeight(float $Weight): self
    {
        $this->Weight = $Weight;

        return $this;
    }

    public function __toString(): string

    {
        return $this->Weight;
    }
}
