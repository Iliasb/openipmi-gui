<?php

namespace App\Entity;

use App\Repository\RackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: RackRepository::class)]
class Rack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 20)]
    private $tag;

    #[ORM\Column(type: 'integer')]
    private $size;

    #[ORM\ManyToOne(targetEntity: Location::class, inversedBy: 'racks')]
    #[ORM\JoinColumn(nullable: false)]
    private $location;

    #[ORM\OneToMany(mappedBy: 'rack', targetEntity: Device::class, orphanRemoval: true)]
    private $devices;

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

    public function getContentChanged()
    {
        return $this->contentChanged;
    }

    public function __construct()
    {
        $this->devices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getLocation(): ?Location
    {
        return $this->location;
    }

    public function setLocation(?Location $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection<int, Device>
     */
    public function getDevices(): Collection
    {
        return $this->devices;
    }

    public function getDeviceCount(): ?int
    {
        return count($this->devices);
    }

    public function addDevice(Device $device): self
    {
        if (!$this->devices->contains($device)) {
            $this->devices[] = $device;
            $device->setRack($this);
        }

        return $this;
    }

    public function removeDevice(Device $device): self
    {
        if ($this->devices->removeElement($device)) {
            // set the owning side to null (unless already changed)
            if ($device->getRack() === $this) {
                $device->setRack(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getTag() .' ('.$this->location.')';
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
