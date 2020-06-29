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

            <div class="tab-content-wrapper__list-item-head upload-act-controller">
                <div class="tab-content-wrapper__list-item-name">{{ $act->get_worker()->name }}</div>
                @include('btns.open-act-btn', ['id' => $act->id])
                @if ($act->document === null)
                    @include('btns.upload-act-btn')
                @else
                    @include('btns.download-act-btn', ['id' => $act->id])
                @endif
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