<?php

return array(
    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null
    ),
    'seller' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Seller',
        'children' => array(
            'guest',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'customer' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Customer',
        'children' => array(
            'seller',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'moderator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Moderator',
        'children' => array(
            'customer',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'administrator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Administrator',
        'children' => array(
            'moderator',
        ),
        'bizRule' => null,
        'data' => null
    ),
);
