<?php

namespace In2code\Fetchurl\Domain\Service;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

/**
 * Class UrlAppendService
 */
class UrlAppendService
{

    /**
     * @param string $url
     * @param string $mode "static" or "iframe"
     * @return string
     */
    public function getUrl($url, $mode)
    {
        $parameters = $this->getParameters($mode);
        return $this->appendAdditionalParameterToUrl($url, $parameters);
    }

    /**
     * @param string $url
     * @param array $additionalParameter
     * @return string
     */
    public function appendAdditionalParameterToUrl($url, $additionalParameter = [])
    {
        if ($additionalParameter !== []) {
            $urlParts = parse_url($url);
            $params = [];

            if (isset($urlParts['query'])) {
                parse_str($urlParts['query'], $params);
            }

            foreach ($additionalParameter as $name => $value) {
                if (!empty($value)) {
                    $params[$name] = $value;
                }
            }

            $urlParts['query'] = http_build_query($params);

            $url = $urlParts['scheme'] . '://' . $urlParts['host'] . $urlParts['path'];

            if (!empty($urlParts['query'])) {
                $url .= '?' . $urlParts['query'];
            }

            if (!empty($urlParts['fragment'])) {
                $url .= '#' . $urlParts['fragment'];
            }
        }
        return $url;
    }

    /**
     * @param string $mode "static" or "iframe"
     * @return array
     */
    protected function getParameters($mode)
    {
        $configuration = $this->getConfigurationForMode($mode);
        $parameters = [];
        foreach ($configuration as $key => $value) {
            if (substr($key, -1) === '.') {
                continue;
            }
            if (isset($configuration[$key . '.'])) {
                $parameters[$key] = $this->getStdWrapValue($configuration, $key);
            } else {
                $parameters[$key] = $value;
            }
        }
        return $parameters;
    }

    /**
     * @param $configuration
     * @param $key
     * @return string
     */
    protected function getStdWrapValue($configuration, $key)
    {
        /** @var ContentObjectRenderer $contentObject */
        $contentObject = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        return $contentObject->cObjGetSingle($configuration[$key], $configuration[$key . '.']);
    }

    /**
     * @param $mode
     * @return array
     */
    protected function getConfigurationForMode($mode): array
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
        $configuration = $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT,
            'Fetchurl',
            'Pi1'
        );
        return (array)$configuration['plugin.']['tx_fetchurl_pi1.']['settings.']['additionalParameter.'][$mode . '.'];
    }
}
