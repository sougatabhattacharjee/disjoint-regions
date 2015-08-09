<?php

namespace DisjointRegions;

/**
 * Calculate disjoint regions in a matrix
 */
class DisjointRegionsService
{
    /**
     * @var array Region matrix
     */
    private $matrix;

    /**
     * @var array Region map
     */
    private $regionsByLabel;

    /**
     * @param array $matrix
     * @return array  Region counts by label
     */
    public function getRegionCounts($matrix)
    {
        // If we're dealing with a 1-dimensional array, we turn it into a 2-dimensional one
        if (!is_array($matrix[0])) {
            $matrix = [$matrix];
        }

        $regionsByLabel =  $this->computeRegions($matrix);
        $regionCounts = [];

        foreach ($regionsByLabel as $label => $regions) {
            $regionCounts[$label] = count(array_unique($regions));
        }

        return $regionCounts;
    }

    /**
     * Create the "region map" --- a set of elements of the form
     * (label, index, number), where:
     *
     * label  --- label that originally marked this area in the data matrix (like 0,1,..),
     * index  --- unique id of a record from the data matrix,
     * number --- maximum id among the elements belonging to this area.
     *
     * @param array $matrix
     * @return array
     */
    public function computeRegions($matrix)
    {
        $this->matrix = $matrix;
        $matrixHeight = count($this->matrix);
        $matrixLength = count($this->matrix[0]);
        $this->regionsByLabel = array();

        $this->initRegionMap($matrixHeight, $matrixLength);

        /*
         * Now, find the relationships between the matrix elements
         */

        // Start from the bottom-right corner of the matrix
        for ($i = $matrixHeight - 1 ; 0 <= $i; --$i) {
            for ($j = $matrixLength - 1; 0 <= $j; --$j) {

                // Current element's coordinates
                $currentRow = $i;
                $currentCol = $j;

                $rightNeighbourExists = $currentCol + 1 < $matrixLength;
                $southNeighbourExists = $currentRow + 1 < $matrixHeight;

                // Compare the current element with its right neighbour
                if ($rightNeighbourExists) {
                    // Right neighbour's coordinates
                    $rightNeighbourRow = $currentRow;
                    $rightNeighbourCol = $currentCol + 1;

                    $this->compareWithNeighbour($currentRow, $currentCol,
                        $rightNeighbourRow, $rightNeighbourCol
                    );
                }

                // Compare the current element with its southern neighbour
                if ($southNeighbourExists) {
                    // Southern neighbour's coordinates
                    $southNeighbourRow = $currentRow + 1;
                    $southNeighbourCol = $currentCol;

                    $this->compareWithNeighbour($currentRow, $currentCol,
                        $southNeighbourRow, $southNeighbourCol
                    );
                }

                // Compare the neighbours
                if ($rightNeighbourExists && $southNeighbourExists) {
                    // If both neighbours exist, compare them as well and
                    // update, if needed
                    $this->compareWithNeighbour($rightNeighbourRow, $rightNeighbourCol,
                        $southNeighbourRow, $southNeighbourCol
                    );
                }
            }
        }

        $this->matrix = null;

        return $this->regionsByLabel;
    }

    /**
     * Create a start region for each element of the matrix:
     * for each element we will store only the maximum id among the elements
     * belonging to this region --- at the start all regions are single-element
     * regions
     *
     * @param int $matrixHeight
     * @param int $matrixLength
     */
    private function initRegionMap($matrixHeight, $matrixLength)
    {
        for ($i=0; $i < $matrixHeight; ++$i) {
            for ($j=0; $j < $matrixLength; ++$j) {
                // Current matrix record
                $current = $this->matrix[$i][$j];
                // Create a unique id for this record
                $currentId = $this->getRecordId($i, $j);
                // Then add it to the array of regions

                if (!array_key_exists($current, $this->regionsByLabel)) {
                    // This way we will be able to count all kinds of regions,
                    // not only those labeled with 1
                    $this->regionsByLabel[$current] = array();
                }

                $this->updateRegionMap($current, $currentId, $currentId);
            }
        }
    }

    /**
     * Calculate a unique id for a matrix record (i,j)
     *
     * @param int $i  Record row
     * @param int $j  Record column
     * @return int    Computed id
     */
    private function getRecordId($i, $j)
    {
        return $i * 10 + $j;
    }

    /**
     * Update the entry in the region map for a particular record
     *
     * @param mixed $value         Record's value in the matrix
     * @param int   $id            Unique id of the record
     * @param int   $maxElementId  Maximum value of the unique ids among the
     * elements that belong to this region
     */
    private function updateRegionMap($value, $id, $maxElementId)
    {
        $this->regionsByLabel[$value][$id] = $maxElementId;
    }

    /**
     * Compare a matrix record with its neighbour and update the regions array
     * afterward
     *
     * @param int $currentRow    Row of the current element
     * @param int $currentCol    Column of the current element
     * @param int $neighbourRow  Row of the neighbour
     * @param int $neighbourCol  Column of the neighbour
     */
    private function compareWithNeighbour(
        $currentRow, $currentCol, $neighbourRow, $neighbourCol
    ){
        $current = $this->matrix[$currentRow][$currentCol];
        $neighbour = $this->matrix[$neighbourRow][$neighbourCol];

        if ($current == $neighbour) {
            // If they are labeled with the same value, they belong to
            // the same region

            $currentId = $this->getRecordId($currentRow, $currentCol);
            $neighbourId = $this->getRecordId($neighbourRow, $neighbourCol);

            $currentMax = $this->regionsByLabel[$current][$currentId];
            $neighbourMax = $this->regionsByLabel[$current][$neighbourId];

            // Element in the region with the biggest index
            $max = max($currentMax, $neighbourMax);
            // Mark both elements as being in the same region
            $this->updateRegionMap($current, $currentId, $max);
            $this->updateRegionMap($current, $neighbourId, $max);
        }
    }
}