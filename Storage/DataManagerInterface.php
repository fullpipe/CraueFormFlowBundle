<?php

namespace Craue\FormFlowBundle\Storage;

use Craue\FormFlowBundle\Form\FormFlowInterface;

/**
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2014 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
interface DataManagerInterface {

	/**
	 * @var string Key for storing data of all flows.
	 */
	const STORAGE_ROOT = 'craue_form_flow';

	/**
	 * @return StorageInterface
	 */
	function getStorage();

	/**
	 * Save data of the given flow.
	 * @param FormFlowInterface $flow
	 * @param array $data
	 */
	function save(FormFlowInterface $flow, array $data);

	/**
	 * Load data of the given flow.
	 * @param FormFlowInterface $flow
	 * @return array
	 */
	function load(FormFlowInterface $flow);

	/**
	 * Drop data of the given flow.
	 * @param FormFlowInterface $flow
	 */
	function drop(FormFlowInterface $flow);

}
