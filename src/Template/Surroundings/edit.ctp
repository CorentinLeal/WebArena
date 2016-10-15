<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $surrounding->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $surrounding->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Surroundings'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="surroundings form large-9 medium-8 columns content">
    <?= $this->Form->create($surrounding) ?>
    <fieldset>
        <legend><?= __('Edit Surrounding') ?></legend>
        <?php
            echo $this->Form->input('type');
            echo $this->Form->input('coordinate_x');
            echo $this->Form->input('coordinate_y');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
