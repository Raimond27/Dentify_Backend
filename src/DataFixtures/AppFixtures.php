<?php

namespace App\DataFixtures;

use App\Entity\Box;
use App\Entity\Cita;
use App\Entity\Odontograma;
use App\Entity\Odontologo;
use App\Entity\Paciente;
use App\Entity\PrimeraVisita;
use App\Entity\ProtocoloTratamiento;
use App\Entity\Radiografia;
use App\Entity\RecepcionMaterial;
use App\Entity\StockMaterial;
use App\Entity\Tratamiento;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('es_ES');

        // 1. Boxes (5)
        $boxes = [];
        for ($i = 1; $i <= 5; $i++) {
            $box = new Box();
            $box->setNombre('Box ' . $i);
            $manager->persist($box);
            $boxes[] = $box;
        }

        // 2. Odontólogos (5)
        $odontologos = [];
        $especialidades = ['General', 'Ortodoncia', 'Implantología', 'Endodoncia', 'Estética'];
        for ($i = 0; $i < 5; $i++) {
            $odontologo = new Odontologo();
            $odontologo->setNombre($faker->firstName());
            $odontologo->setApellidos($faker->lastName() . ' ' . $faker->lastName());
            $odontologo->setEmail($faker->unique()->email());
            $odontologo->setEspecialidad($especialidades[$i]);
            $odontologo->setDiaSemanaAsignado($faker->randomElement(['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes']));
            $manager->persist($odontologo);
            $odontologos[] = $odontologo;
        }

        // 3. Stock Material (10)
        $materiales = [];
        $nombresMaterial = ['Guantes Nitrilo', 'Composite A2', 'Anestesia Ártica', 'Agujas 27G', 'Diques de Goma', 'Fresas Diamante', 'Cemento Dual', 'Alginato', 'Yeso Tipo III', 'Sutura 4-0'];
        for ($i = 0; $i < 10; $i++) {
            $material = new StockMaterial();
            $material->setNombre($nombresMaterial[$i]);
            $material->setCantidad($faker->randomFloat(2, 5, 100));
            $material->setUnidad($faker->randomElement(['Cajas', 'Tubos', 'Botes', 'Sobres']));
            $material->setFechaUltimaReposicion(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 month', 'now')));
            $manager->persist($material);
            $materiales[] = $material;
        }

        // 4. Recepción Material (20)
        for ($i = 0; $i < 20; $i++) {
            $recepcion = new RecepcionMaterial();
            $recepcion->setMaterial($faker->randomElement($materiales));
            $recepcion->setCantidad($faker->randomFloat(2, 1, 50));
            $recepcion->setProveedor($faker->company());
            $recepcion->setFecha(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-6 months', 'now')));
            $manager->persist($recepcion);
        }

        // 5. Protocolos de Tratamiento (5)
        for ($i = 0; $i < 5; $i++) {
            $protocolo = new ProtocoloTratamiento();
            $protocolo->setNombre('Protocolo ' . $faker->word());
            $protocolo->setDescripcion($faker->paragraph());
            $protocolo->setMaterialNecesario($faker->randomElement($nombresMaterial));
            $protocolo->setCantidad($faker->randomFloat(2, 1, 5));
            $protocolo->setEstado($faker->randomElement(['Activo', 'Borrador']));
            $manager->persist($protocolo);
        }

        // 6. Pacientes (20)
        $pacientes = [];
        for ($i = 0; $i < 20; $i++) {
            $paciente = new Paciente();
            $paciente->setNombre($faker->firstName());
            $paciente->setApellidos($faker->lastName() . ' ' . $faker->lastName());
            $paciente->setDni($faker->unique()->dni());
            $paciente->setNumeroSeguridadSocial($faker->numerify('###########'));
            $paciente->setTelefono($faker->phoneNumber());
            $paciente->setEmail($faker->unique()->email());
            $paciente->setAlergias($faker->randomElements(['Penicilina', 'Látex', 'Polen', 'Ninguna'], $faker->numberBetween(0, 2)));
            $paciente->setEnfermedades($faker->randomElement(['Diabetes', 'Hipertensión', 'Ninguna']));
            $paciente->setHistorialClinico($faker->text());
            $paciente->setDatosFacturacion($faker->address());
            $paciente->setFechaCreacion(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 year', '-1 month')));
            $manager->persist($paciente);
            $pacientes[] = $paciente;

            // 7. Odontograma (1 por paciente)
            $odontograma = new Odontograma();
            $odontograma->setPaciente($paciente);
            // Simular algunos dientes con problemas iniciales
            $dientesData = [];
            for($d = 11; $d <= 48; $d++) {
                if ($faker->boolean(20)) {
                    $dientesData[$d] = ['estado' => 'Caries', 'observaciones' => 'Revisar'];
                }
            }
            $odontograma->setDientes($dientesData);
            $manager->persist($odontograma);

            // 8. Tratamientos (1 a 5 por odontograma)
            $numTratamientos = $faker->numberBetween(1, 5);
            $caras = ['Oclusal', 'Mesial', 'Distal', 'Vestibular', 'Palatino'];
            for ($j = 0; $j < $numTratamientos; $j++) {
                $tratamiento = new Tratamiento();
                $tratamiento->setOdontograma($odontograma);
                $tratamiento->setDiente((string)$faker->numberBetween(11, 48));
                $tratamiento->setCara($faker->randomElement($caras));
                $tratamiento->setTipoTratamiento($faker->randomElement(['Obturación', 'Endodoncia', 'Extracción', 'Limpieza']));
                $tratamiento->setEstado($faker->randomElement(['Pendiente', 'Terminado', 'En Proceso']));
                $tratamiento->setColor($faker->randomElement(['#FF0000', '#00FF00', '#0000FF']));
                $tratamiento->setFecha(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 month', 'now')));
                $manager->persist($tratamiento);
            }

            // 9. Radiografías (1 a 3 por paciente)
            $numRad = $faker->numberBetween(1, 3);
            for ($j = 0; $j < $numRad; $j++) {
                $radiografia = new Radiografia();
                $radiografia->setPaciente($paciente);
                $radiografia->setNombreArchivo('rad_' . $faker->sha1() . '.jpg');
                $radiografia->setTipoRadiografia($faker->randomElement(['Panorámica', 'Periapical', 'Aleta de mordida']));
                $radiografia->setFechaSubida(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-6 months', 'now')));
                $radiografia->setObservaciones($faker->sentence());
                $manager->persist($radiografia);
            }

            // 10. Primera Visita (1 por paciente)
            $primeraVisita = new PrimeraVisita();
            $primeraVisita->setPaciente($paciente);
            $primeraVisita->setFecha($paciente->getFechaCreacion());
            $primeraVisita->setMotivoConsulta($faker->sentence());
            $primeraVisita->setObservaciones($faker->paragraph());
            $primeraVisita->setOdontogramaInicial($odontograma);
            $manager->persist($primeraVisita);
        }

        // 11. Citas (40)
        for ($i = 0; $i < 40; $i++) {
            $cita = new Cita();
            $cita->setPaciente($faker->randomElement($pacientes));
            $cita->setOdontologo($faker->randomElement($odontologos));
            $cita->setBox($faker->randomElement($boxes));
            $cita->setFecha(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 month', '+1 month')));
            $cita->setHoraInicio(\DateTimeImmutable::createFromMutable(\DateTime::createFromFormat('H:i', $faker->numberBetween(8, 19) . ':00')));
            $cita->setDuracion($faker->randomElement(['30 min', '60 min', '90 min']));
            $cita->setEstado($faker->randomElement(['Programada', 'Completada', 'Cancelada']));
            $manager->persist($cita);
        }

        $manager->flush();
    }
}
