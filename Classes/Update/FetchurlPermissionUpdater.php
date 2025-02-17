<?php

declare(strict_types=1);

namespace In2code\Fetchurl\Update;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Install\Updates\DatabaseUpdatedPrerequisite;
use TYPO3\CMS\Install\Updates\UpgradeWizardInterface;

class FetchurlPermissionUpdater implements UpgradeWizardInterface
{
    public function getIdentifier(): string
    {
        return 'fetchurlPermissionUpdater';
    }

    public function getTitle(): string
    {
        return 'EXT:fetchurl: Migrate plugin permissions';
    }

    public function getDescription(): string
    {
        $description = 'This update wizard updates all permissions for plugins and modules';
        $description .= ' Count of affected groups: ' . count($this->getMigrationRecords());
        return $description;
    }

    public function getPrerequisites(): array
    {
        return [
            DatabaseUpdatedPrerequisite::class,
        ];
    }

    public function updateNecessary(): bool
    {
        return $this->checkIfWizardIsRequired();
    }

    public function executeUpdate(): bool
    {
        return $this->performMigration();
    }

    public function checkIfWizardIsRequired(): bool
    {
        return count($this->getMigrationRecords()) > 0;
    }

    public function performMigration(): bool
    {
        $records = $this->getMigrationRecords();

        foreach ($records as $record) {
            $this->updateRow($record);
        }

        return true;
    }

    protected function getMigrationRecords(): array
    {
        $connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
        $queryBuilder = $connectionPool->getQueryBuilderForTable('be_groups');
        $queryBuilder->getRestrictions()->removeAll()->add(GeneralUtility::makeInstance(DeletedRestriction::class));

        return $queryBuilder
            ->select('uid', 'explicit_allowdeny', 'groupMods', 'non_exclude_fields')
            ->from('be_groups')
            ->where(
                $queryBuilder->expr()->like(
                    'explicit_allowdeny',
                    $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards('tt_content:list_type:fetchurl_pi1') . '%')
                )
            )
            ->executeQuery()
            ->fetchAllAssociative();
    }

    protected function updateRow(array $row): void
    {
        $nonExcludeFieldsReplacement = [
            'tt_content:pi_flexform;fetchurl_pi1;main;settings.main.url' => 'tt_content:pi_flexform;fetchurl_pi1;main;settings.main.url,tt_content:pi_flexform;fetchurl_pi2;main;settings.main.url',
            'tt_content:pi_flexform;fetchurl_pi1;main;settings.main.width' => 'tt_content:pi_flexform;fetchurl_pi2;main;settings.main.width',
            'tt_content:pi_flexform;fetchurl_pi1;main;settings.main.height' => 'tt_content:pi_flexform;fetchurl_pi2;main;settings.main.height',
            'tt_content:pi_flexform;fetchurl_pi1;main;settings.main.scrolling' => 'tt_content:pi_flexform;fetchurl_pi2;main;settings.main.scrolling',
        ];

        $pi1Replacement = 'tt_content:CType:fetchurl_pi1,tt_content:CType:fetchurl_pi2';

        if (GeneralUtility::makeInstance(Typo3Version::class)->getMajorVersion() >= 12) {
            $searchReplace = [
                'tt_content:list_type:fetchurl_pi1:ALLOW' => $pi1Replacement,
                'tt_content:list_type:fetchurl_pi1:DENY' => '',
                'tt_content:list_type:fetchurl_pi1' => $pi1Replacement,
            ];
        } else {
            $pi1Replacement .= ',';
            $pi1Replacement = str_replace(',', ':ALLOW,', $pi1Replacement);
            $searchReplace = [
                'tt_content:list_type:fetchurl_pi1:ALLOW' => $pi1Replacement,
                'tt_content:list_type:fetchurl_pi1:DENY' => str_replace($pi1Replacement, 'ALLOW', 'DENY'),
            ];
        }

        $nonExcludeFields = str_replace(array_keys($nonExcludeFieldsReplacement), array_values($nonExcludeFieldsReplacement), $row['non_exclude_fields']);
        $allowDeny = str_replace(array_keys($searchReplace), array_values($searchReplace), $row['explicit_allowdeny']);

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('be_groups');
        $queryBuilder->update('be_groups')
            ->set('explicit_allowdeny', $allowDeny)
            ->set('non_exclude_fields', $nonExcludeFields)
            ->where(
                $queryBuilder->expr()->in(
                    'uid',
                    $queryBuilder->createNamedParameter($row['uid'], Connection::PARAM_INT)
                )
            )
            ->executeStatement();
    }
}
