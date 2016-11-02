<div class="players form">
    <?= $this->Flash->render('auth') ?>
    <?= $this->Form->create('Login') ?>
    <fieldset>
        <legend><?= __("Please enter your email and password") ?></legend>
        <?= $this->Form->input('email') ?>
        <?= $this->Form->input('password') ?>
    </fieldset>
    <?= $this->Form->button('Login'); ?>
    <?= $this->Form->end() ?>

    <div class="panel-body">
        <p>
            Si tu n'es pas encore inscrit : 
        <?php echo $this->Html->link('Clique ici', array('controller' => 'Players', 'action' => 'add'), array('class' => 'btn')) ?> <br/>
        </p>
        
    </div>
</div>