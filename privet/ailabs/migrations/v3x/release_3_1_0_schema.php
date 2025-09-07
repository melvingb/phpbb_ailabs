<?php

/**
 *
 * AI Labs extension
 *
 * @copyright (c) 2024-2025, privet.fun, https://privet.fun
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace privet\ailabs\migrations\v3x;

class release_3_1_0_schema extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\privet\ailabs\migrations\v3x\release_3_0_0_schema');
	}

	public function effectively_installed()
	{
		return isset($this->config['privet_ailabs_version']) && version_compare($this->config['privet_ailabs_version'], '3.1.0', '>=');
	}

	public function update_data()
	{
		return array(
			array('config.update', array('privet_ailabs_version', '3.1.0')),
		);
	}

	public function revert_data()
	{
		return array(
			array('config.update', array('privet_ailabs_version', '3.0.0')),
		);
	}
}
