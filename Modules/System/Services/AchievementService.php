<?php

namespace Modules\System\Services;

use Modules\System\Entities\Achievement;

class AchievementService
{
    /**
     * @param array $email
     *
     *
     * @return array
     */

    public function create(array $dane = []): array
    {
        $created = Achievement::create($dane);
        //event(new AchievementCreated($dane));

        return [
            'id' => $created->id,
            'name' => $created->name,
            'event_type' => $created->event_type,
            'value' => $created->value,
        ];
    }

    public function update(Achievement $achievement, array $dane = []): array
    {
        $achievement->update($dane);
        //event(new AchievementUpdated($achievement, $dane));

        return [
            'id' => $achievement->id,
            'name' => $achievement->name,
            'event_type' => $achievement->event_type,
            'value' => $achievement->value,
        ];
    }

     public function delete(Achievement $achievement): bool
     {
         return $achievement->delete();
     }
}
