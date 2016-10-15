<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Surrounding'), ['action' => 'edit', $surrounding->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Surrounding'), ['action' => 'delete', $surrounding->id], ['confirm' => __('Are you sure you want to delete # {0}?', $surrounding->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Surroundings'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Surrounding'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="surroundings view large-9 medium-8 columns content">
    <h3><?= h($surrounding->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Type') ?></th>
            <td><?= h($surrounding->type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Coordinate Y') ?></th>
            <td><?= h($surrounding->coordinate_y) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($surrounding->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Coordinate X') ?></th>
            <td><?= $this->Number->format($surrounding->coordinate_x) ?></td>
        </tr>
    </table>
</div>
