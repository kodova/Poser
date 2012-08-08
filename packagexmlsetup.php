<?php
/**
 * Extra package.xml settings such as dependencies.
 * More information: http://pear.php.net/manual/en/pyrus.commands.make.php#pyrus.commands.make.packagexmlsetup
 */

$package->dependencies['required']->package['pear.symfony.com/ClassLoader']->save();
$package->dependencies['required']->package['pear.symfony.com/Config']->save();
$package->dependencies['required']->package['pear.symfony.com/DependencyInjection']->save();
$package->dependencies['required']->package['pear.symfony.com/Yaml']->save();
$package->dependencies['required']->package['hamcrest.googlecode.com/svn/pear/Hamcrest']->save();

unset($package->files['scripts/pyrus.phar']);
?>
