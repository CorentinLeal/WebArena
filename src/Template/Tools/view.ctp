<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Tool'), ['action' => 'edit', $tool->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Tool'), ['action' => 'delete', $tool->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tool->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Tools'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tool'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Fighters'), ['controller' => 'Fighters', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Fighter'), ['controller' => 'Fighters', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="tools view large-9 medium-8 columns content">
    <h3><?= h($tool->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($tool->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fighter') ?></th>
            <td><?= $tool->has('fighter') ? $this->Html->link($tool->fighter->name, ['controller' => 'Fighters', 'action' => 'view', $tool->fighter->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($tool->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bonus') ?></th>
            <td><?= $this->Number->format($tool->bonus) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Coordinate X') ?></th>
            <td><?= $this->Number->format($tool->coordinate_x) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Coordinate Y') ?></th>
            <td><?= $this->Number->format($tool->coordinate_y) ?></td>
        </tr>
    </table>
</div>
