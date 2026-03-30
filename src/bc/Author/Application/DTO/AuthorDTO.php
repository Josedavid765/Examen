<?php

namespace Src\bc\Author\Application\DTO;

class AuthorDTO
{
    public function __construct(
        private ?string $id,
        private string $firstName,
        private string $lastName,
        private string $birthDate
    ) {}

    public function getId(): ?string { return $this->id; }
    public function getFirstName(): string { return $this->firstName; }
    public function getLastName(): string { return $this->lastName; }
    public function getBirthDate(): string { return $this->birthDate; }
}