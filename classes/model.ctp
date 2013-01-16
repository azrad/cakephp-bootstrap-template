<?php
/**
 * Model template file.
 *
 * Used by bake to create new Model files.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.classes
 * @since         CakePHP(tm) v 1.3
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

echo "<?php\n";
echo "App::uses('{$plugin}AppModel', '{$pluginPath}Model');\n";
?>
/**
 * <?php echo $name ?> Model
 *
<?php
foreach (array('hasOne', 'belongsTo', 'hasMany', 'hasAndBelongsToMany') as $assocType) {
  if (!empty($associations[$assocType])) {
    foreach ($associations[$assocType] as $relation) {
      echo " * @property {$relation['className']} \${$relation['alias']}\n";
    }
  }
}
?>
 */
class <?php echo $name ?> extends <?php echo $plugin; ?>AppModel {

<?php if ($useDbConfig != 'default'): ?>
/**
 * Use database config
 *
 * @var string
 */
  public $useDbConfig = '<?php echo $useDbConfig; ?>';

<?php endif;

if ($useTable && $useTable !== Inflector::tableize($name)):
    $table = "'$useTable'";
    echo "/**\n * Use table\n *\n * @var mixed False or table name\n */\n";
    echo -e "  public \$useTable = $table;\n\n";
endif;

if ($primaryKey !== 'id'): ?>
/**
 * Primary key field
 *
 * @var string
 */
  public $primaryKey = '<?php echo $primaryKey; ?>';

<?php endif;

if ($displayField): ?>
/**
 * Display field
 *
 * @var string
 */
  public $displayField = '<?php echo $displayField; ?>';

<?php endif;

if (!empty($validate)):
  echo "/**\n * Validation rules\n *\n * @var array\n */\n";
  echo -e "  public \$validate = array(\n";
  foreach ($validate as $field => $validations):
    echo -e "    '$field' => array(\n";
    foreach ($validations as $key => $validator):
      echo -e "      '$key' => array(\n";
      echo -e "        'rule' => array('$validator'),\n";
      echo -e "        //'message' => 'Your custom message here',\n";
      echo -e "        //'allowEmpty' => false,\n";
      echo -e "        //'required' => false,\n";
      echo -e "        //'last' => false, // Stop validation after this rule\n";
      echo -e "        //'on' => 'create', // Limit validation to 'create' or 'update' operations\n";
      echo -e "      ),\n";
    endforeach;
    echo -e "    ),\n";
  endforeach;
  echo -e "  );\n";
endif;

foreach ($associations as $assoc):
  if (!empty($assoc)):
?>

  //The Associations below have been created with all possible keys, those that are not needed can be removed
<?php
    break;
  endif;
endforeach;

foreach (array('hasOne', 'belongsTo') as $assocType):
  if (!empty($associations[$assocType])):
    $typeCount = count($associations[$assocType]);
    echo "\n/**\n * $assocType associations\n *\n * @var array\n */";
    echo -e "\n  public \$$assocType = array(";
    foreach ($associations[$assocType] as $i => $relation):
      $out = "\n    '{$relation['alias']}' => array(\n";
      $out .= "      'className' => '{$relation['className']}',\n";
      $out .= "      'foreignKey' => '{$relation['foreignKey']}',\n";
      $out .= "      'conditions' => '',\n";
      $out .= "      'fields' => '',\n";
      $out .= "      'order' => ''\n";
      $out .= "    )";
      if ($i + 1 < $typeCount) {
        $out .= ",";
      }
      echo -e $out;
    endforeach;
    echo -e "\n  );\n";
  endif;
endforeach;

if (!empty($associations['hasMany'])):
  $belongsToCount = count($associations['hasMany']);
  echo "\n/**\n * hasMany associations\n *\n * @var array\n */";
  echo -e "\n  public \$hasMany = array(";
  foreach ($associations['hasMany'] as $i => $relation):
    $out = "\n    '{$relation['alias']}' => array(\n";
    $out .= "      'className' => '{$relation['className']}',\n";
    $out .= "      'foreignKey' => '{$relation['foreignKey']}',\n";
    $out .= "      'dependent' => false,\n";
    $out .= "      'conditions' => '',\n";
    $out .= "      'fields' => '',\n";
    $out .= "      'order' => '',\n";
    $out .= "      'limit' => '',\n";
    $out .= "      'offset' => '',\n";
    $out .= "      'exclusive' => '',\n";
    $out .= "      'finderQuery' => '',\n";
    $out .= "      'counterQuery' => ''\n";
    $out .= "    )";
    if ($i + 1 < $belongsToCount) {
      $out .= ",";
    }
    echo -e $out;
  endforeach;
  echo "\n\t);\n\n";
endif;

if (!empty($associations['hasAndBelongsToMany'])):
  $habtmCount = count($associations['hasAndBelongsToMany']);
  echo "\n/**\n * hasAndBelongsToMany associations\n *\n * @var array\n */";
  echo -e "\n  public \$hasAndBelongsToMany = array(";
  foreach ($associations['hasAndBelongsToMany'] as $i => $relation):
    $out = "\n    '{$relation['alias']}' => array(\n";
    $out .= "      'className' => '{$relation['className']}',\n";
    $out .= "      'joinTable' => '{$relation['joinTable']}',\n";
    $out .= "      'foreignKey' => '{$relation['foreignKey']}',\n";
    $out .= "      'associationForeignKey' => '{$relation['associationForeignKey']}',\n";
    $out .= "      'unique' => 'keepExisting',\n";
    $out .= "      'conditions' => '',\n";
    $out .= "      'fields' => '',\n";
    $out .= "      'order' => '',\n";
    $out .= "      'limit' => '',\n";
    $out .= "      'offset' => '',\n";
    $out .= "      'finderQuery' => '',\n";
    $out .= "      'deleteQuery' => '',\n";
    $out .= "      'insertQuery' => ''\n";
    $out .= "    )";
    if ($i + 1 < $habtmCount) {
      $out .= ",";
    }
    echo -e $out;
  endforeach;
  echo -e "\n  );\n\n";
endif;
?>
}
