<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Messages'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Fighters'), ['controller' => 'Fighters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Fighter'), ['controller' => 'Fighters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="messages form large-9 medium-8 columns content">
    <?= $this->Form->create($message) ?>
    <fieldset>
        <legend><?= __('Add Message') ?></legend>
        <?php
            echo $this->Form->input('date');
            echo $this->Form->input('title');
            echo $this->Form->input('message');
            echo $this->Form->input('fighter_id_from');
            echo $this->Form->input('fighter_id', ['options' => $fighters]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
