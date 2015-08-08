<?php

namespace DisjointRegions\Service;

use DisjointRegions\Model\RegionFinder;

/**
 * Calculate the number of disjoint regions in a matrix
 */
class DisjointRegions
{
    /**
     * @var RegionFinder
     */
    private $regionFinder;

    public function __construct()
    {
        $this->regionFinder = new RegionFinder();
    }

    /**
     * @param array $matrix
     * @return array  Region counts by label
     */
    public function getRegionCounts($matrix)
    {
        $regionsByLabel =  $this->regionFinder->computeRegions($matrix);
        $regionCounts = [];

        foreach ($regionsByLabel as $label => $regions) {
            $regionCounts[$label] = count(array_unique($regions));
        }

        return $regionCounts;
    }
}