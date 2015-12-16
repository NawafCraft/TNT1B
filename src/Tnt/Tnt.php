<?php
namespace Tnt;
use pocketmine\utils\TextFormat;
use pocketmine\level\sound\AnvilUseSound;
use pocketmine\nbt\tag\Compound;
use pocketmine\entity\Entity;
use pocketmine\nbt\tag\Enum;
use pocketmine\nbt\tag\Double;
use pocketmine\plugin\PluginBase;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\utils\Random;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\nbt\tag\Float;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\protocol\UseItemPacket;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\nbt\tag\Byte;
class Tnt extends PluginBase implements Listener {
    public function onEnable() {
        $this->getLogger()->info(TextFormat::BLUE ."===============");
        $this->getLogger()->info(TextFormat::GREEN ."Have FUN");
        $this->getLogger()->info(TextFormat::BLUE ."===============");
            $this->getServer ()->getPluginManager ()->registerEvents ( $this, $this );
    }
            public function onPacketReceived(DataPacketReceiveEvent $event){
            $pk = $event->getPacket();
            $player = $event->getPlayer();
            if($pk instanceof UseItemPacket and $pk->face === 0xff) {
            $item = $player->getInventory()->getItemInHand();
            if($item->getId() == 369){
                $mot = (new Random())->nextSignedFloat() * M_PI * 2;
			$tnt = Entity::createEntity("PrimedTNT", $player->getLevel()->getChunk($player->x >> 4, $player->z >> 4), new Compound("", [
				"Pos" => new Enum("Pos", [
					new Double("", $player->x + 0.5),
					new Double("", $player->y),
					new Double("", $player->z + 0.5)
				]),
				"Motion" => new Enum("Motion", [
					new Double("", -sin($mot) * 0.02),
					new Double("", 0.2),
					new Double("", -cos($mot) * 0.02)
				]),
				"Rotation" => new Enum("Rotation", [
					new Float("", 0),
					new Float("", 0)
                                    
				]),
				"Fuse" => new Byte("Fuse", 100)
			]));
			$tnt->spawnToAll();
                        $player->getLevel()->addSound(new AnviluseSound($player),array($player));
			return true;
		}
            
        }
        
               
            }
            
    
          
        public function place(BlockPlaceEvent $place){
            $block = $place->getBlock();
            $player = $place->getPlayer();
         
            IF($block->getId()===46){
                $player->sendTIP("Plugin Nawaf1b");
                	$place->setCancelled();
			$mot = (new Random())->nextSignedFloat() * M_PI * 2;
			$tnt = Entity::createEntity("PrimedTNT", $block->getLevel()->getChunk($block->x >> 4, $block->z >> 4), new Compound("", [
				"Pos" => new Enum("Pos", [
					new Double("", $block->x + 0.5),
					new Double("", $block->y),
					new Double("", $block->z + 0.5)
				]),
				"Motion" => new Enum("Motion", [
					new Double("", -sin($mot) * 0.02),
					new Double("", 0.2),
					new Double("", -cos($mot) * 0.02)
				]),
				"Rotation" => new Enum("Rotation", [
					new Float("", 0),
					new Float("", 0)
                                    
				]),
				"Fuse" => new Byte("Fuse", 100)
			]));
			$tnt->spawnToAll();
                        $player->getLevel()->addSound(new AnviluseSound($player),array($player));
			return true;
		}
            
        }
        
      public function ExplosionPrimeEvent(ExplosionPrimeEvent $p){
          $p->setBlockBreaking(false);
      }
          public function onDamage(EntityDamageEvent $event){
            $player = $event->getEntity();
            $entity = $event->getEntity();
            
  
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
