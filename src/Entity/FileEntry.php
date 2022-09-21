<?php

namespace Typomedia\Fciv\Entity;

/**
 * Class FileEntry
 * @package Typomedia\Fciv\Entity
 */
class FileEntry
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $md5;

    /**
     * @var string
     */
    public $sha1;

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = str_replace('/', '\\', $name);
    }

    /**
     * @param string $md5
     */
    public function setMd5(string $md5): void
    {
        $md5 = md5_file($md5);
        $hex = hex2bin($md5);
        $this->md5 = base64_encode($hex);
    }

    /**
     * @param string $sha1
     */
    public function setSha1(string $sha1): void
    {
        $sha1 = sha1_file($sha1);
        $hex = hex2bin($sha1);
        $this->sha1 = base64_encode($hex);
    }
}
