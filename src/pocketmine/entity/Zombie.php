<?php
namespace pocketmine\entity;


use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\item\Item as drp;
use pocketmine\Player;

class Zombie extends Monster{
	const NETWORK_ID = 32;

	public $width = 1.031;
	public $length = 0.891;
	public $height = 2;
	
	protected $exp_min = 5;
	protected $exp_max = 5;

	public function initEntity(){
		$this->setMaxHealth(20);
		parent::initEntity();
	}

	public function getName(){
		return "Zombie";
	}

	public function spawnTo(Player $player){
		$pk = $this->addEntityDataPacket($player);
		$pk->type = Zombie::NETWORK_ID;

		$player->dataPacket($pk);
		parent::spawnTo($player);
	}

	public function getDrops(){
		$drops = [
			drp::get(drp::ROTTEN_FLESH, 0, 1)
		];
		if($this->lastDamageCause instanceof EntityDamageByEntityEvent and $this->lastDamageCause->getEntity() instanceof Player){
			if(mt_rand(0, 199) < 5){
				switch(mt_rand(0, 2)){
					case 0:
						$drops[] = drp::get(drp::IRON_INGOT, 0, 1);
						break;
					case 1:
						$drops[] = drp::get(drp::CARROT, 0, 1);
						break;
					case 2:
						$drops[] = drp::get(drp::POTATO, 0, 1);
						break;
				}
			}
		}

		if($this->lastDamageCause instanceof EntityDamageByEntityEvent and $this->lastDamageCause->getEntity() instanceof ChargedCreeper){
			$drops = [
				drp::get(drp::SKULL, 2, 1)
			];
		}

		return $drops;
	}
}
