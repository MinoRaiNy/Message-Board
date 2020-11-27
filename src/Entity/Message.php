<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Reply::class, mappedBy="message")
     */
    private $replys;

    public function __construct()
    {
        $this->replys = new ArrayCollection();
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

    /**
     * @return Collection|Reply[]
     */
    public function getReplys(): Collection
    {
        return $this->replys;
    }

    public function addReply(Reply $reply): self
    {
        if (!$this->replys->contains($reply)) {
            $this->replys[] = $reply;
            $reply->setMessage($this);
        }

        return $this;
    }

    public function removeReply(Reply $reply): self
    {
        if ($this->replys->contains($reply)) {
            $this->replys->removeElement($reply);
            // set the owning side to null (unless already changed)
            if ($reply->getMessage() === $this) {
                $reply->setMessage(null);
            }
        }

        return $this;
    }
}
