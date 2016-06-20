<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\EvenUnevenTimes;

use Piwik\DataTable;
use Piwik\DataTable\Row;

/**
 * API for plugin EvenUnevenTimes
 *
 * @method static \Piwik\Plugins\EvenUnevenTimes\API getInstance()
 */
class API extends \Piwik\Plugin\API
{
    /**
     * @param int    $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable
     */
    public function getEvenUnevenTimes($idSite, $period, $date, $segment = false)
    {
        $data = $this->getVisits($idSite, $period, $date, $segment);
        $data->applyQueuedFilters();

        $visits = $this->countEvenUnevenTimes($data);

        $table = new DataTable();
        $table->addRowFromArray(array(Row::COLUMNS => array('label'=> 'Even', 'nb_visits' => $visits['even'] )));
        $table->addRowFromArray(array(Row::COLUMNS => array('label' => 'Uneven', 'nb_visits' => $visits['uneven'] )));

        return $table;
    }

    /**
     * @param int    $idSite
     * @param string $period
     * @param string $date
     * @param bool|string $segment
     * @return DataTable|string The data resulting from the API call.
     */
    private function getVisits($idSite, $period, $date, $segment = false)
    {
        return  \Piwik\API\Request::processRequest('Live.getLastVisitsDetails', array(
            'idSite' => $idSite,
            'period' => $period,
            'date' => $date,
            'segment' => $segment,
            'numLastVisitorsToFetch' => 100,
            'minTimestamp' => false,
            'flat' => false,
            'doNotFetchActions' => true
        ));
    }

    /**
     * @param DataTable $data
     * @return array
     */
    public static function countEvenUnevenTimes($data)
    {
        $result = [ 'even' => 0, 'uneven' => 0 ];

        foreach ($data->getRows() as $visitRow) {
            $localHour = intval($visitRow->getColumn('visitLocalHour'));

            if($localHour % 2 == 0) {
                $result['even']++;
            } else {
                $result['uneven']++;
            }
        }

        return $result;
    }
}
