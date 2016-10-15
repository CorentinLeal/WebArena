<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $guild->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $guild->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Guilds'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Fighters'), ['controller' => 'Fighters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Fighter'), ['controller' => 'Fighters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="guilds form large-9 medium-8 columns content">
    <?= $this->Form->create($guild) ?>
    <fieldset>
        <legend><?= __('Edit Guild') ?></legend>
        <?php
            echo $this->Form->input('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
