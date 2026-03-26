<?php

namespace Src\bc\Author\Domain\Entities;

use Src\bc\Author\Domain\ValueObject\AuthorBirthDate;
use Src\bc\Author\Domain\ValueObject\AuthorFirstName;
use Src\bc\Author\Domain\ValueObject\AuthorId;
use Src\bc\Author\Domain\ValueObject\AuthorLastName;

class Author
{
    private AuthorId $authorId;
    private AuthorFirstName $firstName;
    private AuthorLastName $lastName;
    private AuthorBirthDate $birthDate;

    public function __construct(AuthorId $authorId, AuthorFirstName $firstName, AuthorLastName $lastName, AuthorBirthDate $birthDate)
    {
        $this->authorId = $authorId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
    }

    public function getAuthorId(): AuthorId { return $this->authorId; }
    public function getAuthorIdValue(): string { return $this->authorId->value(); }

    public function getAuthorFirstName(): AuthorFirstName { return $this->firstName; }
    public function getAuthorFirstNameValue(): string { return $this->firstName->value(); }

    public function getAuthorLastName(): AuthorLastName { return $this->lastName; }
    public function getAuthorLastNameValue(): string { return $this->lastName->value(); }

    public function getFullName(): string {return $this->firstName->value() . ' ' . $this->lastName->value();}

    public function getAuthorBirthDate(): AuthorBirthDate { return $this->birthDate; }
    public function getAuthorBirthDateValue(): string { return $this->birthDate->value(); }
}
