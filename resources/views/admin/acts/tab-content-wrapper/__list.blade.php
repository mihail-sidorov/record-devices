<div class="tab-content-wrapper__list">
    @foreach ($acts as $act)
        <?php
            if ($act->type === 'give') {
                $type = 'Акт выдачи';
            }
            else {
                $type = 'Акт сдачи';
            }
        ?>
        <div class="tab-content-wrapper__list-item" id="{{ $act->id }}">
            <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $act->get_worker()->name }}">

            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">{{ $act->get_worker()->name }}</div>
            </div>
            <div class="tab-content-wrapper__list-item-body">
                <table class="tab-content-wrapper__list-item-body-table">
                    <thead>
                        <tr>
                            <td>Тип</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $type }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>