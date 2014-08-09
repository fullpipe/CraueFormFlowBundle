<?php

namespace Craue\FormFlowBundle\Storage;

use Craue\FormFlowBundle\Form\FormFlowInterface;

/**
 * Manages data of flows and their steps.
 *
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2014 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class DataManager implements ExtendedDataManagerInterface {

	/**
	 * @var StorageInterface
	 */
	protected $storage;

	/**
	 * @param StorageInterface $storage
	 */
	public function __construct(StorageInterface $storage) {
		$this->storage = $storage;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getStorage() {
		return $this->storage;
	}

	/**
	 * {@inheritDoc}
	 */
	public function save(FormFlowInterface $flow, array $data) {
		// handle file uploads
		if ($flow->isHandleFileUploads()) {
			array_walk_recursive($data, function(&$value, $key) {
				if (SerializableFile::isSupported($value)) {
					$value = new SerializableFile($value);
				}
			});
		}

		// drop old data
		$this->drop($flow);

		// save new data
		$savedFlows = $this->storage->get(DataManagerInterface::STORAGE_ROOT, array());
		$savedFlows[] = new FlowData($flow->getName(), $flow->getInstanceId(), $data);
		$this->storage->set(DataManagerInterface::STORAGE_ROOT, $savedFlows);
	}

	/**
	 * {@inheritDoc}
	 */
	public function load(FormFlowInterface $flow) {
		$loadedData = array();

		// try to find data for the given flow
		foreach ($this->storage->get(DataManagerInterface::STORAGE_ROOT, array()) as $flowData) {
			if ($flowData->getName() === $flow->getName() && $flowData->getInstanceId() === $flow->getInstanceId()) {
				$loadedData = $flowData->getData();
				break;
			}
		}

		// handle file uploads
		if ($flow->isHandleFileUploads()) {
			$tempDir = $flow->getHandleFileUploadsTempDir();
			array_walk_recursive($loadedData, function(&$value, $key) use ($tempDir) {
				if ($value instanceof SerializableFile) {
					$value = $value->getAsFile($tempDir);
				}
			});
		}

		return $loadedData;
	}

	/**
	 * {@inheritDoc}
	 */
	public function drop(FormFlowInterface $flow) {
		$savedFlows = $this->storage->get(DataManagerInterface::STORAGE_ROOT, array());

		// remove old data for only this flow instance
		$otherFlows = array_filter($savedFlows, function($flowData) use ($flow) {
			return !($flowData->getName() === $flow->getName() && $flowData->getInstanceId() === $flow->getInstanceId());
		});

		$this->storage->set(DataManagerInterface::STORAGE_ROOT, $otherFlows);
	}

	/**
	 * {@inheritDoc}
	 */
	public function listFlows() {
		$flows = array();

		foreach ($this->storage->get(DataManagerInterface::STORAGE_ROOT, array()) as $flowData) {
			if (!in_array($flowData->getName(), $flows)) {
				$flows[] = $flowData->getName();
			}
		}

		return $flows;
	}

	/**
	 * {@inheritDoc}
	 */
	public function listInstances($name) {
		$instances = array();

		foreach ($this->storage->get(DataManagerInterface::STORAGE_ROOT, array()) as $flowData) {
			if ($flowData->getName() === $name) {
				$instances[] = $flowData->getInstanceId();
			}
		}

		return $instances;
	}

	/**
	 * {@inheritDoc}
	 */
	public function dropAll() {
		$this->storage->remove(DataManagerInterface::STORAGE_ROOT);
	}

}
