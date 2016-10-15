<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Surrounding'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="surroundings index large-9 medium-8 columns content">
    <h3><?= __('Surroundings') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('type') ?></th>
                <th scope="col"><?= $this->Paginator->sort('coordinate_x') ?></th>
                <th scope="col"><?= $this->Paginator->sort('coordinate_y') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($surroundings as $surrounding): ?>
            <tr>
                <td><?= $this->Number->format($surrounding->id) ?></td>
                <td><?= h($surrounding->type) ?></td>
                <td><?= $this->Number->format($surrounding->coordinate_x) ?></td>
                <td><?= h($surrounding->coordinate_y) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $surrounding->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $surrounding->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $surrounding->id], ['confirm' => __('Are you sure you want to delete # {0}?', $surrounding->id)]) ?>
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
