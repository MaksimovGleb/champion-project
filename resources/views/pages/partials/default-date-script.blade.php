var defaultStartDate = '<?= request()->input('filter.date_filter') ? (explode(' - ', urldecode(request()->input('filter.date_filter')))[0] ?? $dateMin) : $dateMin ?>';
var defaultEndDate = '<?= request()->input('filter.date_filter') ? (explode(' - ', urldecode(request()->input('filter.date_filter')))[1] ?? $dateMin) : $dateMax ?>';
