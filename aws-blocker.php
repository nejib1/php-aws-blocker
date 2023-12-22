#!/usr/bin/env php
<?php

function getJsonData($url) {
    $torProxy = '127.0.0.1:9050'; // Tor proxy address and port

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_PROXY, $torProxy);
    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5_HOSTNAME);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $response = curl_exec($ch);
    if ($response === false) {
        echo 'Curl error: ' . curl_error($ch);
    }

    curl_close($ch);
    return $response;
}

function isIpBlocked($ip, $currentRules) {
    $rule = "-A INPUT -s $ip -j DROP";
    return in_array($rule, $currentRules);
}

$json_url = "https://ip-ranges.amazonaws.com/ip-ranges.json";
$json_data = getJsonData($json_url);

if ($json_data === false) {
    die("Error fetching JSON data.\n");
}

$data = json_decode($json_data, true);
if ($data === null) {
    die("Error decoding JSON data.\n");
}

$ip_ranges = array_merge(
    array_column($data['prefixes'] ?? [], 'ip_prefix'),
    array_column($data['ipv6_prefixes'] ?? [], 'ipv6_prefix')
);

// Fetch all current iptables rules
exec("iptables -S INPUT", $currentV4Rules);
exec("ip6tables -S INPUT", $currentV6Rules);

foreach ($ip_ranges as $ip) {
    $ip_version = strpos($ip, ':') === false ? '' : '6';
    $currentRules = $ip_version === '6' ? $currentV6Rules : $currentV4Rules;

    if (!isIpBlocked($ip, $currentRules)) {
        $command = "ip{$ip_version}tables -A INPUT -s $ip -j DROP";
        exec($command, $output, $return_var);
        if ($return_var !== 0) {
            echo "Failed to execute: $command\n";
        }
    }
}

echo "IP blocking complete.\n";
