<?php

namespace App\Services\Sms;

use App\Models\User;
use Faker;

class SmsVerification
{
    private $faker;

    public const TIME_ALIVE_MINUTES = 5;
    // Длина одноразового кода #####
    public const OTP_NUMS = 5;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    public function generateOneTimePassword(User $user): string
    {
        $code = $this->faker->numerify(str_repeat('#', self::OTP_NUMS));
        $user->setOneTimePassword($code);
        return $code;
    }

    public function checkVerificationSms(string $phone, string $code): bool
    {
        $user = User::FindByPhone($phone);
        if (!$user)
            return false;
        $realCode = $user->oneTimePassword?->password;
        $isExpire = ! $user?->oneTimePassword
            ?->updated_at
            ->addMinutes(self::TIME_ALIVE_MINUTES)
            ->isPast();
        return ($code == $realCode) && $isExpire;
    }

}
