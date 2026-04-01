<?php

namespace Src\bc\Author\Domain\Entities;

use JsonSerializable;
use Src\bc\Author\Domain\ValueObject\AuthorBirthDateValueObject;
use Src\bc\Author\Domain\ValueObject\AuthorFirstNameValueObject;
use Src\bc\Author\Domain\ValueObject\AuthorIdValueObject;
use Src\bc\Author\Domain\ValueObject\AuthorLastNameValueObject;
class Author implements JsonSerializable
{
    private AuthorIdValueObject $authorId;
    private AuthorFirstNameValueObject $firstName;
    private AuthorLastNameValueObject $lastName;
    private AuthorBirthDateValueObject $birthDate;

    public function __construct(AuthorIdValueObject $authorId, AuthorFirstNameValueObject $firstName, AuthorLastNameValueObject $lastName, AuthorBirthDateValueObject $birthDate)
    {
        $this->authorId = $authorId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
    }

    public function jsonSerialize(): mixed{
        return [
            'id' => $this->getAuthorIdValue(),
            'first_name' => $this->getAuthorFirstNameValue(),
            'last_name' => $this->getAuthorLastNameValue(),
            'birth_date' => $this->getAuthorBirthDateValue(),
        ];
    }

    public function getAuthorId(): AuthorIdValueObject { return $this->authorId; }
    public function getAuthorIdValue(): string { return $this->authorId->value(); }

    public function getAuthorFirstName(): AuthorFirstNameValueObject { return $this->firstName; }
    public function getAuthorFirstNameValue(): string { return $this->firstName->value(); }

    public function getAuthorLastName(): AuthorLastNameValueObject { return $this->lastName; }
    public function getAuthorLastNameValue(): string { return $this->lastName->value(); }

    public function getFullName(): string {return $this->firstName->value() . ' ' . $this->lastName->value();}

    public function getAuthorBirthDate(): AuthorBirthDateValueObject { return $this->birthDate; }
    public function getAuthorBirthDateValue(): string { return $this->birthDate->value(); }
}