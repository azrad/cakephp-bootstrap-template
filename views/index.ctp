<?php
/**
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
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<div class="row">
  <div class="span12 <?php echo $pluralVar; ?> index">
    <div class="clearfix">
      <div class="btn-group pull-right">
        <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
          Action
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
        <?php
          $done = array();
          foreach ($associations as $type => $data) {
            foreach ($data as $alias => $details) {
              if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
                echo "\t\t<li><?php echo \$this->Html->link(__('List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index')); ?> </li>\n";
                echo "\t\t<li><?php echo \$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add')); ?> </li>\n";
                $done[] = $details['controller'];
              }
            }
          }
        ?>
          <li class="divider"></li>
          <li><?php echo "<?php echo \$this->Html->link(__('New " . $singularHumanName . "'), array('action' => 'add')); ?>"; ?></li>
        </ul>
      </div>
    </div>
    
    <h2><?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?></h2>


    <table class="table">
    <tr>
    <?php  foreach ($fields as $field): ?>
      <th><?php echo "<?php echo \$this->Paginator->sort('{$field}'); ?>"; ?></th>
    <?php endforeach; ?>
      <th class="actions"><?php echo "<?php echo __('Actions'); ?>"; ?></th>
    </tr>
    <?php
    echo "<?php
    foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
    echo "\t<tr>\n";
      foreach ($fields as $field) {
        $isKey = false;
        if (!empty($associations['belongsTo'])) {
          foreach ($associations['belongsTo'] as $alias => $details) {
            if ($field === $details['foreignKey']) {
              $isKey = true;
              echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
              break;
            }
          }
        }
        if ($isKey !== true) {
          echo "\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
        }
      }

      echo "\t\t<td class=\"actions\">\n";
      echo "\t\t\t<?php echo \$this->Html->link(__('View'), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
      echo "\t\t\t<?php echo \$this->Html->link(__('Edit'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
      echo "\t\t\t<?php echo \$this->Form->postLink(__('Delete'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), null, __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
      echo "\t\t</td>\n";
    echo "\t</tr>\n";

    echo "<?php endforeach; ?>\n";
    ?>
    </table>
  </div>
</div>
<div class="row">
  <div class="span12">
    <p>
    <?php echo "<?php
    echo \$this->Paginator->counter(array(
    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
    ));
    ?>"; ?>
    </p>

    <div class="pagination">
      <ul>
      <?php
        echo "<?php\n";
        echo "\t\techo \$this->Paginator->prev('< ' . __('previous'), array('tag' => 'li'), null, array('class' => 'prev disabled', 'tag' => 'li'));\n";
        echo "\t\techo \$this->Paginator->numbers(array('separator' => '', 'tag' => 'li'));\n";
        echo "\t\techo \$this->Paginator->next(__('next') . ' >', array('tag' => 'li'), null, array('class' => 'next disabled', 'tag' => 'li'));\n";
        echo "\t?>\n";
      ?>
      </ul>
    </div>
  </div>
</div>

<script>
jQuery(function() {
  current_page = $("div.pagination ul li.current").html();
  $('div.pagination ul li.current').addClass('active').html("<span>"+current_page+"</span>");

  var prev = $("li.prev");
  var prev_txt = $("li.prev").text();
  var new_prev = ($("li.prev").hasClass("disabled") == true) ? $("li.prev").html("<span>previous</span>") : prev.html();

  var next = $("li.next");
  var next_txt = $("li.next").text();
  var new_next = ($("li.next").hasClass("disabled") == true) ? $("li.next").html("<span>next</span>") : next.html();
});
</script>
