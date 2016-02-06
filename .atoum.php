<?php
//.atoum.php

use mageekguy\atoum;
use mageekguy\atoum\reports;

$coveralls = new reports\asynchronous\coveralls('./', '14CCADlaauzDLIsZurk9AUybvoNBN2VZ5');
$defaultFinder = $coveralls->getBranchFinder();
$coveralls
        ->setBranchFinder(function() use ($defaultFinder) {
                if (($branch = getenv('TRAVIS_BRANCH')) === false)
                {
                        $branch = $defaultFinder();
                }

                return $branch;
        })
        ->setServiceName(getenv('TRAVIS') ? 'travis-ci' : null)
        ->setServiceJobId(getenv('TRAVIS_JOB_ID') ?: null)
        ->addWriter()
;
$runner->addReport($coveralls);

$script->addDefaultReport();