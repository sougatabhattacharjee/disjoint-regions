#!/usr/bin/php -q
<?php
namespace DisjointRegions;

use DisjointRegions\Model\RegionFinder;
use DisjointRegions\Tests\MatrixProvider;

require_once 'config/loader.php';

/**
 * Run this script
 */
function run()
{
    $matrixProvider = new MatrixProvider();

    /**
     * Simple tests to see that it works
     */

    foreach ($matrixProvider->fetchAll() as $testCase => $matrix) {

        $regionFinder = new RegionFinder($matrix);
        $regionMap = $regionFinder->computeRegions();
        $regionLabels = array_keys($regionMap);

        sort($regionLabels);

        echo sprintf("TEST CASE number %d \n", $testCase);
        echo sprintf("Matrix [%d x %d]: \n", count($matrix), count($matrix[0]));

        echo $matrixProvider->matrixToString($matrix);

        echo sprintf("\nElement's of this matrix are labeled with %d values: %s \n",
            count($regionMap), join(', ', $regionLabels)
        );

        foreach ($regionLabels as $label) {
            $uniqueNumbers = array_unique($regionMap[$label]);

            echo sprintf("\tNumber of disjoint regions labeled with %s:  %d \n",
                $label, count($uniqueNumbers)
            );
        }

        echo "\n";
    }
}

// Execute run
run();
