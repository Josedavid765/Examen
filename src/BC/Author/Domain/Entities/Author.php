<?php

namespace Src\BC\Author\Domain\Entities;

use JsonSerializable;
use Src\BC\Author\Domain\ValueObject\AuthorBirthDateValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorFirstNameValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorIdValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorLastNameValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorEmailValueObject;
use Src\BC\Author\Domain\ValueObject\AuthorPasswordValueObject;
class Author implements JsonSerializable
{
    private AuthorIdValueObject $authorId;
    private AuthorFirstNameValueObject $firstName;
    private AuthorLastNameValueObject $lastName;
    private AuthorBirthDateValueObject $birthDate;
    private AuthorEmailValueObject $email;
    private AuthorPasswordValueObject $password;

    public function __construct(AuthorIdValueObject $authorId, AuthorFirstNameValueObject $firstName, AuthorLastNameValueObject $lastName, AuthorBirthDateValueObject $birthDate, AuthorEmailValueObject $email, AuthorPasswordValueObject $password)
    {
        $this->authorId = $authorId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->birthDate = $birthDate;
        $this->email = $email;
        $this->password = $password;
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

    public function getAuthorEmail(): AuthorEmailValueObject { return $this->email; }
    public function getAuthorEmailValue(): string { return $this->email->value(); }

    public function getAuthorPassword(): AuthorPasswordValueObject { return $this->password; }
    public function getAuthorPasswordValue(): string { return $this->password->value(); }
}