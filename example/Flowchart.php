<?php 

class Flowchart extends OutputWriter{
	
	const BACON_TO_EAT = 8;
	const BACON_TO_STOCK = 30;

	/**
	 * @var House
	 */
	private $house;
	
	/**
	 * @var Person
	 */
	private $person;
	
	/**
	 * @var Dog
	 */
	private $dog;

	
	public  function __construct(House $house, Person $person, Dog $dog){
		$this->house = $house;
		$this->person = $person;
		$this->dog = $dog;
	}
	
	public function run(){
		if($this->person->isHungry()){
			$this->person->write("Im hungry");
			$this->whatToEat();
			$this->haveBacon();	
			$this->cleanCooker();
			$this->wearingPants();
			$this->cookBacon();
			$this->giveToDog();
			$this->consumBacon();
		}else{
			return;
		}
	}
	
	
	public function whatToEat(){
		$this->person->write("What should I eat?");
        $wantsBacon = $this->person->wantsBacon();
        $this->person->write(($wantsBacon) ? "How about bacon?" : "How about chicken");
		if (!$wantsBacon){
			$this->write("No, You want bacon.");
			$this->person->write("You're right I want bacon");
		}
		$this->person->write("I love bacon");
	}
	
	public function haveBacon(){
		$this->person->write("Do I have any bacon?");
		if($this->house->baconInStock(self::BACON_TO_EAT)){
			$this->write('Good! A home is not complete without bacon!');
			return;
		}
			
		$this->write('What? Why not?');
		$this->person->write("Already ate it");
		$this->write("Get some more bacon");
		
		$bacon = array();
		for($i = 0; $i < self::BACON_TO_STOCK; $i++){
			$bacon[] = new HickoryBacon();
		}
		
		$this->house->stockRawBacon($bacon);
	}
	
	public function cleanCooker(){
		$this->person->write("Do i have a clean frying pan?");
		$cooker = $this->house->getCooker();
		if($cooker->isClean()){
			$this->write("Hooray!");
		} else{
			$this->write("Dammit, if it's not one thing...");
			$this->person->cleanCooker($cooker);
		}
		$this->write("Let's make some bacon!");
	}
	
	public function wearingPants(){
		$this->write("Are you wearing pants?");
		if(!$this->person->wearingPants()){
			$this->person->write("Why should I be wearing pants? I HATE pants");
			$this->write("You also hate getting hot bacon grease on your junk");
			$this->person->write("Good Point. Pants are on just this once. Bug once the bacon's done, all pants are off!");
			$this->person->putPantsOn("blue");
		}
		$this->write("We're ready!");
	}
	
	public function cookBacon(){
		$this->person->write('Do I want my bacon crispy?');
		$cooker = $this->house->getCooker();
		$bacon = $this->house->getRawBacon(self::BACON_TO_EAT);
		switch ($this->person->likesCrispyBacon()) {
			case Person::YES:
				$this->write("Sometimes you just want it to be a little chewy. Today is one of those days");
				$cooker->cook(false, $bacon);
				break;
			case Person::NO:
				$this->person->write("I really like my bacon crispy, but I fear it can get burnt to easily");
				$this->write("That's a risk we all take. the price of great bacon is eternal vigilance");
				$cooker->cook(true, $bacon);
				break;
			case Person::MAYBE:
				$this->person->write("Decisions! How about I make some crispy, and some not so crispy?");
				$this->write("Good thinking! Variety is the spice of life, after all...");
				$half = round(sizeof($bacon) / 2);
				$cooker->cook(true, array_slice($bacon, 0, $half - 1));
				$cooker->cook(false, array_slice($bacon, $half));
				break;
		}
		$this->write("Bacon is done");
	}
	
	public function giveToDog(){
		$this->person->write(sprintf("Should I give some to %s?", $this->dog->getName()));
		$giveToDog = $this->person->giveSomeToDog();
		if($giveToDog == Person::NO){
			$this->write("Withholding bacon from a dog is inhumane. How dare you even think it?");
		}elseif ($giveToDog == Person::MAYBE){
			$this->person->write("I'll see if he'll chose bacon over beggin strips");
			if($this->person->disownDog($this->dog->wantsBacon())){
				throw new Exception("You should never disown your dog, you are a bad owner", 1);	
			}else{
				$this->write("He's just letting me have the bacon. I'll reward his kindness with bacon");
			}
		}
			
		$this->write(sprintf("%s is wise, and also loves bacon", $this->dog->getName()));
	}
	
	
	public function consumBacon(){
		$this->person->write("Mmmmm... bacon");
		$this->person->write("Now what?");
		$this->write("You've just eaten bacon. What more could you want?");
		$this->person->write("You're right. I have no other earthly concerns.");
		$this->person->write("I have reached enlightment. Thank you, bacon!");
		$this->write("Hooray for bacon!");
	}
	
	public function getName(){
		return "Flowchart";	
	}
	
	
}