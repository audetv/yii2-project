<?php

declare(strict_types=1);

namespace core\helpers\database;

class Table
{
    const OPTIONS = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
    const USERS = '{{%users}}';
    const AUTH_ITEMS = '{{%auth_items}}';
    const AUTH_ITEM_CHILDREN = '{{%auth_item_children}}';
    const AUTH_ASSIGNMENTS = '{{%auth_assignments}}';
    const AUTH_RULES = '{{%auth_rules}}';
    const USER_PROFILES = '{{%user_profiles}}';
}
