<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MonitoringResultRepository")
 */
class MonitoringResult
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     * @Assert\DateTime()
     */
    private $checkDate;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive()
     */
    private $returnHttpStatusCode;

    /**
     * @ORM\Column(type="text")
     */
    private $returnedPayload;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MonitoredEndpoint", inversedBy="monitoringResults")
     * @ORM\JoinColumn(nullable=false)
     */
    private $monitoredEndpoint;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCheckDate(): ?\DateTimeInterface
    {
        return $this->checkDate;
    }

    public function setCheckDate(\DateTimeInterface $checkDate): self
    {
        $this->checkDate = $checkDate;

        return $this;
    }

    public function getReturnHttpStatusCode(): ?int
    {
        return $this->returnHttpStatusCode;
    }

    public function setReturnHttpStatusCode(int $returnHttpStatusCode): self
    {
        $this->returnHttpStatusCode = $returnHttpStatusCode;

        return $this;
    }

    public function getReturnedPayload(): ?string
    {
        return $this->returnedPayload;
    }

    public function setReturnedPayload(string $returnedPayload): self
    {
        $this->returnedPayload = $returnedPayload;

        return $this;
    }

    public function getMonitoredEndpoint(): ?MonitoredEndpoint
    {
        return $this->monitoredEndpoint;
    }

    public function setMonitoredEndpoint(?MonitoredEndpoint $monitoredEndpoint): self
    {
        $this->monitoredEndpoint = $monitoredEndpoint;

        return $this;
    }
}
