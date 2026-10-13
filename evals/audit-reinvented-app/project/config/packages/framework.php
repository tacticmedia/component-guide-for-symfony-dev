<?php

use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework): void {
    $framework->secret('%env(APP_SECRET)%');
    $framework->session()->enabled(true);
    $framework->assets()->baseUrls(['https://cdn.acme.test']);
};
