[33mcommit 1be60c71d0f83f64a861e1dbe9d71bdf2ca045d6[m
Author: MaksimovGleb <maksimow.gleb@yandex.ru>
Date:   Mon Jul 17 15:10:30 2023 +0300

    спрятал рассрочку

[1mdiff --git a/resources/views/design-2022/pages/orders/partials/orders-table-user.blade.php b/resources/views/design-2022/pages/orders/partials/orders-table-user.blade.php[m
[1mindex 605694a0..655a77cd 100644[m
[1m--- a/resources/views/design-2022/pages/orders/partials/orders-table-user.blade.php[m
[1m+++ b/resources/views/design-2022/pages/orders/partials/orders-table-user.blade.php[m
[36m@@ -32,15 +32,18 @@[m
                             </td>[m
                             <td>[m
                                 <div class="table__caption">Обращение:</div>[m
[31m-                                @if ($task = $order->task()?->first())[m
[31m-                                    @can('view',$task)[m
[32m+[m[32m                                @forelse($order->purchases()->where("item_type", App\Models\Payment\Service::class)->get() as $purchase)[m
[32m+[m[32m                                    @if ($task = $purchase->task())[m
[32m+[m[32m                                        @can('view',$task)[m
                                         <a href="{{ route('tasks.show', $task) }}" class="table__value green">{{ $task->subject }} </a>[m
[31m-                                    @else[m
[31m-                                        {{ $task->subject }}[m
[31m-                                    @endcan[m
[31m-                                @else[m
[32m+[m[32m                                        @else[m
[32m+[m[32m                                            <div class="table__value">{{Str::limit(strip_tags ($task->subject), 30)}}</div>[m
[32m+[m[32m                                        @endcan[m
[32m+[m[32m                                        <br>[m
[32m+[m[32m                                    @endif[m
[32m+[m[32m                                @empty[m
                                     <div class="table__value">Нет </div>[m
[31m-                                @endif[m
[32m+[m[32m                                @endforelse[m
                             </td>[m
                             <td>[m
                                 <div class="table__caption">Описание:</div>[m
[1mdiff --git a/resources/views/pages/orders/partials/orders-table-admin.blade.php b/resources/views/pages/orders/partials/orders-table-admin.blade.php[m
[1mindex 179e4419..502d5e85 100644[m
[1m--- a/resources/views/pages/orders/partials/orders-table-admin.blade.php[m
[1m+++ b/resources/views/pages/orders/partials/orders-table-admin.blade.php[m
[36m@@ -37,7 +37,7 @@[m
                         <td>{{ $order->user->FullName }}</td>[m
                         <td>{{ $order->description }}</td>[m
                         <td>[m
[31m-                            @foreach($order->purchases()->where("item_type", App\Models\Payment\Service::class)->get() as $purchase)[m
[32m+[m[32m                            @forelse($order->purchases()->where("item_type", App\Models\Payment\Service::class)->get() as $purchase)[m
                                 @if ($task = $purchase->task())[m
                                     @can('view',$task)[m
                                         <a href="{{route('tasks.show', $task)}}">{{Str::limit(strip_tags ($task->subject), 30)}}</a>[m
[36m@@ -46,7 +46,9 @@[m
                                     @endcan[m
                                     <br>[m
                                 @endif[m
[31m-                            @endforeach[m
[32m+[m[32m                            @empty[m
[32m+[m[32m                                Нет[m
[32m+[m[32m                            @endforelse[m
                         </td>[m
                         <td>{{ $order->created_at }}</td>[m
                         <td>{{ $order->amount }} р.</td>[m
[1mdiff --git a/resources/views/pages/tasks/partials/service-plan-installment.blade.php b/resources/views/pages/tasks/partials/service-plan-installment.blade.php[m
[1mindex 6097c8f3..63578a65 100644[m
[1m--- a/resources/views/pages/tasks/partials/service-plan-installment.blade.php[m
[1m+++ b/resources/views/pages/tasks/partials/service-plan-installment.blade.php[m
[36m@@ -38,17 +38,17 @@[m
                                     </a>[m
                                 </div>[m
                             </div>[m
[31m-                            <h5 class="text-muted">Оплата услуги в рассрочку:</h5>[m
[32m+[m[32m{{--                            <h5 class="text-muted">Оплата услуги в рассрочку:</h5>--}}[m
 [m
[31m-                            <div class="form-group">[m
[31m-                                <div class="mb-3">[m
[31m-                                    @can('create', [\App\Models\Payment\Installment::class, $task])[m
[31m-                                        <a href="{{ route('installments.create', $task) }}" type="submit" class="btn btn-success btn-sm col-sm-12 col-9">[m
[31m-                                            <i class="fas fa-plus"></i> Создать рассрочку для услуги прикрепленной к обращению[m
[31m-                                        </a>[m
[31m-                                    @endcan[m
[31m-                                </div>[m
[31m-                            </div>[m
[32m+[m[32m{{--                            <div class="form-group">--}}[m
[32m+[m[32m{{--                                <div class="mb-3">--}}[m
[32m+[m[32m{{--                                    @can('create', [\App\Models\Payment\Installment::class, $task])--}}[m
[32m+[m[32m{{--                                        <a href="{{ route('installments.create', $task) }}" type="submit" class="btn btn-success btn-sm col-sm-12 col-9">--}}[m
[32m+[m[32m{{--                                            <i class="fas fa-plus"></i> Создать рассрочку для услуги прикрепленной к обращению--}}[m
[32m+[m[32m{{--                                        </a>--}}[m
[32m+[m[32m{{--                                    @endcan--}}[m
[32m+[m[32m{{--                                </div>--}}[m
[32m+[m[32m{{--                            </div>--}}[m
                         @endif[m
                     @endif[m
                 </h4>[m
