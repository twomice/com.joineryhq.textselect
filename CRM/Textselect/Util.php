<?php

/**
 * Utilities for Textselect extension.
 *
 * @author as
 */
class CRM_Textselect_Util {
  public static function getAllFieldOptions() {
    $existing = array();
    $sql = "SELECT * FROM civicrm_text_select_config;";
    $dao = CRM_Core_DAO::executeQuery($sql);
    while ($dao->fetch()) {
      $existing[] = $dao->toArray();
    }

    $allFieldOptions = array();
    foreach ($existing as $setting) {
      $result = civicrm_api3('OptionValue', 'get', [
        'sequential' => 1,
        'option_group_id' => $setting['option_group_id'],
      ]);
      $allFieldOptions[$setting['field_id']] = $result['values'];
    }
    return $allFieldOptions;
  }

}
