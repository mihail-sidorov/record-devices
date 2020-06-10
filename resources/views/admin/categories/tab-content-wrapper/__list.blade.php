<div class="tab-content-wrapper__list">
    @foreach ($categories as $category)
        <?php
            $description = $category->description;
            $description = str_replace("\r\n", '<br/>', $description);
            $description = str_replace("\r", '<br/>', $description);
            $description = str_replace("\n", '<br/>', $description);
        ?>
        <div class="tab-content-wrapper__list-item" id="{{ $category->id }}">
            <input type="hidden" class="tab-content-wrapper__list-item-filter-field" value="{{ $category->name }}">

            <div class="tab-content-wrapper__list-item-head">
                <div class="tab-content-wrapper__list-item-name">{{ $category->name }}</div>
                @include('btns.edit-btn')
                @include('btns.del-btn')
            </div>
            <div class="tab-content-wrapper__list-item-body">
                <table class="tab-content-wrapper__list-item-body-table">
                    <thead>
                        <tr>
                            <td>Описание</td>
                            <td>Остаток на складе</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo $description; ?></td>
                            <td><?php echo $category->get_store_count(); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>