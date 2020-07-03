<div class="tab-content-wrapper__list">
    @foreach ($acts as $act)
        <?php
            if ($act->type === 'give') {
                $type = 'Акт выдачи';
            }
            else {
                $type = 'Акт сдачи';
            }

            $no_original_act = ($act->document === null ? ' no-original-act' : '');
        ?>
        <div class="tab-content-wrapper__list-item{{ $no_original_act }}" id="{{ $act->id }}">
            <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $act->get_worker()->name }}">

            <div class="tab-content-wrapper__list-item-head act-controller">
                <div class="tab-content-wrapper__list-item-name">{{ $act->get_worker()->name }}</div>
                @if ($act->document === null)
                    @if (Auth::user()->role === 'admin')
                        @include('btns.open-act-btn', ['id' => $act->id])
                        @include('btns.upload-act-btn')
                    @endif
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