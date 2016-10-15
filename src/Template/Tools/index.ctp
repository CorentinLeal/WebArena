<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Tool'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Fighters'), ['controller' => 'Fighters', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Fighter'), ['controller' => 'Fighters', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tools index large-9 medium-8 columns content">
    <h3><?= __('Tools') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bonus') ?></th>
                <th scope="col"><?= $this->Paginator->sort('coordinate_x') ?></th>
                <th scope="col"><?= $this->Paginator->sort('coordinate_y') ?></th>
                <th scope="col"><?= $this->Paginator->sort('fighter_id') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tools as $tool): ?>
            <tr>
                <td><?= $this->Number->format($tool->id) ?></td>
                <td><?= h($tool->type) ?></td>
                <td><?= $this->Number->format($tool->bonus) ?></td>
                <td><?= $this->Number->format($tool->coordinate_x) ?></td>
                <td><?= $this->Number->format($tool->coordinate_y) ?></td>
                <td><?= $tool->has('fighter') ? $this->Html->link($tool->fighter->name, ['controller' => 'Fighters', 'action' => 'view', $tool->fighter->id]) : '' ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $tool->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tool->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $tool->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tool->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
