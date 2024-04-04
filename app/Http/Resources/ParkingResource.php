<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\ParkingPriceService;

class ParkingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        $totalPrice = $this->total_price ?? ParkingPriceService::calculatePrice(
            $this->zone_id,
            $this->start_time,
            $this->stop_time
        ); //The '??' operator is called the null coalescing operator.

        return [
            'id'          => $this->id,
            'zone'        => [
                'name'           => $this->zone->name,
                'price_per_hour' => $this->zone->price_per_hour,
            ],
            'vehicle'     => [
                'plate_number' => $this->vehicle->plate_number,
                'description'  => $this->vehicle->description,
            ],
            'start_time'  => $this->start_time->toDateTimeString(),
            'stop_time'   => $this->stop_time?->toDateTimeString(),
            'total_price' => $totalPrice,
        ];
    }
}
