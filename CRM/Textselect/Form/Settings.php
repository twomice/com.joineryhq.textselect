<?php

use CRM_Textselect_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://wiki.civicrm.org/confluence/display/CRMDOC/QuickForm+Reference
 */
class CRM_Textselect_Form_Settings extends CRM_Core_Form {

  public function buildQuickForm() {
    $this->action = $_GET['action'];
    $this->config_id = $_GET['id'];
    if ($this->action == 'delete') {
      $descriptions['delete_warning'] = E::ts('Are you sure you want to delete this configuration?');
      $this->add('hidden', 'action', $this->action);
      $this->add('hidden', 'config_id', $this->config_id);
      $this->assign('descriptions', $descriptions);
    }
    else {
      $optionGroupOptions = array('' => '') + CRM_Core_BAO_OptionValue::buildOptions('option_group_id', 'get', array('labelColumn' => 'title'));

      $descriptions['contribution_source_option_group'] = E::ts('Option group to use for field')
        . ' <a href="' . CRM_Utils_System::url('civicrm/admin/options', 'reset=1') . '" target="blank">'
        . E::ts('Manage option groups')
        . '</a>';

      // add form elements

      $results = civicrm_api3('CustomField', 'get', [
        'sequential' => 1,
        'data_type' => "String",
        'html_type' => "Text",
        'is_view' => 0,
      ]);

      $fieldarr = array();
      foreach ($results['values'] as $value) {
        $group = civicrm_api3('CustomGroup', 'getsingle', [
          'id' => $value['custom_group_id'],
        ]);
        $fieldarr[$value['id']] = $group['title'] . " :: " . $value['label'];
      }
      //continue to support contribution source
      $fieldarr['contribution_source'] = E::ts('[native] :: Contribution Source');
      // support contact source
      $fieldarr['contact_source'] = E::ts('[native] :: Contact Source');
      asort($fieldarr);
      $this->add(
        // field type
        'select',
        // field name
        'field_id',
        // field label
        'Field',
        // list of options
        $fieldarr,
        // is required
        TRUE
      );

      $this->add(
        // field type
        'select',
        // field name
        'option_group_id',
        // field label
        'Option group',
        // list of options
        $optionGroupOptions,
        // is required
        TRUE
      );

      $this->add('hidden', 'action', $this->action);
      $this->add('hidden', 'calendar_id', $this->config_id);
    }
    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => E::ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));

    // export form elements
    $this->assign('elementNames', $this->getRenderableElementNames());
    $this->assign('descriptions', $descriptions);
    parent::buildQuickForm();
  }

  /**
   * Set defaults for form.
   *
   * @see CRM_Core_Form::setDefaultValues()
   */
  public function setDefaultValues() {
    if ($this->config_id && ($this->action != 'delete')) {
      $existing = array();
      $sql = "SELECT * FROM civicrm_text_select_config WHERE id = {$this->config_id};";
      $dao = CRM_Core_DAO::executeQuery($sql);
      while ($dao->fetch()) {
        $existing[] = $dao->toArray();
      }
      $defaults = array();
      foreach ($existing as $name => $value) {
        $defaults[$name] = $value;
      }
    }
    return $defaults[0];
  }

  public function postProcess() {
    $submitted = $this->exportValues();
    if ($submitted['action'] == 'add') {
      $sql = "INSERT INTO civicrm_text_select_config(option_group_id, field_id)
       VALUES ('{$submitted['option_group_id']}', '{$submitted['field_id']}');";
      $dao = CRM_Core_DAO::executeQuery($sql);
    }

    if ($submitted['action'] == 'update') {
      $sql = "UPDATE civicrm_text_select_config
       SET option_group_id = '{$submitted['option_group_id']}', field_id = '{$submitted['field_id']}'
       WHERE `id` = {$submitted['config_id']};";
      $dao = CRM_Core_DAO::executeQuery($sql);
    }

    if ($submitted['action'] == 'delete') {
      $sql = "DELETE FROM civicrm_text_select_config WHERE `id` = '{$submitted['config_id']}';";
      $dao = CRM_Core_DAO::executeQuery($sql);
    }

    CRM_Core_Session::setStatus(ts('Settings have been saved.'), E::ts('Saved'), 'success');
    parent::postProcess();
  }

  /**
   * Get the fields/elements defined in this form.
   *
   * @return array (string)
   */
  public function getRenderableElementNames() {
    // The _elements list includes some items which should not be
    // auto-rendered in the loop -- such as "qfKey" and "buttons".  These
    // items don't have labels.  We'll identify renderable by filtering on
    // the 'label'.
    $elementNames = array();
    foreach ($this->_elements as $element) {
      /** @var HTML_QuickForm_Element $element */
      $label = $element->getLabel();
      if (!empty($label)) {
        $elementNames[] = $element->getName();
      }
    }
    return $elementNames;
  }

}
