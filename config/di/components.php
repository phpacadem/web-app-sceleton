<?php

return [
    new \Infrastructure\PDO\PdoComponent(),
    new \Infrastructure\Session\SessionComponent(),
    new \Auth\AuthComponent(),
    new \Blog\BlogComponent(),
    new \User\UserComponent(),
];