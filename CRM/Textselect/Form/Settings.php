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
    $this->id = $_GET['id'];
    if ($this->action == 'delete') {
      $descriptions['delete_warning'] = E::ts('Are you sure you want to delete this configuration?');
      $this->add('hidden', 'action', $this->action);
      $this->add('hidden', 'id', $this->id);
      $this->assign('descriptions', $descriptions);
    }
    else {
      $optionGroupOptions = array('' => '') + CRM_Core_BAO_OptionValue::buildOptions('option_group_id', 'get', array('labelColumn' => 'title'));

      $descriptions['option_group_id'] = E::ts('Option group to use for this field')
        . ' <a href="' . CRM_Utils_System::url('civicrm/admin/options', 'reset=1') . '" target="blank">'
        . E::ts('Manage option groups')
        . '</a>';

      // add form elements

      // List of supported fields, as options in field_id field.
      $fieldOptions = array();
      // Populate field options with supported native fields.
      foreach (CRM_Textselect_Util::getSupportedFieldDefinitions() as $supportedNativeFieldKey => $supportedNativeFieldDefinition) {
        $fieldOptions[$supportedNativeFieldKey] = $supportedNativeFieldDefinition['label'];;
      }
      $this->add(
        // field type
        'select',
        // field name
        'field_id',
        // field label
        'Field',
        // list of options
        $fieldOptions,
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
    }
    $this->addButtons(array(
      array(
        'type' => 'submit',
        'name' => E::ts('Submit'),
        'isDefault' => TRUE,
      ),
    ));

    $this->add('hidden', 'action', $this->action);
    $this->add('hidden', 'id', $this->id);

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
    if ($this->id) {
      $textSelectConfig = civicrm_api3('textSelectConfig', 'getSingle', ['id' => $this->id]);
      return $textSelectConfig;
    }
    return [];
  }

  public function postProcess() {
    $submitted = $this->exportValues();
    if ($submitted['action'] == 'add' || $submitted['action'] == 'update') {
      civicrm_api3('TextSelectConfig', 'create', $submitted);
      CRM_Core_Session::setStatus(ts('Settings have been saved.'), E::ts('Saved'), 'success');
    }
    elseif ($submitted['action'] == 'delete') {
      civicrm_api3('TextSelectConfig', 'delete', ['id' => $submitted['id']]);
      CRM_Core_Session::setStatus(E::ts('The TextSelect Confgiuration has been deleted.'), E::ts('Deleted'), 'success');
    }

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
