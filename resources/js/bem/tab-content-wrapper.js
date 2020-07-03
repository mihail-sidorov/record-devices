$(document).ready(() => {
    $('.tab-content-wrapper').on('click', '.tab-content-wrapper__list-item-name', (e) => {
        $(e.currentTarget).toggleClass('tab-content-wrapper__list-item-name_show');
        $(e.currentTarget).closest('.tab-content-wrapper__list-item').children('.tab-content-wrapper__list-item-body').slideToggle();
    });

    // Реализуем фильтр
    function filter(changedElement){
        var $listItem = $(changedElement).closest('.tab-content-wrapper').find('>.tab-content-wrapper__list >.tab-content-wrapper__list-item'), $filterField = $(changedElement).closest('.tab-content-wrapper__filter').find('.tab-content-wrapper__filter-field');

        $listItem.each((index, element) => {
            var listItem = element, $listItemFilterField = $(element).find('>.tab-content-wrapper__list-item-filter-field');

            if ($listItemFilterField.length > 0) {
                $(listItem).show();

                $listItemFilterField.each((index, element) => {
                    if (!$(element).val().toLowerCase().replace('ё', 'е').match($($filterField[index]).val().toLowerCase().replace('ё', 'е'))) {
                        $(listItem).hide();
                        return false;
                    }
                });
            }
        });
    }
    $('.tab-content-wrapper__filter-field').each((index, element) => {
        $(element).val('');

        if ($(element)[0].tagName.toLowerCase() === 'input') {
            $(element).on('input', (e) => {
                filter(e.currentTarget);
            });
        }

        if ($(element)[0].tagName.toLowerCase() === 'select') {
            $(element).on('change', (e) => {
                filter(e.currentTarget);
            });
        }
    });
});