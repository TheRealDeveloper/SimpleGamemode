<?php

namespace trd\sgm;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\GameMode;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;

class Main extends PluginBase{

    public $px;
    public $c;

    protected function onEnable(): void{
        $this->saveResource("config.yml");
        $this->c = new Config($this->getDataFolder()."config.yml",2);
        $this->px = $this->c->get("prefix");
    }
    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{

        //--Command--//
        if($command->getName() == "gm"){
            //--SELF--//
            if(isset($args[0])){
                if(!isset($args[1])){
                    if($args[0] == "0" || "1" || "2" || "3"){
                        $msg = str_replace("{NEW}", $args[0], $this->c->get("switch.gamemode"));
                        $sender->sendMessage($this->px . $msg);
                            $sender->setGamemode(GameMode::fromString($args[0]));
                    }else{
                        $sender->sendMessage($this->px. $this->c->get("unknown.gamemode"));
                    }
                }else {
                    if ($sender->hasPermission("gamemode.command.others")) {
                        if ($args[0] == "0" || "1" || "2" || "3") {
                            $target = $this->getServer()->getPlayerByPrefix($args[1]);
                            if ($target instanceof Player) {
                                $msgr = str_replace("{NAME}", $sender->getName(), $this->c->get("switch.message.other"));
                                $msg = str_replace("{NEW}", $args[0], $msgr);
                                $target->sendMessage($this->px . $msg);
                                $target->setGamemode(GameMode::fromString($args[0]));
                                $pmsgr = str_replace("{TARGET}", $target->getName(), $this->c->get("you.set.other"));
                                $pmsg = str_replace("{NEW}", $args[0], $pmsgr);
                                $sender->sendMessage($this->px . $pmsg);
                            } else {
                                $sender->sendMessage($this->px . $this->c->get("unknown.gamemode"));
                            }
                        } else {
                            $sender->sendMessage($this->c->get("unknown.gamemode"));
                        }
                    } else {
                        $sender->sendMessage($this->px. $this->c->get("no.perms.others"));
                    }
                }
            }
        }
        return true;
    }
}