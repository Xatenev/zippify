<?php

namespace Xatenev\Zippify\Model;

class ViewSettings
{
    private bool $tar = false;
    private bool $gz = false;
    private bool $bz2 = false;
    private bool $password = false;
    private bool $share = false;
    private bool $virus = false;


    public static function createFromRoute(string $route): ViewSettings
    {
        $class = new static();
        $class->setTar(str_contains($route, 'tar'));
        $class->setGz(str_contains($route, 'gz'));
        $class->setBz2(str_contains($route, 'bz2'));
        $class->setPassword(str_contains($route, 'password'));
        $class->setShare(str_contains($route, 'share'));
        $class->setVirus(str_contains($route, 'virus'));

        return $class;
    }

    /**
     * @return bool
     */
    public function hasAny(): bool
    {
        return in_array(true, get_object_vars($this));
    }

    /**
     * @return bool
     */
    public function hasTar(): bool
    {
        return $this->tar;
    }

    /**
     * @param bool $tar
     */
    public function setTar(bool $tar): void
    {
        $this->tar = $tar;
    }

    /**
     * @return bool
     */
    public function hasGz(): bool
    {
        return $this->gz;
    }

    /**
     * @param bool $gz
     */
    public function setGz(bool $gz): void
    {
        $this->gz = $gz;
    }

    /**
     * @return bool
     */
    public function hasBz2(): bool
    {
        return $this->bz2;
    }

    /**
     * @param bool $bz2
     */
    public function setBz2(bool $bz2): void
    {
        $this->bz2 = $bz2;
    }

    /**
     * @return bool
     */
    public function hasPassword(): bool
    {
        return $this->password;
    }

    /**
     * @param bool $password
     */
    public function setPassword(bool $password): void
    {
        $this->password = $password;
    }

    /**
     * @return bool
     */
    public function hasShare(): bool
    {
        return $this->share;
    }

    /**
     * @param bool $share
     */
    public function setShare(bool $share): void
    {
        $this->share = $share;
    }

    /**
     * @return bool
     */
    public function hasSettings(): bool
    {
        return $this->settings;
    }

    /**
     * @param bool $settings
     */
    public function setSettings(bool $settings): void
    {
        $this->settings = $settings;
    }

    /**
     * @return bool
     */
    public function hasVirus(): bool
    {
        return $this->virus;
    }

    /**
     * @param bool $virus
     */
    public function setVirus(bool $virus): void
    {
        $this->virus = $virus;
    }
}