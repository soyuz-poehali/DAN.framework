<?php
defined('AUTH') or die('Restricted access');

class Settings
{
	public function getSettings()
	{
		global $db;

		$stmt = $db->query("SELECT id, settings, status FROM settings WHERE id = 1");
		$data = $stmt->fetch();
		$settings = unserialize($data['settings']);
		$settings['status'] = $data['status'];

		return $settings;
	}

	public function updateSettings($settings, $status)
	{
		global $db;

		$settings = serialize($settings);

		$stmt = $db->prepare("UPDATE settings SET settings = :settings, status = :status WHERE id = 1");
		$stmt->execute(array('settings' => $settings, 'status' => $status));
	}
}