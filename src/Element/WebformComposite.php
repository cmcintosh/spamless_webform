<?php

namespace Drupal\webform\Element;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element\FormElement;

/**
 * Provides a webform custom composite element.
 *
 * @FormElement("webform_composite")
 */
class WebformComposite extends WebformMultiple {

  /**
   * Process items and build multiple elements widget.
   */
  public static function processWebformMultiple(&$element, FormStateInterface $form_state, &$complete_form) {
    /** @var \Drupal\webform\Plugin\WebformElementManagerInterface $element_manager */
    $element_manager = \Drupal::service('plugin.manager.webform.element');
    foreach ($element['#element'] as $composite_key => $composite_element) {
      // Initialize, prepare, and populate composite sub-element.
      $element_plugin = $element_manager->getElementInstance($composite_element);
      $element_plugin->initialize($composite_element);
      $element_plugin->prepare($composite_element);
      $element_plugin->finalize($composite_element);
      if ($element['#header'] && !isset($composite_element['#title_display'])) {
        $composite_element['#title_display'] = 'invisible';
      }
      $element['#element'][$composite_key] = $composite_element;
    }

    return parent::processWebformMultiple($element, $form_state, $complete_form);
  }

}
