<?php
namespace DisjointRegions\Tests;

/**
 * Provider of test data
 */
class MatrixProvider
{
    /**
     * @var array Test matrixes (first 3 are taken from the description of the
     * exercise)
     */
    private $matrixes;

    public function __construct()
    {
        $this->matrixes = array();

        $this->matrixes[1] = self::createTestMatrix1();
        $this->matrixes[2] = self::createTestMatrix2();
        $this->matrixes[3] = self::createTestMatrix3();
        $this->matrixes[4] = self::createTestMatrix4();
    }

    /**
     * @return array
     */
    private static function createTestMatrix1()
    {
        $matrix = array(
            array(1,1,0,1),
            array(1,0,0,1),
            array(0,1,0,0),
            array(0,0,0,0),
        );

        return $matrix;
    }

    /**
     * @return array
     */
    private static function createTestMatrix2()
    {
        $matrix = array(
            array(1,0,0,1),
            array(1,0,1,1),
            array(1,0,0,1),
            array(1,1,0,0),
        );

        return $matrix;
    }

    /**
     * @return array
     */
    private static function createTestMatrix3()
    {
        $matrix = array(
            array(1,0,0,1),
            array(1,0,0,1),
            array(1,0,0,1),
            array(1,1,1,1),
        );

        return $matrix;
    }

    /**
     * A more complicated matrix :)
     *
     * @return array
     */
    private static function createTestMatrix4()
    {
        $matrix = array(
            array("Ali","Dan","Bob","Bob","Ali","Ali","Ali","Tom","Tom","Dan","Bob"),
            array("Ali","Dan","Dan","Bob","Dan","Dan","Ali","Dan","Dan","Dan","Dan"),
            array("Ali","Dan","Bob","Bob","Ali","Dan","Ali","Ali","Ali","Ali","Ali"),
            array("Ali","Ali","Ali","Bob","Ali","Bob","Bob","Ali","Dan","Dan","Ali"),
            array("Ali","Bob","Ali","Ali","Ali","Dan","Dan","Bob","Dan","Dan","Dan"),
            array("Dan","Dan","Dan","Bob","Dan","Dan","Tom","Tom","Dan","Dan","Ali"),
            array("Ali","Tom","Dan","Bob","Dan","Tom","Tom","Bob","Ali","Ali","Ali"),
            array("Tom","Tom","Dan","Bob","Dan","Tom","Tom","Tom","Dan","Dan","Dan"),
            array("Dan","Dan","Dan","Bob","Dan","Dan","Ali","Ali","Dan","Dan","Bob"),
            array("Ali","Dan","Dan","Bob","Dan","Dan","Ali","Dan","Dan","Dan","Dan"),
            array("Ali","Dan","Bob","Bob","Ali","Dan","Ali","Ali","Ali","Dan","Tom"),
            array("Ali","Dan","Bob","Bob","Ali","Dan","Ali","Ali","Ali","Dan","Dan"),
        );

        return $matrix;
    }

    /**
     * Fetch all test matrixes
     *
     * @return array
     */
    public function fetchAll()
    {
        return $this->matrixes;
    }

    /**
     * Transform a matrix to a human-readable string
     *
     * @param array $matrix
     * @return string
     */
    public function matrixToString(array $matrix)
    {
        $string = "";

        foreach ($matrix as $row) {
            $string .= "\t( ";

            foreach ($row as $col) {
                $string .= $col . ' ';
            }

            $string .= ")\n";
        }

        return $string;
    }
}