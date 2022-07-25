<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LogRepository::class)]
class Log
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column(type: 'integer')]  
  private $id;

  #[ORM\Column(type: 'string', length: 255)]
  private $service;

  #[ORM\Column(type: 'string', length: 255)]
  private $request;

  #[ORM\Column(type: 'datetime')]
  private $date;

  /**
   * @return integer|null
   */
  public function getId(): ?int
  {
    return $this->id;
  }

  /**
   * @return string|null
   */
  public function getService(): ?string
  {
    return $this->service;
  }

  /**
   * @param string $service
   * @return self
   */
  public function setService(string $service): self
  {
    $this->service = $service;

    return $this;
  }

  /**
   * @return string|null
   */
  public function getRequest(): ?string
  {
    return $this->request;
  }

  /**
   * @param string $request
   * @return self
   */
  public function setRequest(string $request): self
  {
    $this->request = $request;

    return $this;
  }
  
  /**
   * @return DateTimeInterface|null
   */
  public function getDate(): ?DateTimeInterface
  {
    return $this->date;
  }

  /**
   * @param DateTimeInterface $date
   * @return self
   */
  public function setDate(DateTimeInterface $date): self
  {
    $this->date = $date;

    return $this;
  }
}
