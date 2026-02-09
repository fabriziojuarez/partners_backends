<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnrollmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "curso" => new CourseResource($this->whenLoaded('course')),
            "partner" => new PartnerResource($this->whenLoaded('partner')),
            "period" => $this->period,
        ];
    }
}
