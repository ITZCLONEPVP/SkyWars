<?php

/**
 * Copyright 2018 GamakCZ
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

declare(strict_types=1);

namespace skywars\provider;

use pocketmine\utils\Config;
use skywars\arena\Arena;
use skywars\SkyWars;

/**
 * Class YamlDataProvider
 * @package skywars\provider
 */
class YamlDataProvider {

    /** @var SkyWars $plugin */
    private $plugin;

    /**
     * YamlDataProvider constructor.
     * @param SkyWars $plugin
     */
    public function __construct(SkyWars $plugin) {
        $this->plugin = $plugin;
        $this->init();
        $this->loadArenas();
    }

    public function init() {
        if(!is_dir($this->getDataFolder())) {
            @mkdir($this->getDataFolder());
        }
        if(!is_dir($this->getDataFolder() . "arenas")) {
            @mkdir($this->getDataFolder() . "arenas");
        }
    }

    public function loadArenas() {
        foreach (glob($this->getDataFolder() . DIRECTORY_SEPARATOR . "*.yml") as $arenaFile) {
            $config = new Config($arenaFile, Config::YAML);
            $this->plugin->arenas[basename($arenaFile, ".yml")] = new Arena($this->plugin, $config->getAll(\false));
        }
    }

    /**
     * @return string $dataFolder
     */
    private function getDataFolder(): string {
        return $this->plugin->getDataFolder();
    }
}
