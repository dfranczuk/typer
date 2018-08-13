<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ExpectedResultsRepository")
 */
class ExpectedResults
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $FirstTeamScore;

    /**
     * @ORM\Column(type="integer")
     */
    private $SecondTeamScore;

    public function getId()
    {
        return $this->id;
    }

    public function getFirstTeamScore(): ?int
    {
        return $this->FirstTeamScore;
    }

    public function setFirstTeamScore(int $FirstTeamScore): self
    {
        $this->FirstTeamScore = $FirstTeamScore;

        return $this;
    }

    public function getSecondTeamScore(): ?int
    {
        return $this->SecondTeamScore;
    }

    public function setSecondTeamScore(int $SecondTeamScore): self
    {
        $this->SecondTeamScore = $SecondTeamScore;

        return $this;
    }
}
