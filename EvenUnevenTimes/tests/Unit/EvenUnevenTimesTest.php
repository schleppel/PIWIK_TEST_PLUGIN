<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\EvenUnevenTimes\tests\Unit;

use Piwik\DataTable;
use Piwik\DataTable\Row;
use Piwik\Plugins\EvenUnevenTimes\API;

/**
 * @group EvenUnevenTimes
 * @group EvenUnevenTimesTest
 * @group Plugins
 */
class EvenUnevenTimesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DataTable
     */
    private $data;

    /*************************************************************************/
    /** TESTS  */

    /** Test method API::countEvenUnevenTimes */
    public function testGetEvenUnevenTimes()
    {
        $expectedArray = [ 'even' => 1, 'uneven' => 3  ];

        $this->assertEquals($expectedArray, API::countEvenUnevenTimes($this->data), "TEST 1 - counting visits in even and ueven hours");
    }

    /*************************************************************************/
    /** UTILS  */

    /** @inheritdoc */
    public function setUp()
    {
        $this->data = new DataTable\Simple();
        $this->addRow(array('visitLocalHour' => 1));
        $this->addRow(array('visitLocalHour' => 11));
        $this->addRow(array('visitLocalHour' => 12));
        $this->addRow(array('visitLocalHour' => 13));
    }

    /** @inheritdoc */
    public function tearDown()
    {
        // tear down here if needed
    }

    /**
     * @param $columns
     */
    private function addRow($columns)
    {
        $this->data->addRow($this->buildRow($columns));
    }

    /**
     * @param $columns
     * @return Row
     */
    private function buildRow($columns)
    {
        return new Row(array(Row::COLUMNS => $columns));
    }
}
