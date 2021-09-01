<?php

namespace Xatenev\Zippify\Model;

class UploadMapping
{

    /**
     * Generated token for upload.
     *
     * @var string
     */
    private string $token;

    /**
     * Upload type (tar/zip) see UploadType.
     *
     * @var string
     */
    private string $type;

    /**
     * File path to upload directory on disk.
     *
     * @var string
     */
    private string $filepath;

    /**
     * Array of uploaded files.
     *
     * @var UploadItem[]
     */
    private array $items = [];

    /**
     * @return UploadItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param UploadItem[] $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getFilepath(): string
    {
        return $this->filepath;
    }

    /**
     * @param string $filepath
     */
    public function setFilepath(string $filepath): void
    {
        $this->filepath = $filepath;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

}