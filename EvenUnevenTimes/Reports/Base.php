<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\EvenUnevenTimes\Reports;

use Piwik\Plugin\Report;

/**
 * Class Base
 * @package Piwik\Plugins\EvenUnevenTimes\Reports
 */
abstract class Base extends Report
{
    /** @inheritdoc */
    protected function init()
    {
        $this->category = 'General_Visitors';
    }
}
