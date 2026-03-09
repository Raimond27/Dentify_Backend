<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Paciente;
use App\Entity\Odontologo;
use App\Entity\Box;
use App\Entity\Cita;
use App\Entity\StockMaterial;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('es_ES');

        // Users
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setEmail("user$i@dentify.com");
            $user->setNombre($faker->firstName);
            $user->setApellidos($faker->lastName);
            $user->setRoles([$i == 0 ? 'ROLE_ADMIN' : 'ROLE_STUDENT']);
            $user->setPassword($this->hasher->hashPassword($user, 'password'));
            $user->setEstaActivo(true);
            $manager->persist($user);
        }

        // Odontologists
        $odontos = [];
        for ($i = 0; $i < 5; $i++) {
            $odonto = new Odontologo();
            $odonto->setNombre($faker->firstName);
            $odonto->setApellidos($faker->lastName);
            $odonto->setEmail($faker->email);
            $odonto->setEspecialidad($faker->randomElement(['General', 'Ortodoncia', 'Cirugía']));
            $manager->persist($odonto);
            $odontos[] = $odonto;
        }

        // Boxes
        $boxes = [];
        for ($i = 1; $i <= 5; $i++) {
            $box = new Box();
            $box->setNombre("Box $i");
            $box->setEstado('Disponible');
            $manager->persist($box);
            $boxes[] = $box;
        }

        // Patients
        for ($i = 0; $i < 20; $i++) {
            $paciente = new Paciente();
            $paciente->setNombre($faker->firstName);
            $paciente->setApellidos($faker->lastName);
            $paciente->setDni($faker->dni);
            $paciente->setTelefono($faker->phoneNumber);
            $paciente->setEmail($faker->email);
            $paciente->setAlergias(['Ninguna']);
            $manager->persist($paciente);

            // Citas
            for ($j = 0; $j < 2; $j++) {
                $cita = new Cita();
                $cita->setPaciente($paciente);
                $cita->setOdontologo($faker->randomElement($odontos));
                $cita->setBox($faker->randomElement($boxes));
                $cita->setFecha(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('now', '+1 month')));
                $cita->setHoraInicio(new \DateTimeImmutable('10:00'));
                $cita->setDuracion('30 min');
                $cita->setEstado('Pendiente');
                $manager->persist($cita);
            }
        }

        // Stock
        for ($i = 0; $i < 10; $i++) {
            $material = new StockMaterial();
            $material->setNombre($faker->word);
            $material->setCantidadActual($faker->numberBetween(5, 100));
            $material->setUnidad('unidades');
            $material->setFechaUltimaReposicion(new \DateTimeImmutable());
            $manager->persist($material);
        }

        $manager->flush();
    }
}
