<?php

namespace Src\BC\Author\Application\DTO;

class AuthorUpdateDTO
{
    public function __construct(
        private ?string $id,
        private ?string $firstName,
        private ?string $lastName,
        private ?string $birthDate,
        public readonly string $email,
        public readonly string $password
    ) {}

    public function getId(): string { return $this->id; }
    public function getFirstName(): ?string { return $this->firstName; }
    public function getLastName(): ?string { return $this->lastName; }
    public function getBirthDate(): ?string { return $this->birthDate; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
}