<!doctype html>
<html lang="ar" >
<head>
    <meta charset="utf-8">
    <title>فاتورة رقم {{$invoice_id}} للعميل {{$client}}</title>

    <style>

        body{
            font-family: 'XBRiyaz',sans-serif;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'XBRiyaz',sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }

        /** RTL **/
        .rtl {
            direction: rtl;
            font-family: 'XBRiyaz',sans-serif;

        }

        .rtl table {
            text-align: right;
        }

        .rtl table tr td:nth-child(2) {
            text-align: right;
        }
        @page {
            header: page-header;
            footer: page-footer;
        }
    </style>
</head>

<body>
<htmlpageheader name="page-header">
شركة المصرية للاستيراد والتصدير
</htmlpageheader>
<htmlpagefooter name="page-footer">
طبعت فى {{$created_at}}
</htmlpagefooter>

<div class="invoice-box rtl">
    <table cellpadding="0" cellspacing="0" >
        <tr class="top">
            <td colspan="5">
                <table>
                    <tr>
                        <td class="title" width="69%">
                            <h4>فاتورة بيع</h4>
                        </td>

                        <td>
                            فاتورة رقم : {{$invoice_id}}<br>
                             تاريخ الإصدار : {{$invoice_date}}<br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="5">
                <table style="line-height: 2">
                    <tr>
                        <td>
                            شركة المصرية للإستيراد والتصدير <br>
                            قنا - قوص - ش الجمهورية <br>
                            تليفون : 01112795101 <br>
                            البريد الإلكترونى : amer_gmail@yahoo.com
                        </td>

                        <td>
                             فاتورة للعميل :{{$client}} <br>
                            العنوان : {{$address}}<br>
                             التليفون : {{$phone}} <br>
                        </td>

                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading ">
            <td width="10%">
                #
            </td>

            <td width="30%">
                الصنف
            </td>
            <td width="20%">
                سعر الوحدة
            </td>
            <td width="25%">
                الكمية
            </td>
            <td width="15%">
                المجموع
            </td>
        </tr>
        @foreach($items as $item)
        <tr class="item">
            <td>
               {{$loop->iteration}}
            </td>
            <td>
                {{$item['product_name']}}
            </td>
            <td>
               {{$item['sale_price']}}
            </td>
            <td>
                {{$item['amount']}}
            </td>

            <td>
                {{$item['total']}}
            </td>
        </tr>
        @endforeach


        <tr class="item last">
            <td colspan="3"></td>
            <td style="text-align: center">
                الإجمالى
            </td>

            <td>
                {{$total_price}}
            </td>
        </tr>
        @if($discount != 0)
        <tr class="item last">
            <td colspan="3"></td>
            <td style="text-align: center">
                الخصم
            </td>

            <td>
                - {{$discount}}
            </td>
        </tr>
        @endif
        @if($value_rate != 0 && $vat != 0)
            <tr class="item last">
                <td colspan="3"></td>
                <td style="text-align: center">
                    ضريبة ({{$vat}} %)
                </td>

                <td>
                     {{$value_rate}}
                </td>
            </tr>
        @endif
        @if($value_rate != 0 || $vat != 0)
            <tr class="item last">
                <td colspan="3"></td>
                <td style="text-align: center">
                    الإجمالى
                </td>

                <td>
                     {{$total_due}}
                </td>
            </tr>
        @endif
        @if($total_refund > 0)
            <tr class="item last">
                <td colspan="3"></td>
                <td style="text-align: center">
                    مرتجع
                </td>

                <td>
                     {{$total_refund}}
                </td>
            </tr>
        @endif
        <tr class="item last">
            <td colspan="3"></td>
            <td style="text-align: center">
                المبلغ المدفوع
            </td>

            <td>
                {{number_format($paid,2) }}
            </td>
        </tr>

        <tr class="total">
            <td colspan="3"></td>
            <td style="text-align: center">المبلغ المستحق</td>

            <td>
                 {{number_format($paid_due,2) }}
            </td>
        </tr>
    </table>
</div>
</body>
</html>
