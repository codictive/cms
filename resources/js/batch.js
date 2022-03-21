(function () {
    'use strict';

    const form = $('#batch-form');
    if (!form || !form.length) {
        return;
    }

    form.find('#action').on('change', function (e) {
        const item = $(this);
        const value = item.val();
        if (value == '') {
            return;
        }

        if (value == 'delete') {
            if (!confirm('موارد انتخاب شده برای همیشه حذف می‌شوند. این عمل قابل بازگشت نیست. ادامه می‌دهید؟')) {
                e.preventDefault();
                item.val('').trigger('change');
                return;
            }
        }

        form.trigger('submit');
    });

    form.find('#checkAll').on('change', function () {
        $(this).is(':checked') ? form.find('input[name="batch[]"]').prop('checked', true) : form.find('input[name="batch[]"]').prop('checked', false);
    });
})();
