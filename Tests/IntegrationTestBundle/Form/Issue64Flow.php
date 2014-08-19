<?php

namespace Craue\FormFlowBundle\Tests\IntegrationTestBundle\Form;

use Craue\FormFlowBundle\FormFlow\FormFlow;

/**
 * @author Christian Raue <christian.raue@gmail.com>
 * @copyright 2011-2014 Christian Raue
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Issue64Flow extends FormFlow {

	/**
	 * {@inheritDoc}
	 */
	public function getName() {
		return 'issue64';
	}

	/**
	 * {@inheritDoc}
	 */
	protected function loadStepsConfig() {
		return array(
			array(
				'label' => 'step1',
				'type' => 'issue64',
			),
			array(
				'label' => 'step2',
				'type' => 'issue64',
			),
			array(
				'label' => 'step3',
				'type' => 'issue64',
			),
			array(
				'label' => 'step4',
				'type' => 'issue64',
			),
		);
	}

}
