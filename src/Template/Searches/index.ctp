<div class="searches index large-9 medium-8 columns content">
    <h3><?= __('Searches') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('id') ?></th>
                <th><?= $this->Paginator->sort('phrase_id') ?></th>
                <th><?= $this->Paginator->sort('count') ?></th>
                <th><?= $this->Paginator->sort('created') ?></th>
                <th class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($searches as $search): ?>
            <tr>
                <td><?= $this->Number->format($search->id) ?></td>
                <td><?= $search->has('phrase') ? $this->Html->link($search->phrase->name, ['controller' => 'Phrases', 'action' => 'view', $search->phrase->id]) : '' ?></td>
                <td><?= $this->Number->format($search->count) ?></td>
                <td><?= h($search->created) ?></td>
                <td class="actions">
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $search->id], ['confirm' => __('Are you sure you want to delete # {0}?', $search->id)]) ?>
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
