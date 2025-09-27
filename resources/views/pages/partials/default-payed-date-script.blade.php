var defaultStartPayedAt = '<?= request()->input('filter.payed_at_filter') ? (explode(' - ', urldecode(request()->input('filter.payed_at_filter')))[0] ?? $payedAtMin) : $payedAtMin?>';
var defaultEndPayedAt = '<?= request()->input('filter.payed_at_filter') ? (explode(' - ', urldecode(request()->input('filter.payed_at_filter')))[1] ?? $payedAtMax) : $payedAtMax ?>';

