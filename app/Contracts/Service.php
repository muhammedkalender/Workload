<?php


namespace App\Contracts;

interface Service
{
    /**
     * @param string $url
     * @return int
     */
    public function sendRequest(string $url = "") : int;

    /**
     * @return array
     */
    public function getMappedArray() : array;

    /**
     * Service constructor.
     * @param string $provider
     */
    public function __construct(string $provider = "");
}
