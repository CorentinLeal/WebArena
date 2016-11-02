<div class="sight">

    <div class="fighter form">
        <?= $this->Form->create('ChooseFighter') ?>
        <fieldset>
            <legend><?php echo __('Choisissez un combattant.'); ?></legend>
            <?php echo $this->Form->input('ChooseFighter'); ?>
        </fieldset>
        <?= $this->Form->button(__('Choisir ce combattant')); ?>
        <?= $this->Form->end() ?>
    </div>

    <?php
    if ($currentFighter) {
        echo "<h1>Légende</h1>";
        echo "<p>F: Fighter | 0: Case Vide</p>";
        $posX = $currentFighter->coordinate_x;
        $posY = $currentFighter->coordinate_y;
        echo "<table>";
        for ($i = 0; $i < $height; $i++) {
            echo "<tr>";
            for ($j = 0; $j < $width; $j++) {
                echo "<td>";
                if ($j == $posX && $i == $posY) {
                    echo "F";
                } else {
                    echo "0";
                }
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        echo "<div class=\"move\">";
        echo "<div class=\"move left\">";
        echo $this->Form->create('MoveFighter');
        echo $this->Form->input('MoveLeft', array('default' => $currentFighter->name, 'type' => 'hidden'));
        echo $this->Form->button('Left');
        echo $this->Form->end();
        echo "</div>";

        echo "<div class=\"move right\">";
        echo $this->Form->create('MoveFighter');
        echo $this->Form->input('MoveRight', array('default' => $currentFighter->name, 'type' => 'hidden'));
        echo $this->Form->button('Right');
        echo $this->Form->end();
        echo "</div>";

        echo "<div class=\"move up\">";
        echo $this->Form->create('MoveFighter');
        echo $this->Form->input('MoveUp', array('default' => $currentFighter->name, 'type' => 'hidden'));
        echo $this->Form->button('Up');
        echo $this->Form->end();
        echo "</div>";

        echo "<div class=\"move down\">";
        echo $this->Form->create('MoveFighter');
        echo $this->Form->input('MoveDown', array('default' => $currentFighter->name, 'type' => 'hidden'));
        echo $this->Form->button('Down');
        echo $this->Form->end();
        echo "</div>";
        echo "</div>";


        echo "<div class=\"attack\">";
        echo "<div class=\"attack left\">";
        echo $this->Form->create('AttackLeft');
        echo $this->Form->input('AttackLeft', array('default' => $currentFighter->name, 'type' => 'hidden'));
        echo $this->Form->button('Attack Left');
        echo $this->Form->end();
        echo "</div>";

        echo "<div class=\"attack right\">";
        echo $this->Form->create('AttackRight');
        echo $this->Form->input('AttackRight', array('default' => $currentFighter->name, 'type' => 'hidden'));
        echo $this->Form->button('Attack Right');
        echo $this->Form->end();
        echo "</div>";

        echo "<div class=\"attack up\">";
        echo $this->Form->create('AttackUp');
        echo $this->Form->input('AttackUp', array('default' => $currentFighter->name, 'type' => 'hidden'));
        echo $this->Form->button('Attack Up');
        echo $this->Form->end();
        echo "</div>";

        echo "<div class=\"attack down\">";
        echo $this->Form->create('AttackDown');
        echo $this->Form->input('AttackDown', array('default' => $currentFighter->name, 'type' => 'hidden'));
        echo $this->Form->button('Attack Down');
        echo $this->Form->end();
        echo "</div>";
        echo "</div>";

    }
    ?>


</div>