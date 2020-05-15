<div class="tab-content-wrapper">
    <div class="tab-content-wrapper__title">Фильтр:</div>    
    <div class="tab-content-wrapper__filter">
        <input class="tab-content-wrapper__filter-field" type="text" placeholder="Наименование">
    </div>

    <div class="tab-content-wrapper__title">Список:</div>
    <div class="tab-content-wrapper__list">
        @foreach ($departments as $department)
            <?php
                $description = $department->description;
                $description = str_replace("\r\n", '<br/>', $description);
                $description = str_replace("\r", '<br/>', $description);
                $description = str_replace("\n", '<br/>', $description);
            ?>
            <div class="tab-content-wrapper__list-item" id="{{ $department->id }}">
                <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $department->name }}">

                <div class="tab-content-wrapper__list-item-head">
                    <div class="tab-content-wrapper__list-item-name">{{ $department->name }}</div>
                    @include('edit-btn')
                    @include('del-btn')
                </div>
                <div class="tab-content-wrapper__list-item-body">
                    <table class="tab-content-wrapper__list-item-body-table">
                        <thead>
                            <tr>
                                <td>Описание</td>
                            </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><?php echo $description; ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>

    @include('add-btn')
</div>