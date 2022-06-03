<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $fullDnsName;

    #[ORM\Column(type: 'string', length: 100)]
    private $ip;

    #[ORM\Column(type: 'boolean')]
    private $isSshCapable;

    #[ORM\Column(type: 'boolean')]
    private $isTelnetCapable;

    #[ORM\Column(type: 'boolean')]
    private $isIpmiCapable;

    #[ORM\Column(type: 'boolean')]
    private $isVncCapable;

    #[ORM\Column(type: 'boolean')]
    private $isRdpCapable;

    #[ORM\ManyToOne(targetEntity: Device::class, inversedBy: 'addresses')]
    private $device;

    #[ORM\Column(type: 'boolean')]
    private $isDhcpEnabled;

    #[ORM\ManyToOne(targetEntity: Network::class, inversedBy: 'addresses')]
    #[ORM\JoinColumn(nullable: false)]
    private $network;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullDnsName(): ?string
    {
        return $this->fullDnsName;
    }

    public function setFullDnsName(string $fullDnsName): self
    {
        $this->fullDnsName = $fullDnsName;

        return $this;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(string $ip): self
    {
        $this->ip = $ip;

        return $this;
    }

    public function isIsSshCapable(): ?bool
    {
        return $this->isSshCapable;
    }

    public function setIsSshCapable(bool $isSshCapable): self
    {
        $this->isSshCapable = $isSshCapable;

        return $this;
    }

    public function isIsTelnetCapable(): ?bool
    {
        return $this->isTelnetCapable;
    }

    public function setIsTelnetCapable(bool $isTelnetCapable): self
    {
        $this->isTelnetCapable = $isTelnetCapable;

        return $this;
    }

    public function isIsIpmiCapable(): ?bool
    {
        return $this->isIpmiCapable;
    }

    public function setIsIpmiCapable(bool $isIpmiCapable): self
    {
        $this->isIpmiCapable = $isIpmiCapable;

        return $this;
    }

    public function isIsVncCapable(): ?bool
    {
        return $this->isVncCapable;
    }

    public function setIsVncCapable(bool $isVNCCapable): self
    {
        $this->isVNCCapable = $isVncCapable;

        return $this;
    }

    public function isIsRdpCapable(): ?bool
    {
        return $this->isRdpCapable;
    }

    public function setIsRdpCapable(bool $isRDPCapable): self
    {
        $this->isRDPCapable = $isRdpCapable;

        return $this;
    }

    public function getDevice(): ?Device
    {
        return $this->device;
    }

    public function setDevice(?Device $device): self
    {
        $this->device = $device;

        return $this;
    }

    public function isIsDhcpEnabled(): ?bool
    {
        return $this->isDhcpEnabled;
    }

    public function setIsDhcpEnabled(bool $isDhcpEnabled): self
    {
        $this->isDhcpEnabled = $isDhcpEnabled;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getFullDnsName().' ('.$this->getIp().')';
    }

    public function getNetwork(): ?Network
    {
        return $this->network;
    }

    public function setNetwork(?Network $network): self
    {
        $this->network = $network;

        return $this;
    }
}
