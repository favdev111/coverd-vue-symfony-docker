<?php

namespace App\Command;

use App\Entity\ZipCounty;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ZipCountyImportCommand extends Command
{
    protected static $defaultName = 'app:zip-county:import';

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription(
                'Import zip code/county information from source datafiles.
                See readme for where to get updated files.'
            )
            ->addOption(
                'force',
                null,
                InputOption::VALUE_NONE,
                'Execute actual import. Otherwise, actions will only be reported.'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $force = $input->getOption('force') !== false;
        $io = new SymfonyStyle($input, $output);
        $zipCountyRepo = $this->em->getRepository(ZipCounty::class);

        $zipFileHandler = fopen(__DIR__ . "/../Data/ZIP_COUNTY_062020.txt", 'r');
        $counties = [];

        // Skip the first line since it's just the header
        fgetcsv($zipFileHandler, 0, "\t");
        while ($line = fgetcsv($zipFileHandler, 0, "\t")) {
            $fips = $line[1];
            $zip = $line[0];

            if (!key_exists($fips, $counties)) {
                $counties[$fips] = ['zips' => [], 'county' => '', 'state' => ''];
            }

            $counties[$fips]['zips'][] = $zip;
        }

        fclose($zipFileHandler);

        $countyFileHandler = fopen(__DIR__ . "/../Data/2019_Gaz_counties_national.txt", 'r');

        // Skip the first line since it's just the header
        fgetcsv($countyFileHandler, 0, "\t");
        while ($line = fgetcsv($countyFileHandler, 0, "\t")) {
            $state = $line[0];
            $fips = $line[1];
            $county = $line[3];

            if (!key_exists($fips, $counties)) {
                $io->warning(sprintf('There are no zipcodes found for %s (%s, %s)', $fips, $county, $state));
                continue;
            }

            $counties[$fips]['state'] = $state;
            $counties[$fips]['county'] = $county;
        }

        //print_r($zipCodes);

        fclose($countyFileHandler);

        $outputTableData = [];
        $progress = $io->createProgressBar(count($counties));
        $progress->setFormat('debug');

        foreach ($counties as $fips => $countyRaw) {
            if (!$countyRaw['state'] || !$countyRaw['county']) {
                $io->error(sprintf(
                    "Could not find county information from FIPS: %s.
                    Fips was in Zip Code files but not Counties file.",
                    $fips
                ));
                continue;
            }

            foreach ($countyRaw['zips'] as $zipRaw) {
                $zipCounty = $zipCountyRepo->findOneBy(['countyId' => $fips, 'zipCode' => $zipRaw]);

                $action = 'UPDATE';
                // If we couldn't find one we will create a new one
                if (!$zipCounty) {
                    $zipCounty = new ZipCounty();
                    $action = "ADD";
                }

                if (
                    $zipCounty->getStateCode() === $countyRaw['state']
                    && $zipCounty->getCountyName() === $countyRaw['county']
                ) {
                    if ($io->isDebug()) {
                        $io->text(sprintf(
                            'Skipping zip code %s, county ID %s, since nothing has changed.',
                            $zipRaw,
                            $fips
                        ));
                    }
                    continue;
                }

                $zipCounty->setCountyId($fips);
                $zipCounty->setCountyName($countyRaw['county']);
                $zipCounty->setStateCode($countyRaw['state']);
                $zipCounty->setZipCode($zipRaw);

                $outputTableData[] = [
                    $zipCounty->getZipCode(),
                    $zipCounty->getCountyName(),
                    $zipCounty->getStateCode(),
                    $zipCounty->getCountyId(),
                    $action,
                ];

                if ($force) {
                    $this->em->persist($zipCounty);
                }
            }

            if ($force) {
                $this->em->flush();
            }

            $progress->advance();
        }

        $progress->finish();

        $headers = ['Zip Code', 'County', 'State', 'FIPS', 'Action'];

        $io->table($headers, $outputTableData);

        if (!$force) {
            $io->warning(sprintf(
                '%d zip codes(s) need to be added and updated. Use --force to update zip codes.',
                count($outputTableData)
            ));
        }

        return 0;
    }
}
