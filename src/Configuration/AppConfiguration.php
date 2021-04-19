<?php

namespace App\Configuration;

use App\Entity\Setting;
use App\Repository\SettingRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Service to read application settings
 *
 * If an EntityManagerInterface is provided settings will be read and written
 * to the database.
 */
class AppConfiguration
{
    /**
     * Persists config to the database. Service is optional for a few reasons:
     *
     * - Makes testing a lot easier.
     * - This service could be used for initial application setup before the
     *   database connection information is defined.
     *
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * Cache of settings to reduce database interactions.
     *
     * @var mixed[]
     */
    protected $cache = [];

    /**
     * When true, configuration changes are immediately committed to the
     * database with flush().
     *
     * When false, application code must explicitly call EM->flush().
     *
     * @var bool
     */
    protected $autoFlush = true;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function hasSettingId(string $settingId): bool
    {
        // Early return if we know the key exists, but if it doesn't we may still need to check the database
        if (array_key_exists($settingId, $this->cache)) {
            return true;
        }

        $entry = $this->getRepository()->find($settingId);
        if ($entry) {
            $this->cache[$settingId] = $entry->getValue();
        }

        return array_key_exists($settingId, $this->cache);
    }

    /**
     * @param string $settingId
     * @param mixed $value
     */
    public function set(string $settingId, $value): void
    {
        $this->cache[$settingId] = $value;

        $entry = $this->getRepository()->find($settingId);
        if (!$entry) {
            $entry = new Setting();
            $entry->setConfig($settingId);
            $this->em->persist($entry);
        }

        $entry->setValue($value);

        if ($this->autoFlush) {
            $this->em->flush();
        }
    }

    /**
     * This method throws an exception if $settingId is already defined
     *
     * @param string $settingId
     * @param mixed $value
     */
    public function create(string $settingId, $value): void
    {
        if ($this->hasSettingId($settingId)) {
            throw new \InvalidArgumentException(sprintf('setting "%s" already exists', $settingId));
        }

        $entry = new Setting();
        $entry->setConfig($settingId);
        $entry->setValue($value);

        $this->cache[$settingId] = $entry->getValue();

        if ($this->em instanceof EntityManagerInterface) {
            $this->em->persist($entry);
            if ($this->autoFlush) {
                $this->em->flush();
            }
        }
    }

    /**
     * Returns the value for $reference ID or null if it doesn't exist
     *
     * If you need to check whether a setting exists, see hasReferenceId()
     *
     * @return mixed|null
     */
    public function get(string $settingId)
    {
        if (array_key_exists($settingId, $this->cache)) {
            return $this->cache[$settingId];
        }

        $entry = $this->getRepository()->find($settingId);
        if (!$entry) {
            return null;
        }
        $this->cache[$settingId] = $entry->getValue();

        return $this->cache[$settingId] ?? null;
    }

    protected function getRepository(): SettingRepository
    {
        return $this->em->getRepository(Setting::class);
    }

    public function getAutoFlush(): bool
    {
        return $this->autoFlush;
    }

    public function setAutoFlush(bool $autoFlush, bool $flushNow = true): void
    {
        $this->autoFlush = $autoFlush;

        if ($flushNow) {
            $this->em->flush();
        }
    }
}
