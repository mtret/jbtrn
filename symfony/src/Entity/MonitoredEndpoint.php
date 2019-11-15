<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotNull
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\Url
     * @Assert\NotBlank
     * @Assert\NotNull
     */
    private $url;

    /**
     * @Serializer\Type("DateTime<'Y-m-d H:i:s'>")
     * @ORM\Column(type="datetime")
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $dateCreated;

    /**
     * @Serializer\Type("DateTime<'Y-m-d H:i:s'>")
     * @ORM\Column(type="datetime")
     * @Assert\NotNull
     * @Assert\NotBlank
     */
    private $dateLastChecked;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotNull
     * @Assert\NotBlank
     * @Assert\Positive
     */
    private $monitoredInterval;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="monitoredEndpoints")
     * @Assert\NotNull
     * @Serializer\Exclude()
     */
    private $owner;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MonitoringResult", mappedBy="monitoredEndpoint", cascade={"remove"})
     * @Serializer\Exclude()
     * @OrderBy({"id" = "DESC"})
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

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
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

    /**
     * @param $limit
     * @return Collection|MonitoringResult[]
     */
    public function getMonitoringResultsLimited($limit)
    {
        return $this->monitoringResults->slice(0,$limit);
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

    /**
     * @param int $ownerId
     * @return bool
     */
    public function isSelfOwned($ownerId) {
        return $this->getOwner()->getId() == $ownerId;
    }
}
