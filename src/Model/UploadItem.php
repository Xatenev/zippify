<?php

namespace Xatenev\Zippify\Model;

class UploadItem
{

    /**
     * UploadItem constructor.
     *
     * @param string $key
     * @param string $value
     */
    public function __construct(string $key, string $value) {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * Generated token file name.
     *
     * @var string
     */
    private string $key;

    /**
     * Original file name.
     *
     * @var string
     */
    private string $value;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @param string $key
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }
}