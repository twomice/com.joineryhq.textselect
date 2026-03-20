<?php
use CRM_Textselect_ExtensionUtil as E;

return [
  'name' => 'TextSelectConfig',
  'table' => 'civicrm_text_select_config',
  'class' => 'CRM_Textselect_DAO_TextSelectConfig',
  'getInfo' => fn() => [
    'title' => E::ts('Text Select Config'),
    'title_plural' => E::ts('Text Select Configs'),
    'description' => E::ts(''),
    'log' => TRUE,
  ],
  'getFields' => fn() => [
    'id' => [
      'title' => E::ts('ID'),
      'sql_type' => 'int unsigned',
      'input_type' => 'EntityRef',
      'required' => TRUE,
      'description' => E::ts('Unique TextSelectConfig ID'),
      'entity_reference' => [
        'entity' => 'OptionGroup',
        'key' => 'id',
        'on_delete' => 'CASCADE',
      ],
      'primary_key' => TRUE,
      'auto_increment' => TRUE,
    ],
    'option_group_id' => [
      'title' => E::ts('Option Group ID'),
      'sql_type' => 'int unsigned',
      'input_type' => 'Number',
      'description' => E::ts('FK to Option Group'),
    ],
    'field_id' => [
      'title' => E::ts('Field ID'),
      'sql_type' => 'varchar(255)',
      'input_type' => 'Text',
      'description' => E::ts('custom field ID'),
    ],
  ],
];
