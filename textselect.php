<?php

require_once 'textselect.civix.php';
use CRM_Textselect_ExtensionUtil as E;

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildForm
 */
function textselect_civicrm_buildForm($formName, &$form) {
  if ($formName == 'CRM_Contribute_Form_Contribution') {

    $jsonSettings = Civi::settings()->get('textselect_config');
    $settings = json_decode($jsonSettings, TRUE);

    $sourceOptionGroupId = $settings['forms']['CRM_Contribute_Form_Contribution']['fields']['source']['option_group_id'];
    if (!empty($sourceOptionGroupId)) {
      CRM_Core_Resources::singleton()->addScriptFile('com.joineryhq.textselect', 'js/textselect.js');

      $variables = array(
        'options' => array(
          'source' => CRM_Core_BAO_OptionValue::getOptionValuesAssocArray($sourceOptionGroupId),
        ),
      );
      CRM_Core_Resources::singleton()->addVars('com.joineryhq.textselect', $variables);
    }
  }
}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 */
function textselect_civicrm_navigationMenu(&$menu) {
  _textselect_get_max_navID($menu, $max_navID);
  _textselect_civix_insert_navigation_menu($menu, 'Administer/Customize Data and Screens', array(
    'label' => ts('TextSelect settings', array('domain' => 'com.joineryhq.textselect')),
    'name' => 'TextSelect settings',
    'url' => 'civicrm/admin/textselect/settings',
    'permission' => 'administer CiviCRM',
    'operator' => 'AND',
    'separator' => NULL,
    'navID' => ++$max_navID,
  ));
  _textselect_civix_navigationMenu($menu);
}

/**
 * For an array of menu items, recursively get the value of the greatest navID
 * attribute.
 * @param <type> $menu
 * @param <type> $max_navID
 */
function _textselect_get_max_navID(&$menu, &$max_navID = NULL) {
  foreach ($menu as $id => $item) {
    if (!empty($item['attributes']['navID'])) {
      $max_navID = max($max_navID, $item['attributes']['navID']);
    }
    if (!empty($item['child'])) {
      _textselect_get_max_navID($item['child'], $max_navID);
    }
  }
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function textselect_civicrm_config(&$config) {
  _textselect_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function textselect_civicrm_xmlMenu(&$files) {
  _textselect_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function textselect_civicrm_install() {
  _textselect_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function textselect_civicrm_postInstall() {
  _textselect_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function textselect_civicrm_uninstall() {
  _textselect_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function textselect_civicrm_enable() {
  _textselect_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function textselect_civicrm_disable() {
  _textselect_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function textselect_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _textselect_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function textselect_civicrm_managed(&$entities) {
  _textselect_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function textselect_civicrm_caseTypes(&$caseTypes) {
  _textselect_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function textselect_civicrm_angularModules(&$angularModules) {
  _textselect_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function textselect_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _textselect_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function textselect_civicrm_preProcess($formName, &$form) {

} // */

