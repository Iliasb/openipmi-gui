<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $slug;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $gps;

    #[ORM\OneToMany(mappedBy: 'location', targetEntity: Rack::class, orphanRemoval: true)]
    private $racks;

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
        $this->racks = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getGps(): ?string
    {
        return $this->gps;
    }

    public function setGps(?string $gps): self
    {
        $this->gps = $gps;

        return $this;
    }

    /**
     * @return Collection<int, Rack>
     */
    public function getRacks(): Collection
    {
        return $this->racks;
    }

    public function getRackCount(): ?int
    {
        return count($this->racks);
    }

    public function getDeviceCount(): ?int
    {
        $device_count = 0;
        foreach ($this->racks as $rack => $value) {
            $device_count = $device_count + $value->getDeviceCount();
        }

        return $device_count;
    }

    public function addRack(Rack $rack): self
    {
        if (!$this->racks->contains($rack)) {
            $this->racks[] = $rack;
            $rack->setLocation($this);
        }

        return $this;
    }

    public function removeRack(Rack $rack): self
    {
        if ($this->racks->removeElement($rack)) {
            // set the owning side to null (unless already changed)
            if ($rack->getLocation() === $this) {
                $rack->setLocation(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
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
