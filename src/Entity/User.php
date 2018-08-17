<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * The below length depends on the "algorithm" you use for encoding
     * the password, but this works well with bcrypt.
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ExpectedResults", mappedBy="user_id")
     */
    private $expectedResultsID;


    /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Wprowadz swoje zdjecie")
     * @Assert\File(mimeTypes={"image/jpeg","image/gif","image/png"})
     */
    private $brochure;

    public function getBrochure()
    {
        return $this->brochure;
    }

    public function setBrochure($brochure)
    {
        $this->brochure = $brochure;

        return $this;
    }


    public function __construct()
    {
        $this->role = '["ROLE_ADMIN"]';
        $this->expectedResultsID = new ArrayCollection();
    }

    // other properties and methods
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $role;

    public function getRole()
    {
        return $this->role;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        // The bcrypt and argon2i algorithms don't require a separate salt.
        // You *may* need a real salt if you choose a different encoder.
        return null;
    }

    public function getRoles()
    {

        $roles = $this->roles;
        $role = $this->role;
        if ( $role =='["ROLE_ADMIN"]'){
            $roles[] ='ROLE_ADMIN';
        }
        if ( $role =='["ROLE_USER"]'){
            $roles[] ='ROLE_USER';
        }

        return $roles;

    }

    public function eraseCredentials()
    {
    }

    public function fooAction(UserInterface $user)
    {
        $user_id = $user->getId();
    }


    /**
     * @return Collection|ExpectedResults[]
     */
    public function getExpectedResultsID(): Collection
    {
        return $this->expectedResultsID;
    }

    public function addExpectedResultsID(ExpectedResults $expectedResultsID): self
    {
        if (!$this->expectedResultsID->contains($expectedResultsID)) {
            $this->expectedResultsID[] = $expectedResultsID;
            $expectedResultsID->setUserId($this);
        }

        return $this;
    }

    public function removeExpectedResultsID(ExpectedResults $expectedResultsID): self
    {
        if ($this->expectedResultsID->contains($expectedResultsID)) {
            $this->expectedResultsID->removeElement($expectedResultsID);
            // set the owning side to null (unless already changed)
            if ($expectedResultsID->getUserId() === $this) {
                $expectedResultsID->setUserId(null);
            }
        }

        return $this;
    }

}