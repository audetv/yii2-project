<?php

return [
    '' => 'site/index',
    'POST oauth2/<action:\w+>' => 'oauth2/rest/<action>',
    'OPTIONS oauth2/<action:\w+>' => 'oauth2/rest/<action>',
];
