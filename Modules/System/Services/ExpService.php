<?php

namespace Modules\System\Services;

use Modules\System\Entities\Achievement;
use Modules\Auth\Entities\User;
class ExpService
{
    public function updateExp(User $user, int $reward){
        $user_xp = $user->xp + $reward;
        $user_lvl = $user->lvl;

        $lvl_xp_to_next_lvl = 1000 + 10*($user_lvl) * log($user_lvl, 2);
        while($user_xp >= $lvl_xp_to_next_lvl){
            $user_lvl = $user_lvl + 1;
            $user_xp = $user_xp - $lvl_xp_to_next_lvl;
            $lvl_xp_to_next_lvl = 1000 + 10*($user_lvl) * log($user_lvl, 2);
        }
        $user->update([
            'lvl' => $user_lvl,
            'xp' => $user_xp,
        ]);
    }

}
