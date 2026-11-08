<?php
class ControllerStartupEvent extends Controller {
	public function index() {
		$this->load->model('setting/event');

		$results = $this->model_setting_event->getEvents();

		foreach ($results as $result) {
			$this->event->register(substr($result['trigger'], strpos($result['trigger'], '/') + 1), new Action($result['action']), $result['sort_order']);
		}
	}
}
