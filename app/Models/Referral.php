<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Models\Payment\PartnershipSettings;
use App\Models\Payment\Payment;
use Illuminate\Support\Collection;

class Referral
{
    public static function pushNewReferral(User $userFather, User $userSon)
    {
//        if ($userSon->referrer) {
//            throw new \Exception("Пользователь $userSon->FullName не может быть повторно приглашён");
//        }

        if ($userSon->id == $userFather->id) {
            throw new \Exception('Вы не можете пригласить самого себя');
        }

        $userFather->referrals()->save($userSon);
    }

    /**
     * Возвращает дерево всех ПРИГЛАШЁННЫХ пользователей с дополнительным временным полем level(относительный) (Голову не включает, голова - $userFather)
     * Можно ограничить обход дерева, указав $maxLevel
     *
     * @param  User  $userFather юзер, чьих рефералов мы ищем
     * @param  int  $maxLevel максимальная глубина дерева
     * @param  int  $level
     * @return Collection
     */
    private static function getAllChildren(User $userFather, $maxLevel = 0, $level = 0)
    {
        $result = collect();
        foreach ($userFather->referrals as $child) {
            if ($level < $maxLevel) {
                $child->setAttribute('level', $level);
                $result->push($child);
                $result = $result->merge(self::getAllChildren($child, $maxLevel, $level + 1));
            }
        }

        return $result;
    }

    /**
     * Возвращает дерево всех ПРИГЛАШАЮЩИХ пользователей с дополнительным временным полем level(относительный) (Голову не включает, голова - $userFather)
     * Можно ограничить обход дерева, указав $maxLevel
     *
     * @param  User  $userChildren юзер, чьих рефереров мы ищем
     * @param  int  $maxLevel максимальная высота дерева
     * @param  int  $level
     * @return Collection
     */
    private static function getAllParents(User $userChildren, $maxLevel = 0, $level = 0)
    {
        $result = collect();
        $parent =$userChildren->referrer;

        if ($parent)
            if ($level < $maxLevel) {
                $parent->setAttribute('level', $level);
                $result->push($parent);
                $result = $result->merge(self::getAllParents($parent, $maxLevel, $level + 1));
            }

        return $result;
    }

    /**
     * Преобразует дерево (цепочку) пользователей с дополнительным временным полем level(относительный)
     * в массив мерности пп
     *
     * @param  Collection  $tree Все приведённые дети - рефералы
     * @param $maxLevel Максимальный уровень партнёрской программы
     * @param $level
     * @return array
     */
    private static function convertTreeToArray(Collection $tree, $maxLevel = 0, $level = 0): array
    {
        $result = [];

        if ($level < $maxLevel) {
            foreach ($tree as $key => $node) {
                if ($node->level == $level) {
                    $result[$level][$key] = $node;
                }
            }

            $result = array_merge($result, self::convertTreeToArray($tree, $maxLevel, $level + 1));
        }

        return $result;
    }

    /** Возвращает коллекцию всех ПРИГЛАШАЮЩИХ пользователей.
     * С дополнительными временными полями level и Amount  */
    public static function getAllInvitersUsersAndAmount(User $user)
    {
        $settings = PartnershipSettings::First();

        $max = $settings->levels;

        $parents = Referral::getAllParents($user, $max);

        foreach($parents as $parent){
            $parent->setAttribute('amount', Referral::getAmount($user, $parent->level));
        }

        return $parents;
    }

    /** Возвращает массив всех ПРИГЛАШЁННЫХ пользователей. Массив отсортирован по индексам, согласно уровням */
    public static function getAllInvitedUsersAndSort(User $user): array
    {
        $settings = PartnershipSettings::First();

        $max = $settings->levels;

        $childrens = Referral::getAllChildren($user, $max);

        $result = Referral::convertTreeToArray($childrens, $max);

        return $result;
    }

    public static function generatePaymentsForClientPP(User $userFather)
    {
        $payments = self::getPaymentsForClientPP($userFather);

        $userFather->payments()->saveMany($payments);
        $userFather->refresh();

        return $payments;
    }

    /** Сколько денег может запросить по КПП */
    public static function getCurrentEarningsByClientsPP(User $user, $alsoUseStatus = PaymentStatus::STATUS_UNPAID): float
    {
        $result = 0;
        $payments = self::getPaymentsForClientPP($user, $alsoUseStatus);

        foreach ($payments as $payment) {
            $result += $payment->summa;
        }

        return $result;
    }

    /**
     * Делает расчёты платёжек по ПП клиента
     * @return Collection Коллекция Payments, в базе не сохраняется ничего
     */
    public static function getPaymentsForClientPP(User $userFather, $alsoUseStatus = PaymentStatus::STATUS_UNPAID)
    {
        $payments = collect();
        $summa = 0;

        $settings = PartnershipSettings::First();
        $max = $settings->levels;

        $users = self::getAllChildren($userFather, $max);
        $childsArray = self::convertTreeToArray($users, $max);

        foreach ($childsArray as $level => $currentLevelUsers) {
            foreach ($currentLevelUsers as $user) {
                $summa = self::getAmount($user, $level);
                if ($summa) {
                    $pay = $userFather->payment($user);

                    if ($pay->status == PaymentStatus::STATUS_UNPAID->value || $pay->status == $alsoUseStatus) {
                        $payments->push(new Payment([
                            'user_ref_id' => $user->id,
                            'status' => PaymentStatus::STATUS_PAYING_PROCESS,
                            'type' => PaymentType::TYPE_CLIENT_PP,
                            'summa' => $summa,
                        ]));
                    }
                }
            }
        }

        return $payments;
    }

    /** Возвращает сколько денег заработал пользователь, который привёл $referralа, согласно его уровню в пп */
    public static function getAmount(User $referral, int $level): float
    {
        $settings = PartnershipSettings::First();
        $rools = $settings->rools;

        if ($level < $rools->count()) {
            $percent = $rools[$level]->percent;
        } else {
            return 0;
        }

        return $referral->getFirstOrderAmount() / 100 * $percent;
    }

    /** Считает стоимость по первым покупкам всех рефералов реферера */
    private static function calcAmount(User $referrer, $maxLevel = 0, $level = 0): float
    {
        $result = 0;
        foreach ($referrer->referrals as $child) {
            if ($level < $maxLevel) {
                $result += self::getAmount($child, $level);
                $result += self::calcAmount($child, $maxLevel, $level + 1);
            }
        }

        return $result;
    }
}
