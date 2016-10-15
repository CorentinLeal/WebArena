<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Tools'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Fighters'), ['controller' => 'Fighters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Fighter'), ['controller' => 'Fighters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tools form large-9 medium-8 columns content">
    <?= $this->Form->create($tool) ?>
    <fieldset>
        <legend><?= __('Add Tool') ?></legend>
        <?php
            echo $this->Form->input('type');
            echo $this->Form->input('bonus');
            echo $this->Form->input('coordinate_x');
            echo $this->Form->input('coordinate_y');
            echo $this->Form->input('fighter_id', ['options' => $fighters, 'empty' => true]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
