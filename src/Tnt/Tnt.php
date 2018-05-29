<?php
namespace Tnt;

use pocketmine\utils\TextFormat;
use pocketmine\level\sound\AnvilUseSound;
use pocketmine\entity\Entity;
use pocketmine\plugin\PluginBase;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\utils\Random;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\math\Vector3;

class Tnt extends PluginBase implements Listener {
    
    public function onEnable() {
        $this->getLogger()->info(TextFormat::BLUE ."===============");
        $this->getLogger()->info(TextFormat::GREEN ."Have FUN Plugin BY Nawaf_Craft1b");
        $this->getLogger()->info(TextFormat::BLUE ."===============");
        $this->getServer ()->getPluginManager ()->registerEvents ( $this, $this );
    }
                      
        public function place(BlockPlaceEvent $place){
            $block = $place->getBlock();
            $player = $place->getPlayer();
         
            IF($block->getId()===46){
               
                $place->setCancelled();
	        $mot = (new Random())->nextSignedFloat() * M_PI * 2;
		$nbt = Entity::createBaseNBT($block, new Vector3(-sin($mot) * 0.02, 0.2, -cos($mot) * 0.02));
		$nbt->setShort("Fuse", 90);

		$tnt = Entity::createEntity("PrimedTNT", $block->getLevel(), $nbt);
		$tnt->spawnToAll();
                
                        $player->getLevel()->addSound(new AnvilUseSound($player));
			return true;
		}
            
        }
        
      public function ExplosionPrimeEvent(ExplosionPrimeEvent $p){
          $p->setBlockBreaking(false);
      }
          public function onDamage(EntityDamageEvent $event){
            $player = $event->getEntity();
            
  
         if($player instanceof Player && $event->getCause() === EntityDamageEvent::CAUSE_ENTITY_EXPLOSION){
         switch(mt_rand(1,2)){
            case 1:
            $event->setDamage(10);
            break;
            case 2:
             $event->setDamage(8);	
             break;
         }
        }
    }
}
