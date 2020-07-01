<?php

$stats = array(
    'source' => 0,
    'player' => 0,
    'discover' => 0,
    'discover_not_e_count' => 0,
    'e_not_discover_count' => 0,
    'e_not_x_home' => array(),
);

foreach($this->E_model->fetch() as $en) {

    $stats['source']++;

    $is_player = count($this->X_model->fetch(array(
        'x__up' => 4430, //MENCH PLAYERS
        'x__type IN (' . join(',', $this->config->item('n___4592')) . ')' => null, //SOURCE LINKS
        'x__down' => $en['e__id'],
        'x__status IN (' . join(',', $this->config->item('n___7359')) . ')' => null, //PUBLIC
    ), array(), 1));
    $is_discover = count($this->X_model->fetch(array(
        'x__member' => $en['e__id'],
    ), array(), 1));

    if($is_player){
        $stats['player']++;
    }
    if($is_discover){
        $stats['discover']++;
    }
    if($is_player && !$is_discover){
        $stats['e_not_discover_count']++;
        array_push($stats['e_not_x_home'], $en);
    }
    if($is_discover && !$is_player){
        $stats['discover_not_e_count']++;
        $this->X_model->create(array(
            'x__type' => e_x__type(),
            'x__up' => 4430, //MENCH PLAYERS
            'x__member' => $en['e__id'],
            'x__down' => $en['e__id'],
        ));
    }

}

echo nl2br(print_r($stats, true));