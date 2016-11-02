<?php
$this->Html->meta('description', 'Combattant', array('inline' => false));
?>

<div class="panel">
    <div class="panel-heading">
        <div class="panel-title">
            <h2>Gestion des combattants</h2></div>
    </div>
    <div class="panel-body">
        <div class="row corps">

            <div class="fighter form">
                <?= $this->Form->create('FighterChoose') ?>
                <fieldset>
                    <legend><?php echo __('Choisissez un combattant à afficher.'); ?></legend>
                    <?php echo $this->Form->input('choix'); ?>
                </fieldset>
                <?= $this->Form->button(__('Voir ce combattant')); ?>
                <?= $this->Form->end() ?>
            </div>

            <div class="fighter form">
                <?= $this->Form->create('FighterCreate') ?>
                <fieldset>
                    <legend><?= __('Créer un combattant') ?></legend>
                    <?= $this->Form->input('nom') ?>
                </fieldset>
                <?= $this->Form->button(__('Creer')); ?>
                <?= $this->Form->end() ?>
            </div>

        </div>


        <?php
        if ($fighter) {
            ?>
            <hr/>

            <div class="statsPerso">
                <h1>
                    <?php
                    echo ' Nom du combattant : ' . $fighter->name;
                    ?>
                </h1>

                <h2>
                    <?php
                    echo ' Level : ' . $fighter->level;
                    ?>
                </h2>
                <?php
                echo '
                                     <div class="vie">HP (' . $fighter->current_health . '/' .
                $fighter->skill_health . ')
        </div>
        </br>

        <div class="xp">XP (' . $fighter->xp . '/4)</div>
    </div>
</div></br>
<p> force : ' . $fighter->skill_strength . '</p>
<p> vue : ' . $fighter->skill_sight . '</p>
<p>coord x : ' . $fighter->coordinate_x . '</p>
coord y : ' . $fighter->coordinate_y;
                ?>


                <div class="row corps">
                    <div class="levelUp">

                        <?php
                        if ($canLevelUp) {


                            echo $this->Form->create('FighterLevelUpStrength');
                            echo $this->Form->input('LevelUpStrength', array('default' => $fighter->name, 'type' => 'hidden'));
                            echo $this->Form->button(__('Augmenter Force'));
                            echo $this->Form->end();

                            echo $this->Form->create('FighterLevelUpSight');
                            echo $this->Form->input('LevelUpSight', array('default' => $fighter->name, 'type' => 'hidden'));
                            echo $this->Form->button(__('Augmenter Vision'));
                            echo $this->Form->end();

                            echo $this->Form->create('FighterLevelUpHealth');
                            echo $this->Form->input('LevelUpHealth', array('default' => $fighter->name, 'type' => 'hidden'));
                            echo $this->Form->button(__('Augmenter Santé'));
                            $this->Form->end();
                        }


                        echo $this->Form->create('FighterKill');
                        echo $this->Form->input('supprimer', array('default' => $fighter->name, 'type' => 'hidden'));
                        echo $this->Form->button(__('Supprimer'));
                        echo $this->Form->end()
                        ?>
                    </div>
                </div>
            <?php }
            ?>