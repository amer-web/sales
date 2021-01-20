$(function () {

    $('#formData').on('submit', function (e) {
        $('.sale_price').each(function () {
            $(this).rules("add", {required: true})
        });
        $('.amount').each(function () {
            $(this).rules("add", {required: true})
        });
        $('.products').each(function () {
            $(this).rules("add", {required: true})
        });
        e.preventDefault();
    });
    $('#formData').validate({
        rules: {
            'client_id': {required: true},
            'supplier_id':{required:true},
            'invoice_date': {required: true, date: true},
            'paid': {number: true, min: 1},
            'discount': {number: true, min: 0},
            'vat': {number: true, min: 0, max: 100},
            'due_date' : {date:true},
        },
        submitHandler: function (form) {
            form.submit();
        },
    });

    /* plugin select 2 */


    /* plugin of dateTime */
    $('#checkin').datetimepicker({
        rtl: true,
        format: 'Y-m-d',
        formatTime: false,
        formatDate: 'd-m-Y',
        timepicker: false,
        closeOnDateSelect: true,
    });
    $('input[name="due_date"]').datetimepicker({
        rtl: true,
        format: 'Y-m-d',
        formatTime: false,
        formatDate: 'd-m-Y',
        timepicker: false,
        minDate: true,
        closeOnDateSelect: true,
    });

    $('tbody').on('keyup', '.sale_price, .amount', function () {
        let $row = $(this).closest('tr');
        let salePriceOrAmount = $(this).val() == '' ? 0 : $(this).val();
        var input1 = parseFloat(salePriceOrAmount);

        if ($(this).data('info') == 'sale_price') {
            var inputAmount = $row.find('.amount').val();
            let amount = (inputAmount == '') ? 0 : inputAmount;
            var input2 = parseFloat(amount);
            var total = input1 * input2;

        } else {
            var inputPrice = $row.find('.sale_price').val();
            let price = (inputPrice == '') ? 0 : inputPrice;
            var input2 = parseFloat(price);
            var total = input1 * input2;
        }
        $row.find('.total').text(total.toFixed(2));
        sumPrice();
        if ($('input[name="discount"]').val() != '') {
            $('input[name="discount"]').change();
        }
        calculateVat();
        dueTotal();
    });
    $("#formData").on('change', 'input[name="discount"]', function () {
        let discount = parseFloat($(this).val());

        if (discount <= 0 || $(this).val() == '' || $('.sum-total').text() == '' || $('.sum-total').text() == 0) {
            $('#discount-row').remove();
            $('#rowPriceTotal').remove();
        } else {
            $('#discount-row').remove();
            $('#rowPriceTotal').remove();
            $('#info-total').after('<tr id="discount-row">\n' +
                ' <td colspan="2" ></td>\n' +
                '  <td class="text-left">الخصم</td>\n' +
                '        <td id="price-discount"></td>\n' +
                ' </tr>');
            $('#price-discount').text((-1 * discount).toFixed(2));
            if (!$('#totalRat').length) {

                appendRowTotal('#discount-row', "totalPriceWithoutPaid", "rowPriceTotal", "الإجمالى");
            }

        }
        if (!$('#totalRat').length) {
            let totalPrice = parseFloat($('.sum-total').text()),
                totalAfterDiscount = totalPrice - discount;
            $('#totalPriceWithoutPaid').text(totalAfterDiscount.toFixed(2));
        }
        calculateVat();
        $('input[name="paid"]').change();

    });

    var sumTotal = 0;
    var sumPrice = function () {
        $('td.total').each(function () {
            sumTotal += parseFloat($(this).text());
        });
        $(".sum-total").text(sumTotal.toFixed(2));
        sumTotal = 0;
    }
    let appendRowTotal = function (selector, definePrice, defineRow, text) {
        $(selector).after('<tr id=' + defineRow + '>\n' +
            ' <td colspan="2" ></td>\n' +
            '  <td class="text-left">' + text + '</td>\n' +
            '  <td id=' + definePrice + '></td>\n' +
            '  </tr>');
    }
    let calculateVat = function () {
        $('#totalRat').remove();
        let ratVat = $('input[name="vat"]').val() == '' ? 0 : parseFloat($('input[name="vat"]').val());
        let sumPriceOfAmount = $('.sum-total').text() == '' ? 0 : parseFloat($('.sum-total').text());
        let textVat = "ضـريبـة (" + ratVat + " %)";
        if ($('#price-discount').length) {
            if (ratVat > 0) {
                $('#rowPriceTotal').remove();
                let priceDiscount = parseFloat($('#price-discount').text());
                appendRowTotal('#discount-row', 'ratVat', 'totalRat', textVat);
                let rateVatAfterDiscount = ((sumPriceOfAmount + priceDiscount) * ratVat) / 100;
                $('#ratVat').text(rateVatAfterDiscount.toFixed(2));
                appendRowTotal('#totalRat', 'totalPriceWithoutPaid', 'rowPriceTotal', 'الإجمالى');
                let totalAfterDiscountAndVat = (sumPriceOfAmount + priceDiscount) + rateVatAfterDiscount
                $('#totalPriceWithoutPaid').text(totalAfterDiscountAndVat.toFixed(2));
            }
        } else {
            if (ratVat != 0 && sumPriceOfAmount > 0) {
                $('#rowPriceTotal').remove();
                let priceVat = (sumPriceOfAmount * ratVat) / 100;
                let totalPriceWithVat = sumPriceOfAmount + priceVat;
                appendRowTotal('#info-total', 'ratVat', 'totalRat', textVat);
                $('#ratVat').text(priceVat.toFixed(2));
                if (!$('#price-discount').length) {
                    appendRowTotal('#totalRat', 'totalPriceWithoutPaid', 'rowPriceTotal', 'الإجمالى');
                    $('#totalPriceWithoutPaid').text(totalPriceWithVat.toFixed(2));
                }
            }
        }
    }

    $('input[name="vat"]').on('change', function () {
        calculateVat();
        $('input[name="discount"]').change();
        dueTotal();
    });

    let dueTotal = function () {
        let paidPrice = $('input[name="paid"]').val() == '' ? 0 : $('input[name="paid"]').val();
        $('#paid').remove();
        $('#dueRow').remove();
        if (paidPrice > 0) {
            if ($('#info-total').length && parseFloat($('.sum-total').text()) > 0 && !$('#rowPriceTotal').length) {
                let totalDue = parseFloat($('.sum-total').text()) - paidPrice;
                appendRowTotal('#info-total', 'paidPriceRow', 'paid', 'المبلغ المدفوع');
                appendRowTotal('#paid', 'priceDue', 'dueRow', 'المبلغ المستحق');
                $('#paidPriceRow').text(parseFloat(-paidPrice).toFixed(2));
                $('#priceDue').text(parseFloat(totalDue).toFixed(2));
            }
            if ($('#rowPriceTotal').length && parseFloat($('#totalPriceWithoutPaid').text()) > 0) {
                let totalDue = parseFloat($('#totalPriceWithoutPaid').text()) - paidPrice;
                appendRowTotal('#rowPriceTotal', 'paidPriceRow', 'paid', 'المبلغ المدفوع');
                appendRowTotal('#paid', 'priceDue', 'dueRow', 'المبلغ المستحق');
                $('#paidPriceRow').text(parseFloat(-paidPrice).toFixed(2));
                $('#priceDue').text(parseFloat(totalDue).toFixed(2));
            }

        }
    };

    $('input[name="paid"]').on('change', function () {
        dueTotal();
    });

    $('#formData').on('click', '.close-row', function () {
        let $rowClose = $(this).closest('tr');
        $rowClose.remove();
        $('.amount').keyup();
        $('.sale_price').keyup();
        calculateVat();
        $('input[name="discount"]').change();
        $('input[name="paid"]').change();
    });


});
