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

    public function test_it_returns_1_for_label_in_square_matrix_of_size_1()
    {
        $matrix = ["label"];
        $result = $this->service->getRegionCounts($matrix);

        $this->assertTrue(1 == $result["label"]);
    }

    public function test_it_computes_correct_number_of_regions_for_1x2_matrix()
    {
        /*
         * Test case: 1 label
         */
        $matrix = [1, 1];
        $result = $this->service->getRegionCounts($matrix);

        $this->assertTrue(1 == $result[1]);

        /*
         * Test case: 2 labels
         */
        $matrix = [1, 0];
        $result = $this->service->getRegionCounts($matrix);

        $this->assertTrue(1 == $result[1]);
        $this->assertTrue(1 == $result[0]);
    }

    public function test_it_computes_correct_number_of_regions_for_1xM_matrix()
    {
        /*
         * Test case: 2 labels
         */
        $matrix = [0, 1, 1, 0, 1, 1, 1, 0, 0, 0, 0, 1, 0, 0];
        $result = $this->service->getRegionCounts($matrix);

        $this->assertTrue(3 == $result[1]);
        $this->assertTrue(4 == $result[0]);

        /*
         * Test case: 3 labels
         */
        $matrix = [2, 1, 1, 0, 1, 1, 2, 2, 0, 0, 0, 1, 0, 1, 1, 2, 0];
        $result = $this->service->getRegionCounts($matrix);

        $this->assertTrue(3 == $result[2]);
        $this->assertTrue(4 == $result[1]);
        $this->assertTrue(4 == $result[0]);
    }

    public function test_it_computes_correct_number_of_regions_for_square_matrix_of_size_2()
    {
        /*
         * Test case: 1 label
         */
        $matrix = [
            ['A', 'A'],
            ['A', 'A']
        ];

        $result = $this->service->getRegionCounts($matrix);

        $this->assertTrue(1 == $result['A']);

        /*
         * Test case: 2 labels
         */
        $matrix = [
            ['A', 'A'],
            ['A', 'B']
        ];

        $result = $this->service->getRegionCounts($matrix);

        $this->assertTrue(1 == $result['A']);
        $this->assertTrue(1 == $result['B']);

//        $matrix = [
//            ['A', 'B'],
//            ['B', 'A']
//        ];
//
//        $result = $this->service->getRegionCounts($matrix);
//
//        $this->assertTrue(2 == $result['A']);
//        $this->assertTrue(2 == $result['B']);

        /*
         * Test case: 3 labels
         */
        $matrix = [
            ['A', 'B'],
            ['C', 'B']
        ];

        $result = $this->service->getRegionCounts($matrix);

        $this->assertTrue(1 == $result['A']);
        $this->assertTrue(1 == $result['B']);
        $this->assertTrue(1 == $result['C']);

        $matrix = [
            ['A', 'B'],
            ['C', 'C']
        ];

        $result = $this->service->getRegionCounts($matrix);

        $this->assertTrue(1 == $result['A']);
        $this->assertTrue(1 == $result['B']);
        $this->assertTrue(1 == $result['C']);

        /*
         * Test case: 4 labels
         */
        $matrix = [
            ['A', 'B'],
            ['C', 'D']
        ];

        $result = $this->service->getRegionCounts($matrix);

        $this->assertTrue(1 == $result['A']);
        $this->assertTrue(1 == $result['B']);
        $this->assertTrue(1 == $result['C']);
        $this->assertTrue(1 == $result['D']);
    }

    public function test_it_computes_correct_number_of_regions_for_square_matrix_of_size_4_with_2_labels()
    {
        /*
         * Task's specification test case no. 1
         */
        $matrix = [
            [1,1,0,1],
            [1,0,0,1],
            [0,1,0,0],
            [0,0,0,0]
        ];

        $result = $this->service->getRegionCounts($matrix);

        $this->assertTrue(3 == $result[1]);
        $this->assertTrue(1 == $result[0]);

        /*
         * Task's specification test case no. 2
         */
        $matrix = [
            [1,0,0,1],
            [1,0,1,1],
            [1,0,0,1],
            [1,1,0,0]
        ];

        $result = $this->service->getRegionCounts($matrix);

        $this->assertTrue(2 == $result[1]);
        $this->assertTrue(1 == $result[0]);

        /*
         * Task's specification test case no. 3
         */
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