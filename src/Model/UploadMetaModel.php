<?php

namespace Xatenev\Zippify\Model;

use DateTime;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

class UploadMetaModel implements JsonSerializable
{
    private string $token;
    private string $type;
    private DateTime $expiration;
    private int $size;
    private int $count;

    /**
     * UploadMeta constructor.
     *
     * @param string $token
     * @param string $type
     * @param DateTime $expiration
     * @param int $size
     * @param int $count
     */
    public function __construct(string $token, string $type, DateTime $expiration, int $size, int $count)
    {
        $this->token = $token;
        $this->type = $type;
        $this->expiration = $expiration;
        $this->size = $size;
        $this->count = $count;
    }

    #[ArrayShape(['token' => "string", 'expiration' => "\DateTime", 'size' => "int", 'count' => "int"])]
    public function jsonSerialize(): array
    {
        return [
            'token' => $this->token,
            'type' => $this->type,
            'expiration' => $this->expiration->getTimestamp(),
            'size' => $this->size,
            'count' => $this->count
        ];
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
     * @return DateTime
     */
    public function getExpiration(): DateTime
    {
        return $this->expiration;
    }

    /**
     * @param DateTime $expiration
     */
    public function setExpiration(DateTime $expiration): void
    {
        $this->expiration = $expiration;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     */
    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
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