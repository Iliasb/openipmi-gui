<?php

namespace App\Entity;

use App\Repository\DeviceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeviceRepository::class)]
class Device
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;


    #[ORM\ManyToOne(targetEntity: Rack::class, inversedBy: 'devices')]
    #[ORM\JoinColumn(nullable: false)]
    private $rack;

    #[ORM\OneToMany(mappedBy: 'device', targetEntity: Reservation::class, orphanRemoval: true)]
    private $reservations;

    #[ORM\ManyToOne(targetEntity: DeviceGroup::class, inversedBy: 'device')]
    #[ORM\JoinColumn(nullable: false)]
    private $deviceGroup;

    #[ORM\Column(type: 'string', length: 15, nullable: true)]
    private $ipv4;

    #[ORM\Column(type: 'string', length: 39, nullable: true)]
    private $ipv6;

    #[ORM\Column(type: 'integer')]
    private $positionStart;

    #[ORM\Column(type: 'integer')]
    private $positionEnd;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
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

    public function getRack(): ?Rack
    {
        return $this->rack;
    }

    public function setRack(?Rack $rack): self
    {
        $this->rack = $rack;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setDevice($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getDevice() === $this) {
                $reservation->setDevice(null);
            }
        }

        return $this;
    }

    public function getDeviceGroup(): ?DeviceGroup
    {
        return $this->deviceGroup;
    }

    public function setDeviceGroup(?DeviceGroup $deviceGroup): self
    {
        $this->deviceGroup = $deviceGroup;

        return $this;
    }

    public function getIpv4(): ?string
    {
        return $this->ipv4;
    }

    public function setIpv4(?string $ipv4): self
    {
        $this->ipv4 = $ipv4;

        return $this;
    }

    public function getIpv6(): ?string
    {
        return $this->ipv6;
    }

    public function setIpv6(?string $ipv6): self
    {
        $this->ipv6 = $ipv6;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getPositionStart(): ?int
    {
        return $this->positionStart;
    }

    public function setPositionStart(int $positionStart): self
    {
        $this->positionStart = $positionStart;

        return $this;
    }

    public function getPositionEnd(): ?int
    {
        return $this->positionEnd;
    }

    public function setPositionEnd(int $positionEnd): self
    {
        $this->positionEnd = $positionEnd;

        return $this;
    }

    
}
