<?php

namespace partneritems\items;

use partneritems\Main;
use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\event\player\PlayerItemUseEvent;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\item\ItemFactory;

use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\effect\EffectInstance;
use pocketmine\item\ItemIds;
use pocketmine\item\Item;

use pocketmine\world\sound\AnvilFallSound;

use pocketmine\scheduler\ClosureTask;
use pocketmine\event\Listener;

use pocketmine\utils\TextFormat as TE;

/**INTERNAL STORAGE
/USE partneritems\Item;
**/

class SpecialItems implements Listener {
  
  public function __construct(Main $pg)

	{

		$this->plugin = $pg;
  }
  
   public $globalCooldown = [];
  
   public function onDamage(EntityDamageByEntityEvent $event){
        $damager = $event->getDamager();
        $entity = $event->getEntity();
        if($entity instanceof Player && $damager instanceof Player && $damager->getInventory()->getItemInHand()->getCustomName() === "§r§b§lInventory Clogger"){
         
            $entity->getInventory()->addItem(ItemFactory::getInstance()->get(270, 0, 36));
          //MESAGGES 
          
            $entity->sendMessage("§l§7[§6!§7] - §r§7Your inventory was clogged since someone used the 'Inventory Clogger' item against you.");
            $damager->sendMessage("§l§7[§6!§7] - §r§7You have clogged the inventory of §f$entity.");
            $e = $damager->getInventory()->getItemInHand();
            $damager->getInventory()->removeItem($e);
        }
        if($entity instanceof Player && $damager instanceof Player && $damager->getInventory()->getItemInHand()->getCustomName() === "§r§a§lMedusa Ability"){
          
                     $entity->setImmobile(true);
                     
                     $entity->sendMessage("\n§l§4❤ §r§c Oh no! You have been petrified by $damager wait 5 seconds to get back to normal \n");
				     
				               $this->plugin->getScheduler()->scheduleDelayedTask(new ClosureTask(function () use ($entity): void {
					           if ($entity->isOnline()) {
						            $entity->setImmobile(false);
						            $entity->sendMessage("\n§l§4❤️ §r§6You've returned to normal thanks to Apollo's spell\n");
					           }
					           }), 5 * 20);
					           
					       $e = $damager->getInventory()->getItemInHand();
                 $damager->getInventory()->removeItem($e);
        }
      }
    }