<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ScoreboardRepository")
 */
class Scoreboard
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @var Tournament
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tournament")
     * @ORM\JoinColumn(nullable=true)
     */
    private $tournament;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $points;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ExpectedResults", mappedBy="ScoreboardID")
     */
    private $ExpectedResultsID;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $UserName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $usrid;



    public function __construct()
    {
        $this->ExpectedResultsID = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUser(): ?id
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getTournament(): ?int
    {
        return $this->tournament;
    }

    public function setTournament(Tournament $tournament): self
    {
        $this->tournament = $tournament;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(?int $points): self
    {
        $this->points = $points;

        return $this;

    }

    public function __toString(): string

    {
        return $this->user;
    }

    /**
     * @return Collection|ExpectedResults[]
     */
    public function getExpectedResultsID(): Collection
    {
        return $this->ExpectedResultsID;
    }

    public function addExpectedResultsID(ExpectedResults $expectedResultsID): self
    {
        if (!$this->ExpectedResultsID->contains($expectedResultsID)) {
            $this->ExpectedResultsID[] = $expectedResultsID;
            $expectedResultsID->setScoreboardID($this);
        }

        return $this;
    }

    public function removeExpectedResultsID(ExpectedResults $expectedResultsID): self
    {
        if ($this->ExpectedResultsID->contains($expectedResultsID)) {
            $this->ExpectedResultsID->removeElement($expectedResultsID);
            // set the owning side to null (unless already changed)
            if ($expectedResultsID->getScoreboardID() === $this) {
                $expectedResultsID->setScoreboardID(null);
            }
        }

        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->UserName;
    }

    public function setUserName(?string $UserName): self
    {
        $this->UserName = $UserName;

        return $this;
    }

    public function getUsrid(): ?int
    {
        return $this->usrid;
    }

    public function setUsrid(?int $usrid): self
    {
        $this->usrid = $usrid;

        return $this;
    }


}
