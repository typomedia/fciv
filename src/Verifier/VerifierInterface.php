<?php

namespace Typomedia\Fciv\Verifier;

/**
 * Interface VerifierInterface
 * @package Typomedia\Fciv
 */
interface VerifierInterface
{
    /**
     * @param string $data
     * @return mixed
     */
    public function verify(string $data);
}
