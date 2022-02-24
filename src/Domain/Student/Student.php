<?php

namespace Alura\Calisthenics\Domain\Student;

use Alura\Calisthenics\Domain\Email\Email;
use Alura\Calisthenics\Domain\Video\Video;
use Alura\Calisthenics\Domain\Student\WatchedVideos;
use DateTimeInterface;

class Student
{
    private Email $email;
    private DateTimeInterface $birthDate;
    private WatchedVideos $watchedVideos;
    private string $firstName;
    private string $lastName;
    public string $street;
    public string $number;
    public string $province;
    public string $city;
    public string $state;
    public string $country;

    public function __construct(Email $email, DateTimeInterface $birthDate, string $firstName, string $lastName, string $street, string $number, string $province, string $city, string $state, string $country)
    {
        $this->watchedVideos = new WatchedVideos();
        $this->$email = $email;
        $this->birthDate = $birthDate;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->street = $street;
        $this->number = $number;
        $this->province = $province;
        $this->city = $city;
        $this->state = $state;
        $this->country = $country;
    }

    public function getFullName(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getBirthDate(): DateTimeInterface
    {
        return $this->birthDate;
    }

    public function watch(Video $video, DateTimeInterface $date)
    {
        $this->watchedVideos->add($video, $date);
    }

    public function hasAccess(): bool
    {
        if ($this->watchedVideos->count() === 0) {
           return true;
        }

        return $this->firstVideoWasWatchedInLessThanLimit();
    }

    private function firstVideoWasWatchedInLessThanLimit(): bool
    {        
        $firstDate = $this->watchedVideos->dateOfFirstVideo();
        $today = new \DateTimeImmutable();

        if ($firstDate->diff($today)->days < 90) {
            return true;
        }

        return false;
    }

    public function getAge()
    {
        $today = new \DateTimeImmutable();
        $dateInterval = $this->birthDate->diff($today);

        return $dateInterval->y;
    }
}
