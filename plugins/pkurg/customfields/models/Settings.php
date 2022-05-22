<?php

namespace Pkurg\Customfields\Models;

use Model;

class Settings extends Model
{

	public $implement = ['System.Behaviors.SettingsModel'];

	public $settingsCode = 'custom_fields_settings';

	public $settingsFields = 'fields.yaml';

	protected $cache = [];

	public $attachOne = [
		'og_image' => ['System\Models\File'],
		'favicon' => ['System\Models\File'],
		'appicon' => ['System\Models\File'],
	];

	public function afterFetch()
	{
		if ($this->apikey === null) {
			$this->apikey = uniqid();
		}

	}

}
