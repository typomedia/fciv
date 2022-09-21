<?php

namespace Typomedia\Fciv\Entity;

/**
 * Class FILE_ENTRY
 * @package Typomedia\Fciv\Entity
 * @phpcs phpcs:ignoreFile
 */
class FILE_ENTRY
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $MD5;

    /**
     * @var string
     */
    public $SHA1;

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = str_replace('/', '\\', $name);
    }

    /**
     * @param string $MD5
     */
    public function setMD5(string $MD5): void
    {
        $md5 = md5_file($MD5);
        $hex = hex2bin($md5);
        $this->MD5 = base64_encode($hex);
    }

    /**
     * @param string $SHA1
     */
    public function setSHA1(string $SHA1): void
    {
        $sha1 = sha1_file($SHA1);
        $hex = hex2bin($sha1);
        $this->SHA1 = base64_encode($hex);
    }
}
