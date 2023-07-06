<?php

declare(strict_types=1);

namespace In2code\Fetchurl\Domain\Service;

use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;

class UrlAppendService
{
    /**
     * @param string $mode "static" or "iframe"
     * @throws InvalidConfigurationTypeException
     */
    public function getUrl(string $url, string $mode): string
    {
        $parameters = $this->getParameters($mode);
        return $this->appendAdditionalParameterToUrl($url, $parameters);
    }

    public function appendAdditionalParameterToUrl(string $url, array $additionalParameter = []): string
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
     * @throws InvalidConfigurationTypeException
     */
    protected function getParameters(string $mode): array
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

    protected function getStdWrapValue(array $configuration, string $key): string
    {
        /** @var ContentObjectRenderer $contentObject */
        $contentObject = GeneralUtility::makeInstance(ContentObjectRenderer::class);
        return $contentObject->cObjGetSingle($configuration[$key], $configuration[$key . '.']);
    }

    /**
     * @throws InvalidConfigurationTypeException
     */
    protected function getConfigurationForMode(string $mode): array
    {
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
        $configuration = $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT,
            'Fetchurl',
            'Pi1'
        );

        if (!ArrayUtility::isValidPath(
            $configuration,
            'plugin./tx_fetchurl_pi1./settings./additionalParameter./' . $mode . '.')
        ) {
            return [];
        }

        return (array)$configuration['plugin.']['tx_fetchurl_pi1.']['settings.']['additionalParameter.'][$mode . '.'];
    }
}
