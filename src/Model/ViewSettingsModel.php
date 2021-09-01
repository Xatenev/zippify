<?php

namespace Xatenev\Zippify\Model;

class ViewSettingsModel
{
    private bool $tar = false;
    private bool $gz = false;
    private bool $bz2 = false;
    private bool $password = false;
    private string $passwordInput = '';
    private bool $share = false;
    private bool $virus = false;

    public static function createFromRoute(string $route): ViewSettingsModel
    {
        $class = new static();
        $hasTar = str_contains($route, 'tar');
        $hasGz = str_contains($route, 'gz');
        $hasBz2 = str_contains($route, 'bz2');
        $hasPassword = str_contains($route, 'password');
        $hasShare = str_contains($route, 'share');
        $hasVirus = str_contains($route, 'virus');

        $class->setTar($hasTar || $hasGz || $hasBz2);
        $class->setGz($hasGz);
        $class->setBz2(!$hasGz && $hasBz2);
        $class->setPassword(!$hasTar && !$hasGz && !$hasBz2 && $hasPassword);
        $class->setShare($hasShare);
        $class->setVirus($hasVirus);

        return $class;
    }

    public static function createFromArray(?array $settings): ViewSettingsModel
    {
        $class = new static();

        $hasTar = isset($settings['tar']);
        $hasGz = isset($settings['gz']);
        $hasBz2 = isset($settings['bz2']);
        $hasPassword = isset($settings['password']);
        $hasShare = isset($settings['share']);
        $hasVirus = isset($settings['virus']);
        $passwordInput = $settings['password-input'] ?? '';

        $class->setTar($hasTar || $hasGz || $hasBz2);
        $class->setGz($hasGz);
        $class->setBz2(!$hasGz && $hasBz2);
        $class->setPassword(!$hasTar && !$hasGz && !$hasBz2 && $hasPassword);
        $class->setPasswordInput($passwordInput);
        $class->setShare($hasShare);
        $class->setVirus($hasVirus);

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
     * @return string
     */
    public function getPasswordInput(): string
    {
        return $this->passwordInput;
    }

    /**
     * @param string $passwordInput
     */
    public function setPasswordInput(string $passwordInput): void
    {
        $this->passwordInput = $passwordInput;
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