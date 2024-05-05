<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Patient;

class PatientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 10; $i++) {
            $patient = new Patient();
            $patient->setNumCarte(rand(1000, 9999)) // Random number for card number
                    ->setNom("Nom du patient $i")
                    ->setPrenom("Prénom du patient $i")
                    ->setDateDeNaissance(strtotime("-$i years")) // Random birthdate
                    ->setNumTel("0600000000") // Dummy phone number
                    ->setEmail("patient$i@example.com"); // Dummy email

            $manager->persist($patient);
        }

        $manager->flush();
    }
}
