<?php

namespace Drupal\compact_forms\Form;

use Drupal\Core\Form\ConfigFormBase;

class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormID() {
    return 'compact_forms_admin_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, array &$form_state) {
    $compact_forms_config = $this->config('compact_forms.settings');

    $form['compact_forms_ids'] = array(
      '#type' => 'textarea',
      '#title' => t('Form CSS IDs'),
      '#rows' => 3,
      '#cols' => 40,
      '#default_value' => $compact_forms_config->get('compact_forms_ids'),
      '#description' => t('Enter the CSS IDs of the forms to display compact. One per line.'),
    );
    $form['compact_forms_descriptions'] = array(
      '#type' => 'checkbox',
      '#title' => t('Hide field descriptions'),
      '#default_value' => $compact_forms_config->get('compact_forms_descriptions'),
    );
    $form['compact_forms_stars'] = array(
      '#type' => 'radios',
      '#title' => t('Required field marker'),
      '#options' => array(
        0 => t('Remove star'),
        1 => t('Leave star after the label'),
        2 => t('Append star after the form element'),
      ),
      '#default_value' => $compact_forms_config->get('compact_forms_stars'),
    );
    $form['compact_forms_field_size'] = array(
      '#type' => 'textfield',
      '#title' => t('Enforced text field size'),
      '#size' => 3,
      '#default_value' => $compact_forms_config->get('compact_forms_field_size'),
      '#field_suffix' => t('characters'),
      '#description' => t("If not empty, the size of all text fields in compact forms will be set to the entered size."),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, array &$form_state) {
    $this->config('compact_forms.settings')
      ->set('compact_forms_ids', $form_state['values']['compact_forms_ids'])
      ->set('compact_forms_descriptions', $form_state['values']['compact_forms_descriptions'])
      ->set('compact_forms_stars', $form_state['values']['compact_forms_stars'])
      ->set('compact_forms_field_size', $form_state['values']['compact_forms_field_size'])
      ->save();
    drupal_set_message($this->t('Configuration was successfully saved.'));
  }
}
