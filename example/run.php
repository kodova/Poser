<?php 

require_once 'Bacon.php';
require_once 'Cooker.php';
require_once 'Dog.php';
require_once 'OutputWriter.php';
require_once 'Flowchart.php';
require_once 'HickoryBacon.php';
require_once 'House.php';
require_once 'Pan.php';
require_once 'Person.php';
require_once 'Labrador.php';

$baconTotal = rand(0, 12);
$bacon = array();
for($i =  0; $i < $baconTotal; $i++){
	$bacon[] = new HickoryBacon();
}

$dog = new Labrador();
$cooker = new Pan();
$house = new House($cooker, $bacon);
$person = new Person("Duff Mann");
$flowsheet = new Flowchart($house, $person, $dog);

$flowsheet->run();
