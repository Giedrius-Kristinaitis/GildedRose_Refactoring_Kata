<?php

namespace App;

class QualityUpdateRate {

    /**
	 * @var int $update_rate How much the quality changes in one day
	 */
	public $update_rate;
	
	/**
	 * @var int $applied_down_to_day The day down to which the rate is valid. For example, 
	 *								 if the specified day is 6, then the rate will apply to everything older
	 *								 than 6 days
	 */
	public $applied_down_to_day;
	
	public function __construct($update_rate, $applied_down_to_day) {
		$this->update_rate = $update_rate;
		$this->applied_down_to_day = $applied_down_to_day;
	}
}