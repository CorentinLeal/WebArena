<?php
$this->Html->meta('description', 'Combattant', array('inline' => false));
?>

<div class="panel panel-info">
    <div class="panel-heading">
        <div class="panel-title">
            <h2>Gestion des combattants</h2></div>
    </div>
    <div class="panel-body">
        <div class="row top-buffer">
            <div class="col-xs-12 col-md-12 col-lg-12 ">

                <div class="col-md-offset-1 col-lg-offset-1 col-xs-12 col-sm-12 col-md-10 col-lg-10">

                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

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
                                <legend><?= __('Ajouter un fighter') ?></legend>
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

                        <div id="fighterDisplay" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 jumbotron">

                            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
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
                                     <div class="col-xs-2 col-md-2 col-lg-2">HP (' . $fighter->current_health . '/' . $fighter->skill_health . ')
                                     </div>
                                     
                                      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="' . $fighter->current_health . '" aria-valuemin="0" aria-valuemax="' . $fighter->skill_health . '" style="width: ' . ((($fighter->current_health) / ($fighter->skill_health)) * 100) . '%">
                                     
                                     </div>
                                        </div>
                                        <div class="col-xs-2 col-md-2 col-lg-2">XP (' . $fighter->xp . '/4)</div>
                                        </div>
                                        </div>
                                          force : 
                                      <div class="col-xs-3 col-md-3 col-lg-3 fa fa-gavel fa-3x" id="gavelIcon">' . $fighter->skill_strength . '</div> 
                                          vue :
                                      <div class="col-xs-3 col-md-3 col-lg-3 fa fa-eye fa-3x" id="eyeIcon">' . $fighter->skill_sight . '</div> 
                                          coord x :
                                      <div class="col-xs-3 col-md-3 col-lg-3 fa fa-arrows-h fa-3x" id="arrowIcon">' . $fighter->coordinate_x . '</div> 
                                          coord y :
                                      <div class="col-xs-3 col-md-3 col-lg-3 fa fa-arrows-v fa-3x" id="arrowIcon">' . $fighter->coordinate_y . '</div>';
                                ?>


                                <div class="row top-buffer">
                                    <div class="col-xs-12 col-md-12 col-lg-12">

                                        <?php
                                        if ($canLevelUp) {


                                            echo $this->Form->create('FighterLevelUpStrength');
                                            echo $this->Form->input('FighterLevelUpStrength', array('default' => $fighter->name, 'type' => 'hidden'));
                                            echo $this->Form->button(__('Augmenter Force'));
                                            $this->Form->end();

                                            echo $this->Form->create('FighterLevelUpSight');
                                            echo $this->Form->input('FighterLevelUpSight', array('default' => $fighter->name, 'type' => 'hidden'));
                                            echo $this->Form->button(__('Augmenter Vision'));

                                            $this->Form->end();

                                            echo $this->Form->create('FighterLevelUpHealth');
                                            echo $this->Form->input('FighterLevelUpHealth', array('default' => $fighter->name, 'type' => 'hidden'));
                                            echo $this->Form->button(__('Augmenter Santé'));
                                            $this->Form->end();
                                        }



                                        echo $this->Form->create('FighterKill');
                                        echo $this->Form->input('supprimer', array('default' => $fighter->name, 'type' => 'hidden'));
                                        echo $this->Form->button(__('Supprimer'));
                                        ?>
                                        <?= $this->Form->end()
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }?>