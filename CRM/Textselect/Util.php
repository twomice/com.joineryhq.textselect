<?php
use CRM_Textselect_ExtensionUtil as E;

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

  /**
   * Get an array of properties for each supported native and custom field.
   * @return array
   *   Example: return = [
   *     [field_key] => [
   *       'label' => [user-facing label for this field]
   *       'selectors' => [
   *         [jQuery selector the would match this field in some context],
   *         [jQuery selector the would match this field in some other context],
   *         [jQuery selector ... etc.],
   *       ],
   *     ],
   *   ];
   */
  public static function getSupportedFieldDefinitions() {
    $ret = [];
    // support contact source
    $ret['contact_source'] = [
      'label' => E::ts('[native] :: Contact Source'),
      'selectors' => [
        '#contact_source',
      ],
    ];
    // support contribution source
    $ret['contribution_source'] = [
      'label' => E::ts('[native] :: Contribution Source'),
      'selectors' => [
        'form.CRM_Contribute_Form_Contribution #source',
        'form.CRM_Profile_Form_Edit #contribution_source',
        'form.crm-search-form #contribution_source',
      ],
    ];
    // support member source
    $ret['member_source'] = [
      'label' => E::ts('[native] :: Membership Source'),
      'selectors' => [
        'form.CRM_Member_Form_Membership #source',
        'form.CRM_Profile_Form_Edit #member_source',
        'form.crm-search-form #member_source',
      ],
    ];
    // support participant source
    $ret['participant_source'] = [
      'label' => E::ts('[native] :: Participant Source'),
      'selectors' => [
        'form.CRM_Event_Form_Participant #source',
        'form.CRM_Profile_Form_Edit #participant_source',
        'form.crm-search-form #participant_source',
      ],
    ];

    // support custom text fields.
    $supportedCustomFields = [];
    $results = civicrm_api3('CustomField', 'get', [
      'sequential' => 1,
      'data_type' => "String",
      'html_type' => "Text",
      'is_view' => 0,
    ]);
    foreach ($results['values'] as $value) {
      $customFieldId = $value['id'];
      $group = civicrm_api3('CustomGroup', 'getsingle', [
        'id' => $value['custom_group_id'],
      ]);
      $supportedCustomFields[$customFieldId] = [
        'label' => $group['title'] . " :: " . $value['label'],
        'selectors' => [
          // Simple selectors is e.g. "#custom_123"
          '#custom_' . $customFieldId,
          // Custom fields sometimes present as custom_[field_id]_[integer]
          'input[id^="custom_' . $customFieldId . '_"]',
        ],
      ];
    }
    // Sort custom fields by label (which is 'group_title :: field_label').
    uasort($supportedCustomFields, function($a, $b) {
      return ($a >= $b ? 1 : -1);
    });

    // Append custom fields to list of supported fields.
    $ret += $supportedCustomFields;
    return $ret;
  }

}
