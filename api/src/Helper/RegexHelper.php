<?php

namespace App\Helper;

class RegexHelper
{
    // example http://
    public const REGEX_HOSTNAME = '/(^\w+:|^)\/\/?(?:www\.)?/';

    // example www.
    public const REGEX_WWW = '/^((?!www\.).)*$/';

    // example subdomain.domain.com
    public const REGEX_DOMAIN = '/^([a-zA-Z0-9|-]+\.?){1,64}[[a-zA-Z0-9|-]+\.[a-zA-Z]+$/';
}
