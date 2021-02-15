<?php

namespace App\Command;

use App\Entity\Companies;
use App\Entity\Projects;
use App\Entity\Workers;
use App\Repository\CompaniesRepository;
use App\Repository\ProjectsRepository;
use App\Repository\WorkersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class CreateCompanyFromXMLCommand extends Command
{
    /**
     * @var string $fileString
     */
    private $fileString;


    /**
     * @var EntityManagerInterface
     */
    private $em;

    private string $dataDirectory;

    /**
     * @var WorkersRepository
     */
    private  $workersRepository;

    /**
     * @var $ProjectsRepository
     */
    private $projectRepository;

    /**
     * @var $CompaniesRepository
     */
    private $companiesRepository;


    public function __construct(EntityManagerInterface $em, string $dataDirectory, CompaniesRepository $companiesRepository )
    {
        parent::__construct();
        $this->dataDirectory = $dataDirectory;
        $this->em = $em;
        $this->companiesRepository = $companiesRepository;
    }

    /**
     * @var SymfonyStyle
     */

    private $io;

    protected static $defaultName = 'CreateCompaniesFromXML';
    protected static $defaultDescription = 'Importer des données en provenance d\' fichier XML';

    protected function configure(): void
    {
        $this->setDescription(self::$defaultDescription);
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $this->createWorkers();
        return Command::SUCCESS;
    }

    private function getDataFromFile(): array
    {
        $file = $this->dataDirectory . 'projects.xml';

        $fileExtension = pathinfo($file, PATHINFO_EXTENSION);

        $normalizers = [new ObjectNormalizer()];

        $encoders = [
            new XmlEncoder()
        ];

        $serializer = new Serializer($normalizers, $encoders);

        /** @var @ string $fileString */
        $fileString = file_get_contents($file);

        $data = $serializer->decode($fileString, $fileExtension);


        /*dd($data);*/
        if (array_key_exists('project', $data)){
            return $data['project'];

        }

        return $data;




    }

    private function createWorkers(): void
    {
        $this->io->section('CREATION DES WORKERS A PARTIR DU FICHIER');

        $workersCreated = 0;

        foreach ($this->getDataFromFile() as $row){
            if (is_array($row) && array_key_exists('workers', $row) && !empty($row['workers'])) {
                $worker = $this->companiesRepository->findOneBy([
                    'name' => $row['workers']
                ]);
                if(!$worker){
                    $worker = new Companies();

                    $worker->setName($row['company']);


                    $this->em->persist($worker);

                    $workersCreated++;
                }
            }
        }
        $this->em->flush();

        if($workersCreated > 1){
            $string = "{$workersCreated} Information Crées en BDD.";
        }elseif ($workersCreated === 1){
            $string = '1 information cree';
        }else{
            $string ="Aucune infos";
        }

        $this->io->success($string);
    }
}
