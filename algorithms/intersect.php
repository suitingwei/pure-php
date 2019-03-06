<?php

class Solution
{

    /**
     * @param Integer[] $nums1
     * @param Integer[] $nums2
     * @return Integer[]
     */
    static function intersect($nums1, $nums2)
    {

        $result = [];
        $i      = $j = 0;

        sort($nums1);
        sort($nums2);

        $length1 = count($nums1);
        $length2 = count($nums2);


        while (($i < $length1) && ($j < $length2)) {

            if ($nums1[$i] == $nums2[$j]) {
                $result[] = $nums1[$i];
                $i++;
                $j++;
            } else if ($nums1[$i] < $nums2[$j]) {
                $i++;
            } else {
                $j++;
            }
        }
        return $result;

    }
}


$arr1 = [1,2,2,1];
$arr2 = [2,2];
print_r(Solution::intersect($arr1,$arr2));
