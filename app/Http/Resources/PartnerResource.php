<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PartnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'role' => new PartnerRoleResource($this->whenLoaded('partner_role')),
            'user' => new UserResource($this->whenLoaded('user')),
            'enrolled_courses' => EnrollmentResource::collection($this->whenLoaded('enrollments')),
            'managed_courses' => CourseResource::collection($this->whenLoaded('managedCourses')),
        ];
    }
}
