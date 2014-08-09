<?php

namespace Craue\FormFlowBundle\Storage;

/**
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2014 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class FlowData {

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $instanceId;

	/**
	 * @var array
	 */
	protected $data;

	public function __construct($name, $instanceId, array $data) {
		$this->name = $name;
		$this->instanceId = $instanceId;
		$this->data = $data;
	}

	public function getName() {
		return $this->name;
	}

	public function getInstanceId() {
		return $this->instanceId;
	}

	public function getData() {
		return $this->data;
	}

}
