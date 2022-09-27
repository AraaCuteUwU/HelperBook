<?php

namespace FiraAja\HelperBook;

use cooldogedev\libBook\LibBook;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase {
    /* @var Config $config */
    private Config $config;

    public function onEnable(): void
    {
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML, array());
    }

    public function onCommand(CommandSender $player, Command $cmd, String $label, Array $args): bool {
        if($cmd->getName() == "helper"){
            if(!$player instanceof Player) return false;
            $item = VanillaItems::WRITTEN_BOOK();
            $item->setTitle($this->config->get("title"));
            $item->setAuthor($this->config->get("author"));
            for($i = 0; $i <= $this->config->get("max-pages"); $i++){
                $item->setPageText($i, str_replace(["{player}"], [$player->getName()], $this->config->get("pages")[$i]["text"]));
                if($i >= $this->config->get("max-pages")){
                    break;
                }
            }
            LibBook::sendPreview($player, $item);
            return true;
        }
        return true;
    }
}