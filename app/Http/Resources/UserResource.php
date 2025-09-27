<?php

namespace App\Http\Resources;

use App\Enums\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function __construct($resource, $expiresAt = null)
    {
        parent::__construct($resource);
        $this->expiresAt = $expiresAt;
    }

    public function toArray(Request $request): array
    {
        $user = $this->resource;
        $plans = $user->plansPurchases->filter(function ($plan){
            return OrderStatus::inArraySuccess($plan?->order?->status?->value);
        });

        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'patronymic' => $this->patronymic,
            'phone' => $this->phone,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'created_at' => $this->created_at,
            'plans' => PlanResource::collection($plans),
            'tasks_count' => $user?->clientTasks?->count() ?? 0,
            'plans_count' => $plans->count(),
            'regionName' => $user->region?->name,
            'regionKladrId' => $user->region?->kladrId,
            'creator' => $user->getCreatorName(),
            'statusSiteAgreements' => true,
        ] + ($this->expiresAt ? ['expires_in' => $this->expiresAt]: []);
    }
}
