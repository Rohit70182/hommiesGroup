<?php

namespace Modules\Smtp\helpers;

trait DnsHelper
{

    public static function getMXServer($email)
    {
        if (empty($email)) {
            return null;
        }
        $mxhosts = [];
        list ($username, $hostname) = explode('@', $email);
        if (dns_get_mx($hostname, $mxhosts)) {

            return $mxhosts[0];
        }
        return null;
    }
}