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

    public $c;
    public $p;

    protected function onEnable(): void{
        $this->saveResource("config.yml");
        $this->c = new Config($this->getDataFolder()."config.yml", 2);
        $this->p = $this->c->get("prefix");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool{
        if ($command->getName() == "gm"){
            if(isset($args[0])){
                if($args[0] <= 3) {
                if ($args[0] >= 0) {
                    if (is_numeric($args[0])) {
                        if (!isset($args[1])) {
                            $sender->sendMessage($this->p . $this->c->get("changed.yourself"));
                            $sender->setGamemode(GameMode::fromString($args[0]));
                        } else {
                            if ($sender->hasPermission("sgm.command.others")) {
                                $target = $this->getServer()->getPlayerByPrefix($args[1]);
                                if ($target instanceof Player) {
                                    $msgt = str_replace("{SENDER}", $sender->getName(), $this->c->get("target.msg.changed"));
                                    $target->sendMessage($this->p . $msgt);
                                    $target->setGamemode(GameMode::fromString($args[0]));
                                    $msgs = str_replace("{TARGET}", $target->getName(), $this->c->get("sender.msg.changed.others"));
                                    $sender->sendMessage($this->p . $msgs);
                                } else {
                                    $sender->sendMessage($this->p . $this->c->get("unknown.player"));
                                }
                            } else {
                                $sender->sendMessage($this->p . $this->c->get("no.perms.others"));
                            }
                        }
                    }else{
                        $sender->sendMessage($this->p . $this->c->get("select.gamemode"));

                    }
                }else{
                    $sender->sendMessage($this->p . $this->c->get("select.gamemode"));

                }
                }else{
                    $sender->sendMessage($this->p . $this->c->get("select.gamemode"));

                }
            }else{
                $sender->sendMessage($this->p.$this->c->get("select.gamemode"));
            }
        }
        return true;
    }
}