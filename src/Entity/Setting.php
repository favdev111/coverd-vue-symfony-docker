<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Class Setting
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Repository\SettingRepository")
 * @Gedmo\Loggable()
 */
class Setting
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string")
     * @var string
     */
    protected $config;

    /**
     * @var mixed
     *
     * @ORM\Column(type="json", nullable=True)
     * @Gedmo\Versioned
     */
    protected $value;

    /**
     * @return string
     */
    public function getConfig(): string
    {
        return $this->config;
    }

    /**
     * @param string $config
     */
    public function setConfig(string $config): void
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }
}
