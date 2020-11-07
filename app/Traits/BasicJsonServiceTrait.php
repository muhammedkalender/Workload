<?php


namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait BasicJsonServiceTrait
{
    /**
     * @var bool
     * Servisin çağrılma durumunu belirtiyor
     */
    protected $serviceCalled = false;

    /**
     * @var int
     */
    protected $lastRequestStatus = 0;

    /**
     * @var string
     */
    protected $url = '';

    /**
     * @var string
     */
    protected $content = [];

    /**
     * @param string $url
     * @return int
     */
    public function sendRequest(string $url = null): int
    {
        $this->serviceCalled = true;

        $url = $url ?? ($this->url ?? config('services.' . config('services.default-provider') . '.domain', ""));

        if (!$url) {
            return 0;
        }

        $request = Http::get($url);

        $this->lastRequestStatus = $request->status();

        if ($request->status() != 200) {
            return $request->status();
        }

        $this->content = $request->json();

        return 200;
    }
}
