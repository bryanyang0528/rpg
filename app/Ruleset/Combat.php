<?php

namespace App\RuleSet;


use App\Character;

class Combat
{
    /**
     * @param Character $attacker
     * @param Character $defender
     * @return string
     */
    public function attack(Character $attacker, Character $defender)
    {

        ob_start();

        while ($defender->hit_points > 0 && $attacker->hit_points > 0) {

            $attackerRoll = rand(1,6);
            $defenderRoll = rand(1,6);

            if ($attacker->agility + $attackerRoll >= $defender->agility + $defenderRoll) {
                $damage = (int) floor( $attacker->strength / 5 );
                $defender->hit_points -= $damage;

                echo "<li>{$attacker->name} deals {$damage} to {$defender->name} {$defender->hit_points}/{$defender->total_hit_points}</li>";
            } else {
                $damage = (int) floor( $defender->strength / 5 );
                $attacker->hit_points -= $damage;

                echo "<li>{$defender->name} deals {$damage} to {$attacker->name} {$attacker->hit_points}/{$attacker->total_hit_points}</li>";
            }
        }

        $attacker->save();
        $defender->save();

        return ob_get_clean();
    }

    public function createCharacter()
    {

    }
}