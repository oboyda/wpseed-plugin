<?php

namespace HSP;

use HSP\Type\Agent;

class Utils_Agent
{
    static function getAgents()
    {
        $users = [];

        $_users = get_users([
            'role' => 'subscriber',
            'meta_key' => 'is_agent',
            'meta_value' => 1
        ]);

        if($_users)
        {
            foreach($_users as $_user)
            {
                $users[] = new Agent($_user);
            }
        }

        return $users;
    }

    static function getRandomAgent()
    {
        $agents = self::getAgents();
        if($agents)
        {
            shuffle($agents);
            return $agents[0];
        }
        return null;
    }
}
