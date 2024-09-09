<?php

namespace App\Services;

use App\Libs\DatwhsXdb\DatwhsXdb;

class IpService extends Service
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function vendor(): DatwhsXdb
    {
        return new DatwhsXdb(
            app_path('Libs/DatwhsXdb/datwhs-ipdb.xdb')
        );
    }

    public function toRegions(string|int $ip): array
    {
        if (!is_null($result = (fn(): string|null => $this->vendor()->search($ip))())) {
            return explode('|', $result);
        }

        return [];
    }

    /**
     * @noinspection PhpUnused
     */
    public function isInChina(string|int $ip): bool
    {
        $regions = $this->toRegions($ip);

        if (($regions[1] ?? null) === '中国') {
            if (!in_array($regions[2] ?? null, ['香港特别行政区', '澳门特别行政区', '台湾省'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * @noinspection PhpUnused
     */
    public function isInEastAsia(string|int $ip): bool
    {
        $regions = $this->toRegions($ip);
        $country = $regions[1] ?? null;

        if ($country === '中国' or $country === '日本' or $country === '新加坡' or $country === '韩国') {
            return true;
        }

        return false;
    }

    /**
     * @noinspection PhpUnused
     */
    public function ipInChinaNoCity(string|int $ip, array $city): bool
    {
        $regions = $this->toRegions($ip);

        if (($regions[1] ?? null) === '中国') {
            if (!in_array($regions[2] ?? null, ['香港特别行政区', '澳门特别行政区', '台湾省'])) {
                if (!in_array($regions[3] ?? null, $city)) {
                    return true;
                }
            }
        }

        return false;
    }
}
