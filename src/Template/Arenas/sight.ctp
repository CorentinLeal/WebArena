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
    if ($currentFighter){
        echo "<h1>Légende</h1>";
        echo "<p>F: Fighter | 0: Case Vide</p>";
        $posX = $currentFighter->coordinate_x;
        $posY = $currentFighter->coordinate_y;
        echo "<table>";
        for ($i = 0; $i < $height; $i++) {
            echo "<tr>";
            for ($j = 0; $j < $width; $j++) {
                echo "<td>";
                if ($j==$posX && $i==$posY){
                    echo "F";
                }else{
                    echo "0";
                }
                echo "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";



    }
    ?>

    <div class="move form">
        <?= $this->Form->create('Move') ?>
        <?= $this->Form->button('Left'); ?>
        <?= $this->Form->end() ?>
    </div>

</div>