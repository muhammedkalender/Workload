<?php


namespace App\Services;


use App\Contracts\Service;
use App\Traits\BasicJsonServiceTrait;

class FirstService implements Service
{
    use BasicJsonServiceTrait;

    /**
     * FirstService constructor.
     * @param string $provider
     */
    public function __construct(string $provider = "")
    {
        if (!$provider) {
            $provider = "first-provider";
        }

        $this->url = config('services.' . $provider . '.domain');

    }

    /**
     * @return array
     */
    public function getMappedArray(): array
    {
        $mappedArray = [];

        foreach ($this->content as $object) {
            $mappedArray[] = [
                'code' => $object['id'],
                'estimated_duration' => $object['sure'],
                'difficult' => $object['zorluk']
            ];
        }

        return $mappedArray;
    }
}
