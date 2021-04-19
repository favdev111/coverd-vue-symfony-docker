<?php

namespace App\IdGenerator;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Generates unique Client Public ID by generating a random value
 */
class RandomIdGenerator
{
    /**
     * @var ClientRepository
     */
    private $repository;

    /**
     * @var string[] IDs generated during the lifetime of this object
     */
    private $generatedThisInstance = [];

    public function __construct(EntityManagerInterface $em)
    {
        $this->repository = $em->getRepository(Client::class);
    }

    /**
     * Generate a unique Client Public ID not currently used
     */
    public function generate(): string
    {
        // Sanity check to prevent infinite loop
        $maxTries = 1000;

        $id = null;

        do {
            // Accumulate from previous loop, if exists
            if ($id) {
                $this->generatedThisInstance[] = $id;
            }

            // Generate a new ID
            $id = sprintf(self::generateRandomString(8));

            $maxTries--;
        } while ($this->idExists($id) && $maxTries > 0);

        if ($maxTries === 0) {
            throw new \ErrorException('Unable to generate a Specimen ID (exceeded max tries)');
        }

        return $id;
    }

    private function idExists(string $id): bool
    {
        // Consider it existing if we've generated it already.
        // This makes working with unpersisted entities easier.
        if (in_array($id, $this->generatedThisInstance)) {
            return true;
        }

        // ID exists if it's attached to an existing record in the database
        $found = $this->repository->findOneBy(['publicId' => $id]);

        return $found ? true : false;
    }

    /**
     * Returns a string containing $length random characters
     *
     * The string has the following features:
     *  - No ambiguous characters (ie. 0 vs. O or 1 vs l)
     *  - No vowels (so no recognizable words, dirty or otherwise)
     */
    public static function generateRandomString(int $length, bool $lettersOnly = false): string
    {
        $alphabet = [
            'B', 'C', 'D', 'F', 'G', 'H', 'J', 'K', 'L', 'M', 'N', 'P', 'R', 'S', 'T', 'V', 'W', 'X', 'Y', 'Z',
        ];

        if (!$lettersOnly) {
            $alphabet = array_merge($alphabet, ['2', '5', '7', '9']);
        }

        $randomStr = '';
        for ($i = 0; $i < $length; $i++) {
            $randomStr .= $alphabet[array_rand($alphabet)];
        }

        return $randomStr;
    }
}
