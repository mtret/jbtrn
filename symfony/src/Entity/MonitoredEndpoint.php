<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MonitoredEndpointRepository")
 *
 */
class MonitoredEndpoint
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\Url
     */
    private $url;

    /**
     * @ORM\Column(type="date")
     * @Assert\DateTime()
     * @Gedmo\Timestampable(on="create")
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="date")
     * @Assert\DateTime()
     */
    private $dateLastChecked;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive()
     */
    private $monitoredInterval;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="monitoredEndpoints")
     * @Assert\NotNull()
     * @Serializer\Exclude()
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MonitoringResult", mappedBy="monitoredEndpoint")
     * @Serializer\Exclude()
     */
    private $monitoringResults;

    public function __construct()
    {
        $this->monitoringResults = new ArrayCollection();
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

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateLastChecked(): ?\DateTimeInterface
    {
        return $this->dateLastChecked;
    }

    public function setDateLastChecked($dateLastChecked): self
    {
        $this->dateLastChecked = $dateLastChecked;

        return $this;
    }

    public function getMonitoredInterval(): ?int
    {
        return $this->monitoredInterval;
    }

    public function setMonitoredInterval(int $monitoredInterval): self
    {
        $this->monitoredInterval = $monitoredInterval;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection|MonitoringResult[]
     */
    public function getMonitoringResults(): Collection
    {
        return $this->monitoringResults;
    }

    public function addMonitoringResult(MonitoringResult $monitoringResult): self
    {
        if (!$this->monitoringResults->contains($monitoringResult)) {
            $this->monitoringResults[] = $monitoringResult;
            $monitoringResult->setMonitoredEndpoint($this);
        }

        return $this;
    }

    public function removeMonitoringResult(MonitoringResult $monitoringResult): self
    {
        if ($this->monitoringResults->contains($monitoringResult)) {
            $this->monitoringResults->removeElement($monitoringResult);
            // set the owning side to null (unless already changed)
            if ($monitoringResult->getMonitoredEndpoint() === $this) {
                $monitoringResult->setMonitoredEndpoint(null);
            }
        }

        return $this;
    }
}
