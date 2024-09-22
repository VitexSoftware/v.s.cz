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
    public $myTable = 'vs_access_log';

    public function setUp($options = []): void
    {
        $this->setupProperty($options, 'dbType', 'STATS_TYPE');
        $this->setupProperty($options, 'server', 'STATS_SERVER');
        $this->setupProperty($options, 'username', 'STATS_USERNAME');
        $this->setupProperty($options, 'password', 'STATS_PASSWORD');
        $this->setupProperty($options, 'database', 'STATS_DATABASE');
        $this->setupProperty($options, 'port', 'STATS_PORT');
        $this->setupProperty($options, 'connectionSettings', 'STATS_SETUP');
    }

    /**
     * @return int
     */
    public function getUpdatedCount()
    {
        return $this->listingQuery()->select('count(*) as count')->where(
            'request_uri',
            '/dists/stable/InRelease',
        )->fetch()['count'];
    }

    public function getPackageInstalls($pName)
    {
        return $this->listingQuery()->select('count(*) as count')->where(sprintf(
            "request_uri LIKE '/pool/main/%%/%s_%%'",
            $pName,
        ))->where("agent LIKE 'Debian APT%%'")->fetch()['count'];
    }

    public function getPackageDownloads($pName)
    {
        return $this->listingQuery()->select('count(*) as count')->where(sprintf(
            "request_uri LIKE '/pool/main/%%/%s_%%'",
            $pName,
        ))->where("agent  NOT LIKE 'Debian APT%%'")->fetch()['count'];
    }

    public function getPackageVersionInstalls($pName)
    {
        $allInstalls = [];
        $viRaw = $this->listingQuery()->select('COUNT(*) as count')->select('FROM_UNIXTIME(time_stamp) as last')->
                where(sprintf("request_uri LIKE '/pool/main/%%/%s_%%'", $pName))->where("agent LIKE 'Debian APT%%'")->groupBy('request_uri')->orderBy('request_uri DESC');

        foreach ($viRaw as $installs) {
            [$tmp, $ver, $tmp] = explode('_', $installs['request_uri']);
            $allInstalls[] = ['count' => $installs['count'], 'ver' => $ver, 'last' => $installs['last']];
        }

        return $allInstalls;
    }
}
