<?php

namespace Alura\Calisthenics\Domain\Student;

class Adress
{
    private string $street;
    private string $number;
    public string $province;
    public string $city;
    public string $state;
    public string $country;

    public function __construct(
        string $street,
        string $number,
        string $province,
        string $city,
        string $state,
        string $country
    ) {
        $this->street = $street;
        $this->number = $number;
        $this->province = $province;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
    }

    public function fullAdress(): string
    {
        return "{$this->street}, {$this->number}";
    }
}