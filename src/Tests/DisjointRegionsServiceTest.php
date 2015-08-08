<?php

namespace DisjointRegions\Tests;

use DisjointRegions\DisjointRegionsService;

/**
 * @group Unit
 */
class DisjointRegionsServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DisjointRegionsService
     */
    private $service;

    public function setup()
    {
        $this->service = new DisjointRegionsService();
    }

    public function test_it_returns_1_for_square_matrix_of_size_1()
    {
        $matrix = ["label"];

        $result = $this->service->getRegionCounts($matrix);

        $this->assertTrue(1 == $result["label"]);
    }

    public function test_it_computes_correct_number_of_regions_for_square_matrix_of_size_4_with_2_labels()
    {
        // Task's specification test case no. 1
        $matrix = [
            [1,1,0,1],
            [1,0,0,1],
            [0,1,0,0],
            [0,0,0,0]
        ];

        $result = $this->service->getRegionCounts($matrix);

        $this->assertTrue(3 == $result[1]);
        $this->assertTrue(1 == $result[0]);

        // Task's specification test case no. 2
        $matrix = [
            [1,0,0,1],
            [1,0,1,1],
            [1,0,0,1],
            [1,1,0,0]
        ];

        $result = $this->service->getRegionCounts($matrix);

        $this->assertTrue(2 == $result[1]);
        $this->assertTrue(1 == $result[0]);

        // Task's specification test case no. 3
        $matrix = [
            [1,0,0,1],
            [1,0,0,1],
            [1,0,0,1],
            [1,1,1,1],
        ];

        $result = $this->service->getRegionCounts($matrix);

        $this->assertTrue(1 == $result[1]);
        $this->assertTrue(1 == $result[0]);
    }

    public function test_it_computes_correct_number_of_regions_for_not_square_matrix_of_size_12x11_with_4_labels()
    {
        $matrix = [
            ["Ali","Dan","Bob","Bob","Ali","Ali","Ali","Tom","Tom","Dan","Bob"],
            ["Ali","Dan","Dan","Bob","Dan","Dan","Ali","Dan","Dan","Dan","Dan"],
            ["Ali","Dan","Bob","Bob","Ali","Dan","Ali","Ali","Ali","Ali","Ali"],
            ["Ali","Ali","Ali","Bob","Ali","Bob","Bob","Ali","Dan","Dan","Ali"],
            ["Ali","Bob","Ali","Ali","Ali","Dan","Dan","Bob","Dan","Dan","Dan"],
            ["Dan","Dan","Dan","Bob","Dan","Dan","Tom","Tom","Dan","Dan","Ali"],
            ["Ali","Tom","Dan","Bob","Dan","Tom","Tom","Bob","Ali","Ali","Ali"],
            ["Tom","Tom","Dan","Bob","Dan","Tom","Tom","Tom","Dan","Dan","Dan"],
            ["Dan","Dan","Dan","Bob","Dan","Dan","Ali","Ali","Dan","Dan","Bob"],
            ["Ali","Dan","Dan","Bob","Dan","Dan","Ali","Dan","Dan","Dan","Dan"],
            ["Ali","Dan","Bob","Bob","Ali","Dan","Ali","Ali","Ali","Dan","Tom"],
            ["Ali","Dan","Bob","Bob","Ali","Dan","Ali","Ali","Ali","Dan","Dan"],
        ];

        $result = $this->service->getRegionCounts($matrix);

        $this->assertTrue(5 == $result["Ali"]);
        $this->assertTrue(8 == $result["Bob"]);
        $this->assertTrue(6 == $result["Dan"]);
        $this->assertTrue(4 == $result["Tom"]);
    }
}