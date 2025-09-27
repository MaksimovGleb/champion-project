<?php

declare(strict_types=1);

return [
    'action_types' => [
        'installment' => 'Рассрочка',
        'task' => 'Обращение',
        'user' => 'Пользователь',
    ],
    'properties' => [
        'prepayment' => 'Предоплата',
        'months_numbers' => 'Количество месяцев',
        'index' => 'номер платежа',
        'status' => 'Статус',
    ],
    'installment' => [
        'create_installment' => 'Создал(а) рассрочку',
        'update_installment' => 'Изменил(а) рассрочку',
        'delete_installment' => 'Удалил(а) рассрочку',
        'set_status_payment_installment' => 'Изменил(а) статус платежа рассрочки',
    ],
    'user' => [
        'create' => 'Добавил(а) сотрудника',
        'update' => 'Изменил(а) профиль сотрудника :subject.name',
        'delete' => 'Уволил(а) сотрудника :subject.name',
        'restore' => 'Вернул(а) сотрудника :subject.name',
        'update_avatar' => 'Добавил(а) аватар',
        'delete_avatar' => 'Удалил(а) аватар',
        'reset_password' => 'Сбросил(а) пароль',
        'update_password' => 'Обновил(а) пароль',
        'login' => ':subject.name авторизовался(ась)',
        'logout' => ':subject.name вышел(ла) из системы',
    ],
];
