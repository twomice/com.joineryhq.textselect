<?php
use CRM_Textselect_ExtensionUtil as E;

class CRM_Textselect_BAO_TextSelectConfig extends CRM_Textselect_DAO_TextSelectConfig {

  /**
   * Create a new TextSelectConfig based on array-data
   *
   * @param array $params key-value pairs
   * @return CRM_Textselect_DAO_TextSelectConfig|NULL
   */
  // public static function create($params) {
  //   $className = 'CRM_Textselect_DAO_TextSelectConfig';
  //   $entityName = 'TextSelectConfig';
  //   $hook = empty($params['id']) ? 'create' : 'edit';

  //   CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
  //   $instance = new $className();
  //   $instance->copyValues($params);
  //   $instance->save();
  //   CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);

  //   return $instance;
  // } */

}
