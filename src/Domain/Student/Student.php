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
    private FullName $fullName;
    public Adress $adress;

    public function __construct(Email $email, DateTimeInterface $birthDate, FullName $fullName, Adress $adress)
    {
        $this->watchedVideos = new WatchedVideos();
        $this->$email = $email;
        $this->birthDate = $birthDate;
        $this->fullName = $fullName;
        $this->adress = $adress;
    }

    public function fullName(): string
    {
        return $this->fullName;
    }

    public function getAdress(): string
    {
        return $this->adress->fullAdress();
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
