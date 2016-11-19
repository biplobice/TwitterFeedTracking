<div class="phrases form large-9 medium-8 columns content">
    <?= $this->Form->create($phrase) ?>
    <fieldset>
        <legend><?= __('Add Phrase') ?></legend>
        <?php
            echo $this->Form->input('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
