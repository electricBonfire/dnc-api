<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"event:read"}},
 *      denormalizationContext={"groups"={"event:write"}}
 * )
 * @ApiFilter(SearchFilter::class, properties={
 *     "name": "partial",
 *     "speakers": "exact",
 *     "speakers.username": "partial"
 * })
 * @ApiFilter(PropertyFilter::class)
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"event:read", "event:write", "user:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"event:read", "event:write", "user:read"})
     */
    private $startsAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\User", inversedBy="events")
     * @Groups({"event:read", "event:write"})
     */
    private $speakers;

    public function __construct()
    {
        $this->speakers = new ArrayCollection();
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

    public function getStartsAt(): ?\DateTimeInterface
    {
        return $this->startsAt;
    }

    public function setStartsAt(\DateTimeInterface $startsAt): self
    {
        $this->startsAt = $startsAt;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getSpeakers(): Collection
    {
        return $this->speakers;
    }

    public function addSpeaker(User $speaker): self
    {
        if (!$this->speakers->contains($speaker)) {
            $this->speakers[] = $speaker;
        }

        return $this;
    }

    public function removeSpeaker(User $speaker): self
    {
        if ($this->speakers->contains($speaker)) {
            $this->speakers->removeElement($speaker);
        }

        return $this;
    }
}
