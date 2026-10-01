<?php

declare(strict_types=1);

/**
 * This file is part of the VitexSoftware package
 *
 * https://vitexsoftware.com/
 *
 * (c) Vítězslav Dvořák <http://vitexsoftware.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace VSCZ;

/**
 * Description of AccessLog.
 *
 * @author Vítězslav Dvořák <info@vitexsoftware.cz>
 */
class AccessLog extends \Ease\SQL\Engine
{
    public string $myTable = 'vs_access_log';
    public string $username = '';
    public string $password = '';

    public function setUp($options = []): bool
    {
        $this->setupProperty($options, 'dbType', 'STATS_TYPE');       // Ease
        $this->setupProperty($options, 'dbType', 'STATS_CONNECTION'); // Laralvel
        $this->setupProperty($options, 'server', 'STATS_HOST');
        $this->setupProperty($options, 'dbLogin', 'STATS_USERNAME');
        $this->setupProperty($options, 'dbPass', 'STATS_PASSWORD');
        $this->setupProperty($options, 'database', 'STATS_DATABASE');
        $this->setupProperty($options, 'port', 'STATS_PORT');
        $this->setupProperty($options, 'connectionSetup', 'STATS_SETUP');
        $this->setupProperty($options, 'dbSettings', 'STATS_SETTINGS');
        $this->setupProperty($options, 'myTable');
        $this->setupProperty($options, 'debug', 'STATS_DEBUG');

        // Without a separate stats database the access log is expected in the main one.
        if (empty($this->dbType)) {
            $this->setupProperty($options, 'dbType', 'DB_TYPE');
            $this->setupProperty($options, 'server', 'DB_HOST');
            $this->setupProperty($options, 'dbLogin', 'DB_USERNAME');
            $this->setupProperty($options, 'dbPass', 'DB_PASSWORD');
            $this->setupProperty($options, 'database', 'DB_DATABASE');
            $this->setupProperty($options, 'port', 'DB_PORT');
        }

        return true;
    }

    /**
     * How many times apt fetched the repository index.
     */
    public function getUpdatedCount(): int
    {
        return $this->countRequests('request_uri = ?', ['/dists/stable/InRelease']);
    }

    public function getPackageInstalls($pName): int
    {
        return $this->countRequests('request_uri LIKE ? AND agent LIKE ?', [self::poolPattern($pName), 'Debian APT%']);
    }

    public function getPackageDownloads($pName): int
    {
        return $this->countRequests('request_uri LIKE ? AND agent NOT LIKE ?', [self::poolPattern($pName), 'Debian APT%']);
    }

    public function getPackageVersionInstalls($pName): array
    {
        $allInstalls = [];

        try {
            $viRaw = $this->listingQuery()->select('COUNT(*) as count')->select('FROM_UNIXTIME(time_stamp) as last')
                ->where('request_uri LIKE ? AND agent LIKE ?', self::poolPattern($pName), 'Debian APT%')
                ->groupBy('request_uri')->orderBy('request_uri DESC');

            foreach ($viRaw as $installs) {
                $ver = explode('_', (string) $installs['request_uri'])[1] ?? '';
                $allInstalls[] = ['count' => $installs['count'], 'ver' => $ver, 'last' => $installs['last']];
            }
        } catch (\Throwable $exception) {
            // no access log (stats DB not configured or unreachable)
        }

        return $allInstalls;
    }

    private static function poolPattern(string $pName): string
    {
        return '/pool/main/%/'.addcslashes($pName, '%_\\').'\_%';
    }

    private function countRequests(string $condition, array $params): int
    {
        try {
            return (int) ($this->listingQuery()->select('count(*) as count')->where($condition, ...$params)->fetch()['count'] ?? 0);
        } catch (\Throwable $exception) {
            return 0; // no access log (stats DB not configured or unreachable)
        }
    }
}
