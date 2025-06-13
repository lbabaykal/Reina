<?php

namespace App\Http\Resources\Doramas;

use App\Http\Resources\CountriesResource;
use App\Http\Resources\FranchiseResource;
use App\Http\Resources\GenresResource;
use App\Http\Resources\StudiosResource;
use App\Http\Resources\TypesResource;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class DoramaShowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'poster' => $this->posterUrl,
            'cover' => $this->coverUrl,
            'title_org' => $this->title_org,
            'title_ru' => $this->title_ru,
            'title_en' => $this->title_en,
            'type' => TypesResource::make($this->type),
            'genres' => GenresResource::collection($this->genres),
            'studios' => StudiosResource::collection($this->studios),
            'countries' => CountriesResource::collection($this->countries),
            'age_rating' => $this->age_rating,
            'episodes_released' => $this->episodes_released,
            'episodes_total' => $this->episodes_total,
            'duration' => CarbonInterval::minutes($this->duration)->cascade()->forHumans(['short' => true]),
            'release' => Carbon::parse($this->release)->isoFormat('D MMMM, YYYY'),
            'year' => Carbon::parse($this->release)->format('Y'),
            'description' => $this->description,
            'rating' => $this->rating,
            'count_assessments' => $this->count_assessments,
            'is_comment' => $this->is_comment,
            'is_rating' => $this->is_rating,
            'franchise' => FranchiseResource::make($this->franchise),
        ];
    }
}
