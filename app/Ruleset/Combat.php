<?php

namespace App\RuleSet;


use App\Battle;
use App\Character;
use App\Log;

class Combat
{
    /**
     * @param Character $attacker
     * @param Character $defender
     * @param Battle $battle
     * @return string
     */
    public function attack(Character $attacker, Character $defender, Battle $battle)
    {
        $logs = [];
        while ($defender->hit_points > 0 && $attacker->hit_points > 0) {

            $attackerRoll = rand(1,6);
            $defenderRoll = rand(1,6);

            $log = new Log();

            if ($attacker->agility + $attackerRoll >= $defender->agility + $defenderRoll) {
                $damage = (int) ceil( $attacker->strength / 5 );
                $defender->hit_points -= $damage;

                $log->body = "{$attacker->name} deals {$damage} to {$defender->name} {$defender->hit_points}/{$defender->total_hit_points}";


            } else {
                $damage = (int) ceil( $defender->strength / 5 );
                $attacker->hit_points -= $damage;

                $log->body = "{$defender->name} deals {$damage} to {$attacker->name} {$attacker->hit_points}/{$attacker->total_hit_points}";
            }

            $logs[] = $log;
        }

        $attacker->save();
        $defender->save();

        $battle->participants()->saveMany([$attacker, $defender]);
        $battle->logs()->saveMany($logs);
    }

    public function createCharacter()
    {

    }
}