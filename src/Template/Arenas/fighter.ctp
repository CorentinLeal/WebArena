<?php
$this->Html->meta('description', 'Combattant', array('inline' => false));
?>

<div class="fighter form">
    <?= $this->Form->create($fighter) ?>
    <fieldset>
        <legend><?= __('Add a fighter') ?></legend>
        <?= $this->Form->input('nom') ?>
    </fieldset>
    <?= $this->Form->button(__('Add')); ?>
    <?= $this->Form->end() ?>
</div>


