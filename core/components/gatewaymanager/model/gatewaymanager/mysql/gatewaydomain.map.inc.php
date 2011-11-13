<?php
$xpdo_meta_map['gatewayDomain']= array (
  'package' => 'gatewaymanager',
  'table' => 'gateways',
  'fields' => 
  array (
    'domain' => NULL,
    'context' => NULL,
    'sitestart' => 0,
  ),
  'fieldMeta' => 
  array (
    'domain' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '255',
      'phptype' => 'string',
      'null' => false,
      'index' => 'index',
    ),
    'context' => 
    array (
      'dbtype' => 'varchar',
      'precision' => '100',
      'phptype' => 'string',
      'null' => false,
      'index' => 'index',
    ),
    'sitestart' => 
    array (
      'dbtype' => 'int',
      'precision' => '11',
      'phptype' => 'integer',
      'null' => true,
      'default' => 0,
    ),
  ),
  'aggregates' => 
  array (
    'Context' => 
    array (
      'class' => 'modContext',
      'local' => 'context',
      'foreign' => 'key',
      'cardinality' => 'one',
      'owner' => 'foreign',
    ),
  ),
);
