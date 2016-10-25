<?php
/**
 * Created by PhpStorm.
 * User: yury
 * Date: 10/24/16
 * Time: 6:48 PM
 */

require_once '../vendor/autoload.php';

$mergeJob                = new \Hellosworldos\GitTools\Job();
$workspace               = new \Hellosworldos\GitTools\GitWorkspace();
$branchInfo              = new \Hellosworldos\GitTools\BranchInfo('master', 'uat', ['feature/100', 'bug/101']);
$streamFactory           = new \Hellosworldos\GitTools\StreamFactory();
$pipeOutputToFile        = new \Hellosworldos\GitTools\EventSubscriber\PipeOutputToFile();
$externalGitWrapper      = new \GitWrapper\GitWrapper();
$externalGitWrapper->setPrivateKey('/home/user/.ssh/id_rsa.pub');
$gitWrapper              = new \Hellosworldos\GitTools\GitWrapper\Cpliakas(
    $externalGitWrapper->cloneRepository('git@github.com:hellosworldos/git-tools.git'),
    $workspace,
    $streamFactory,
    $pipeOutputToFile
);

$mergeJob
    ->addTask(new \Hellosworldos\GitTools\Task\Type\Rebase($gitWrapper))
    ->addTask(new \Hellosworldos\GitTools\Task\Type\Merge($gitWrapper))
;

$mergeJob->run($branchInfo);