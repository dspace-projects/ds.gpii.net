<?php

/**
 * @file
 * Contains \Drupal\github_projects\Form\Github_ProjectsForm.
 */

namespace Drupal\github_projects\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class Github_ProjectsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'github_projects_form';
  }

  /**
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Form constructor
    $form = parent::buildForm($form, $form_state);
    // Default settings
    $config = $this->config('github_projects.settings');
    // Source text field
    $form['oauth'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Personal access token for authorization:'),
      '#default_value' => $config->get('github_projects.oauth'),
      '#description' => $this->t('Generate an personal access token <a href="https://github.com/settings/tokens/new" target="_blank" title="OAuth token">here</a>.'),
    );

    return $form;
  }

  /**
   * {@inheritdoc}.
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $client = \Drupal::httpClient();
    try {
      $response = $client->get('https://api.github.com/user', ['headers' => ['Authorization' => "token {$form_state->getValue('oauth')}"]]);
      $body = $response->getBody();
    } catch(RequestException $e) {
      $form_state->setErrorByName('oauth', $this->t('Error: @error', array('@error' => $e->getMessage())));
    }
    $json = json_decode($body, true);
    switch ($response->getStatusCode()) {
      case 200:
        $form_state->setValue('login', $json['login']);
        break;
      case 401:
        $form_state->setErrorByName('oauth', $this->t('Error: @error', array('@error' => $json['message'])));
        break;
      default:
        $form_state->setErrorByName('oauth', $this->t('HTTP Status Code: @error', array('@error' => $response->getStatusCode())));
    }
  }

  /**
   * {@inheritdoc}.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
	drupal_set_message($this->t('Hi @login', array('@login' => $form_state->getValue('login'))));
    $config = $this->config('github_projects.settings');
    $config->set('github_projects.oauth', $form_state->getValue('oauth'));
    $config->save();
    return parent::submitForm($form, $form_state);
  }

  /**
   * {@inheritdoc}.
   */
  protected function getEditableConfigNames() {
    return [
      'github_projects.settings',
    ];
  }

}
