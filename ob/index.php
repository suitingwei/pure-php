<?php
/**
 * Created by PhpStorm.
 * User: sui
 * Date: 2019/1/15
 * Time: 14:54
 */

$title        = "标题";
$paragraphOne = "第一篇文章";
$paragraphTwo = "第2篇文章";

ob_start();
include __DIR__ . '/view.php';

$content = ob_get_clean();

echo $content;

