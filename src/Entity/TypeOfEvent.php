<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeOfEventRepository")
 */
class TypeOfEvent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Tournament", mappedBy="TypeOfEvent")
     */
    private $Tournament;

    /**
     * @return mixed
     */
    public function getTournament()
    {
        return $this->Tournament;
    }

    /**
     * @param mixed $Tournament
     */
    public function setTournament($Tournament): void
    {
        $this->Tournament = $Tournament;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
    public function __toString()
    {
        return $this->name;
    }
}
