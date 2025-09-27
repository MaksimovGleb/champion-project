<?php

namespace App\Models;

use App\Models\Payment\Purchase;
use Carbon\Carbon;

class UsedInfo
{
    private $expirationSoon;

    private $expirationNormal;

    private $expired;

    private $neverExpired;

    private $usedCount;

    private $limit;

    public function __construct(Purchase $purchase)
    {
        $now = Carbon::now();
        $expiration = Carbon::createFromTimestamp($purchase->expiration_date);

        $this->expirationSoon = (bool) $expiration->addMonths(1)->gte($now);
        $this->expirationNormal = (bool) $expiration->addMonths(6)->gte($now);
        $this->expired = (bool) $expiration->lt($now);
        $this->neverExpired = (bool) $expiration == Carbon::createFromTimestamp(0);

        $this->usedCount = $purchase->count;
        $this->limit = $purchase->limit;
    }

    public function getUsedCount()
    {
        return $this->usedCount;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function isExpirationSoon()
    {
        return $this->expirationSoon;
    }

    public function isExpirationNormal()
    {
        return $this->expirationNormal;
    }

    public function isExpired()
    {
        return $this->expired;
    }

    public function isNeverExpiration()
    {
        return $this->neverExpired;
    }
}
