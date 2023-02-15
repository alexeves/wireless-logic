<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude('var')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false],
        'php_unit_method_casing' => ['case' => 'snake_case'],
        'phpdoc_separation' => ['groups' => [['*']]],
        'phpdoc_align' => ['align' => 'left'],
        'increment_style' => ['style' => 'post'],
    ])
    ->setFinder($finder)
;
