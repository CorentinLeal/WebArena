<div class="players form">
    <?= $this->Flash->render('auth') ?>
    <?= $this->Form->create('Login') ?>
    <fieldset>
        <legend><?= __("Please enter your email and password") ?></legend>
        <?= $this->Form->input('email') ?>
        <?= $this->Form->input('password') ?>
    </fieldset>
    <?= $this->Form->button('Login', array('class' => 'btn btn-primary subbtn')); ?>
    <?= $this->Form->end() ?>
</div>