<div class="players form">
    <?= $this->Form->create($player) ?>
    <fieldset>
        <legend><?= __('Add a player') ?></legend>
        <?= $this->Form->input('email') ?>
        <?= $this->Form->input('password') ?>
    </fieldset>
    <?= $this->Form->button(__('Add')); ?>
    <?= $this->Form->end() ?>
</div>