<?php

require_once 'textselect.civix.php';
use CRM_Textselect_ExtensionUtil as E;

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildForm
 */
function textselect_civicrm_buildForm($formName, &$form) {
  $variables = array(
    'allFieldOptions' => CRM_Textselect_Util::getAllFieldOptions(),
    'supportedFieldDefinitions' => CRM_Textselect_Util::getSupportedFieldDefinitions(),
  );
  CRM_Core_Resources::singleton()->addScriptFile('com.joineryhq.textselect', 'js/textselect.js');
  CRM_Core_Resources::singleton()->addVars('textselect', $variables);
}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 */
function textselect_civicrm_navigationMenu(&$menu) {
  _textselect_get_max_navID($menu, $max_navID);
  _textselect_civix_insert_navigation_menu($menu, 'Administer/Customize Data and Screens', array(
    'label' => E::ts('TextSelect settings', array('domain' => 'com.joineryhq.textselect')),
    'name' => 'TextSelect settings',
    'url' => 'civicrm/admin/text-select',
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
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function textselect_civicrm_install() {
  _textselect_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function textselect_civicrm_enable() {
  _textselect_civix_civicrm_enable();
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 */
// function textselect_civicrm_preProcess($formName, &$form) {

// } // */
