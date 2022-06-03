<?php

namespace App\Entity;

use App\Repository\DeviceGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DeviceGroupRepository::class)]
class DeviceGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $name;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $brand;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $model;

    #[ORM\OneToMany(mappedBy: 'deviceGroup', targetEntity: Device::class)]
    private $device;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $webInterface;

    public function __construct()
    {
        $this->device = new ArrayCollection();
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

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return Collection<int, Device>
     */
    public function getDevice(): Collection
    {
        return $this->device;
    }

    public function addDevice(Device $device): self
    {
        if (!$this->device->contains($device)) {
            $this->device[] = $device;
            $device->setDeviceGroup($this);
        }

        return $this;
    }

    public function removeDevice(Device $device): self
    {
        if ($this->device->removeElement($device)) {
            // set the owning side to null (unless already changed)
            if ($device->getDeviceGroup() === $this) {
                $device->setDeviceGroup(null);
            }
        }

        return $this;
    }

    public function getWebInterface(): ?string
    {
        return $this->webInterface;
    }

    public function setWebInterface(?string $webInterface): self
    {
        $this->webInterface = $webInterface;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }
}
