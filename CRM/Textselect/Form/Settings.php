<?php

use CRM_Textselect_ExtensionUtil as E;

/**
 * Form controller class
 *
 * @see https://wiki.civicrm.org/confluence/display/CRMDOC/QuickForm+Reference
 */
class CRM_Textselect_Form_Settings extends CRM_Core_Form {
  public function buildQuickForm() {
    $optionGroupOptions = array('' => '') + CRM_Core_BAO_OptionValue::buildOptions('option_group_id', 'get', array('labelColumn' => 'title'));

    $descriptions['contribution_source_option_group'] = ts('Option group to use for "Source" field on contributions. Leave blank to disable this feature.')
      . ' <a href="'. CRM_Utils_System::url('civicrm/admin/options', 'reset=1') .'" target="blank">'
      . ts('Manage option groups')
      . '</a>';

    // add form elements
    $this->add(
      'select', // field type
      'contribution_source_option_group', // field name
      'Option grouip for Contribution "Source" field', // field label
      $optionGroupOptions, // list of options
      FALSE // is required
    );
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
  function setDefaultValues() {
    $jsonSettings = Civi::settings()->get('textselect_config');
    $settings = json_decode($jsonSettings, TRUE);

    $ret = array(
      'contribution_source_option_group' => $settings['forms']['CRM_Contribute_Form_Contribution']['fields']['source']['option_group_id'],
    );
    return $ret;
    
    $domainID = CRM_Core_Config::domainID();
    $ret = CRM_Utils_Array::value($domainID, $result['values']);
    return $ret;
  }

  public function postProcess() {
    $values = $this->exportValues();

    $settings = array();
    $settings['forms']['CRM_Contribute_Form_Contribution']['fields']['source']['option_group_id'] = $values['contribution_source_option_group'];
    $jsonSettings = json_encode($settings);
    Civi::settings()->set('textselect_config', $jsonSettings);
    crm_core_session::setStatus(ts('Settings were saved.'), 'Saved', 'success');
    CRM_Utils_System::redirect(CRM_Utils_System::url('civicrm/admin/textselect/settings', 'reset=1'));
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
