var defaultStartDate = '<?= request()->input('filter.payment_date_filter') ? (explode(' - ', urldecode(request()->input('filter.payment_date_filter')))[0] ?? $paymentDateMin) : $paymentDateMin ?>';
var defaultEndDate = '<?= request()->input('filter.payment_date_filter') ? (explode(' - ', urldecode(request()->input('filter.payment_date_filter')))[1] ?? $paymentDateMax) : $paymentDateMax ?>';
