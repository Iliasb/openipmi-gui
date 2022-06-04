<?php

namespace App\Entity;

use App\Repository\DeviceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

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

    #[ORM\Column(type: 'integer')]
    private $positionStart;

    #[ORM\Column(type: 'integer')]
    private $positionEnd;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $serialNr;

    #[ORM\ManyToOne(targetEntity: Project::class, inversedBy: 'devices')]
    private $project;

    #[ORM\OneToMany(mappedBy: 'device', targetEntity: Address::class)]
    private $addresses;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;



    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'date')]
    private $created;


    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: 'date')]
    private $updated;


    public function getCreated()
    {
        return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->addresses = new ArrayCollection();
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

    public function getSerialNr(): ?string
    {
        return $this->serialNr;
    }

    public function setSerialNr(?string $serialNr): self
    {
        $this->serialNr = $serialNr;

        return $this;
    }

    public function getProject(): ?Project
    {
        return $this->project;
    }

    public function setProject(?Project $project): self
    {
        $this->project = $project;

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddresses(): Collection
    {
        return $this->addresses;
    }

    public function addAddress(Address $address): self
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses[] = $address;
            $address->setDevice($this);
        }

        return $this;
    }

    public function removeAddress(Address $address): self
    {
        if ($this->addresses->removeElement($address)) {
            // set the owning side to null (unless already changed)
            if ($address->getDevice() === $this) {
                $address->setDevice(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    
}
