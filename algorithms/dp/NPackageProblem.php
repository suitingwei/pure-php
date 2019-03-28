<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019-03-27
 * Time: 22:45
 */

/**
 * Class NPackageProblem
 * 有n 个物品，它们有各自的重量和价值，现有给定容量的背包，如何让背包里装入的物品具有最大的重量
 */
class NPackageProblem
{
    /**
     * @param $nodes
     * @param $maxWeight
     * @param $packagesCount
     * @param $result
     * @param $tempResult
     */
    public function solveByRecursive($nodes, $maxWeight, $packagesCount, &$result, $tempResult)
    {

    }

    public function solve($nodes, $maxWeight, $packagesCount, $mode = 1)
    {
        $result = [];

        if ($mode == 1) {
            $this->solveByRecursive($nodes, $maxWeight, $packagesCount, $result, []);
        } else {
            $this->solveByDP($nodes, $maxWeight, $packagesCount, $result, []);
        }

        return $result;
    }

    private function solveByDP($nodes, $maxWeight, $packagesCount, array $result, array $array)
    {
    }
}

$packagesCount = 4;
$maxWeight     = 9;
$nodes         = [2, 3, 4, 1, 2];