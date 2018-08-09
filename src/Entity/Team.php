<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamRepository")
 * @ORM\Entity
 * @UniqueEntity(
 *     fields={"name"},
 *     errorPath="name",
 *     message="This team is already existed."
 * )
 */
class Team
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     */
    private $name;


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
