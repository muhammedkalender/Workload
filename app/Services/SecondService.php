<?php


namespace App\Services;


use App\Contracts\Service;
use App\Traits\BasicJsonServiceTrait;

class SecondService implements Service
{
    use BasicJsonServiceTrait;

    /**
     * FirstService constructor.
     * @param string $provider
     */
    public function __construct(string $provider = "")
    {
        if (!$provider) {
            $provider = "second-provider";
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
            $key = array_key_first($object);

            $mappedArray[] = [
                'code' => $key,
                'estimated_duration' => $object[$key]['estimated_duration'],
                'difficult' => $object[$key]['level']
            ];
        }

        return $mappedArray;
    }
}
