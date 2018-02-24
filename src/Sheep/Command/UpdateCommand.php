<?php
/**
 * Copyright (c) 2017, 2018 KnownUnown
 *
 * This file is part of Sheep.
 *
 * Sheep is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by 
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Sheep is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace Sheep\Command;


use pocketmine\utils\TextFormat;
use Sheep\Command\Problem\Problem;
use Sheep\Utils\Error;

class UpdateCommand extends Command {

	public function __construct() {
		parent::__construct("update", "Updates a plugin.");
		$this->arg("plugin", "The plugin to update.", true);
	}

	protected function execute(Problem $problem, array $args) {
		$plugin = $args["plugin"];
		$problem->printf("Updating %s...", $plugin);
		$this->api->update($plugin)
			->then(function() use (&$problem, $plugin) {
				$problem->printf("Successfully downloaded an update for %s. %sPlease restart your server to enable it.",
					$plugin, TextFormat::RED . TextFormat::BOLD);
			})
			->otherwise(function(Error $error) use (&$problem) {
				$problem->print("Failure: $error");
			});
	}
}
