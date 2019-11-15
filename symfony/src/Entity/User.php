<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="guid")
     * @Assert\Uuid()
     */
    private $accessToken;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MonitoredEndpoint", mappedBy="owner")
     */
    private $monitoredEndpoints;

    public function __construct(\Symfony\Component\Security\Core\User\User $refreshedUser = null)
    {
        $this->monitoredEndpoints = new ArrayCollection();
    }

    public function getRoles() {
        return [];
    }

    public function getPassword()
    {
    }

    public function getSalt()
    {
    }

    public function getUsername() {
        return $this->getName();
    }

    public function eraseCredentials()
    {
    }

    public function getId(): ?int
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function setAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * @return Collection|MonitoredEndpoint[]
     */
    public function getMonitoredEndpoints(): Collection
    {
        return $this->monitoredEndpoints;
    }

    public function addMonitoredEndpoint(MonitoredEndpoint $monitoredEndpoint): self
    {
        if (!$this->monitoredEndpoints->contains($monitoredEndpoint)) {
            $this->monitoredEndpoints[] = $monitoredEndpoint;
            $monitoredEndpoint->setOwner($this);
        }

        return $this;
    }

    public function removeMonitoredEndpoint(MonitoredEndpoint $monitoredEndpoint): self
    {
        if ($this->monitoredEndpoints->contains($monitoredEndpoint)) {
            $this->monitoredEndpoints->removeElement($monitoredEndpoint);
            // set the owning side to null (unless already changed)
            if ($monitoredEndpoint->getOwner() === $this) {
                $monitoredEndpoint->setOwner(null);
            }
        }

        return $this;
    }
}
