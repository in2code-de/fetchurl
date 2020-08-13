<?php

namespace In2code\Fetchurl\Utility;

class UrlUtility
{
    /**
     * @param string $url
     * @param array $additionalParameter
     * @return string
     */
    public static function appendAdditionalParameter(string $url, array $additionalParameter = [])
    {
        if (!empty($additionalParameter)) {
            $urlParts = parse_url($url);
            $params = [];

            if (isset($urlParts['query'])) {
                parse_str($urlParts['query'], $params);
            }

            foreach ($additionalParameter as $name => $value) {
                $params[$name] = $value;
            }

            $urlParts['query'] = http_build_query($params);

            return $urlParts['scheme'] . '://' . $urlParts['host'] . $urlParts['path'] . '?' . $urlParts['query'] . '#' . $urlParts['fragment'];
        }

        return $url;
    }
}
