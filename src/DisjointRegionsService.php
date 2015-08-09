<?php

namespace DisjointRegions;

/**
 * Calculate disjoint regions in a matrix
 */
class DisjointRegionsService
{
    /**
     * @var array Labeled matrix
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
        if (!is_array($matrix[0])) {
            /*
             * If we're dealing with a 1-dimensional array, we turn it into
             * a 2-dimensional one
             */
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
        $this->regionsByLabel = [];

        $matrixHeight = count($this->matrix);
        $matrixLength = count($this->matrix[0]);

        // Start from the bottom-right corner of the matrix
        for ($row = $matrixHeight - 1 ; 0 <= $row; --$row) {
            for ($col = $matrixLength - 1; 0 <= $col; --$col) {

                $label = $this->matrix[$row][$col];
                $currentRecordId = $this->getRecordId($row, $col);
                /*
                 * Init the region for the current record with the unique id of this record
                 */
                $this->updateRegionMap($label, $currentRecordId, $currentRecordId);

                $southNeighbourExists = $row + 1 < $matrixHeight;
                $rightNeighbourExists = $col + 1 < $matrixLength;

                /*
                 * Compare the current element with its southern neighbour
                 */
                $southUpdated = false;

                if ($southNeighbourExists) {
                    $southRow = $row + 1;
                    $southCol = $col;
                    $southUpdated = $this->updateRegionsForNeighbouringRecords($row, $col, $southRow, $southCol);
                }
                /*
                 * Compare the current element with its right neighbour
                 */
                $rightUpdated = false;

                if ($rightNeighbourExists) {
                    $rightRow = $row;
                    $rightCol = $col + 1;
                    $rightUpdated = $this->updateRegionsForNeighbouringRecords($row, $col, $rightRow, $rightCol);
                }
                /*
                 * Compare the southern and the right neighbour, if both have been updated
                 */
                if ($southUpdated && $rightUpdated) {
                    $this->updateRegionsForNeighbouringRecords($southRow, $southCol, $rightRow, $rightCol);
                }
            }
        }

        return $this->regionsByLabel;
    }

    /**
     * Calculate a unique id for a matrix record (row, column)
     *
     * @param int $row     Record row
     * @param int $column  Record column
     * @return int  Computed id
     */
    private function getRecordId($row, $column)
    {
        $matrixLength = count($this->matrix[0]);

        return $row * $matrixLength + $column;
    }

    /**
     * Update the entry in the region map for a particular matrix record
     *
     * @param mixed $label   Record's value in the original matrix
     * @param int   $id      Record's unique id
     * @param int   $region  Maximum id of the records that belong to the same region as this record
     */
    private function updateRegionMap($label, $id, $region)
    {
        $this->regionsByLabel[$label][$id] = $region;
    }

    /**
     * Compare the specified records' labels
     * and update their regions if they belong to the same one
     *
     * @param int $row
     * @param int $col
     * @param int $neighbourRow
     * @param int $neighbourCol
     * @return bool  Whether the records had their regions updated
     */
    private function updateRegionsForNeighbouringRecords(
        $row, $col, $neighbourRow, $neighbourCol
    ) {
        $label = $this->matrix[$row][$col];
        $neighbourLabel = $this->matrix[$neighbourRow][$neighbourCol];

        if ($label == $neighbourLabel) {
            $id = $this->getRecordId($row, $col);
            $region = $this->regionsByLabel[$label][$id];

            $neighbourId = $this->getRecordId($neighbourRow, $neighbourCol);
            $neighbourRegion = $this->regionsByLabel[$label][$neighbourId];

            $region = max($region, $neighbourRegion);

            $this->updateRegionMap($label, $id, $region);
            $this->updateRegionMap($label, $neighbourId, $region);

            // Regions updated
            return true;
        }

        // Nothing updated
        return false;
    }
}