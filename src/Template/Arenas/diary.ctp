<?php
$this->Html->meta('description', 'Journal', array('inline' => false));
?>


<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">
            <h2>Journal des événements</h2>
        </div>
    </div>
    <div class="panel-body">
        <div class="row-corps">
            <div class="fighter form">
                <?= $this->Form->create('FighterChoose') ?>
                <fieldset>
                    <legend><?php echo __('Choisissez le combattant dont vous voulez afficher le Journal'); ?></legend>
                    <?php echo $this->Form->input('choix'); ?>
                </fieldset>
                <?= $this->Form->button(__('Journal du combattant')); ?>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <?php
        if ($fighter) {
            ?>
        <div class="histoPerso">
            <h1>
                <?php
                    echo ' Nom du combattant : ' . $fighter->name;
                ?>
            </h1>

            <table>
                <thead>
                    <tr>
                        <td>Nom</td>
                        <td>Date</td>
                        <td>Coordonnée en X</td>
                        <td>Coordonnée en Y</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>bla</td>
                        <td>blabla</td>
                        <td>kkX</td>
                        <td>kkY</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
            }
        ?>

    </div>

    <?php if($event) { ?>
        <p><?php
                    echo ' Nom de evenement : ' . $event->name;
            ?></p>
    <?php } ?>
</div>