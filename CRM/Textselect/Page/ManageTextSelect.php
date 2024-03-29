<?php
use CRM_Textselect_ExtensionUtil as E;

class CRM_Textselect_Page_ManageTextSelect extends CRM_Core_Page_Basic {
  public $useLivePageJS = TRUE;

  public static $_links = NULL;

  public function getBAOName() {
    return 'CRM_Textselect_BAO_TextSelectConfig';
  }

  public function run() {
    $this->assign('supportedNativeFieldDefinitions', CRM_Textselect_Util::getSupportedFieldDefinitions());
    return parent::run();
  }

  public function &links() {
    if (!(self::$_links)) {
      self::$_links = array(
        CRM_Core_Action::UPDATE => array(
          'name' => E::ts('Edit'),
          'url' => 'civicrm/admin/textselect/settings',
          'qs' => 'action=update&id=%%id%%&reset=1',
          'title' => E::ts('Edit Text Select Config'),
        ),
        CRM_Core_Action::DELETE => array(
          'name' => E::ts('Delete'),
          'url' => 'civicrm/admin/textselect/settings',
          'qs' => 'action=delete&id=%%id%%',
          'title' => E::ts('Delete Text Select Config'),
        ),
      );
    }
    return self::$_links;
  }

  public function editForm() {
    return 'CRM_Textselect_Form_Settings';
  }

  public function editName() {
    return 'Text Select Config';
  }

  public function userContext($mode = NULL) {
    return 'civicrm/admin/text-select';
  }

}
