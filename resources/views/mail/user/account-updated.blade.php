@extends('mail.layout')
@section('content')
    <table cellpadding="0" cellspacing="0" class="es-header" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
        <tr>
            <td align="center" style="padding:0;Margin:0">
                <table bgcolor="#ffffff" class="es-header-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px">
                    <tr>
                        <td align="left" style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:20px">
                            <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                <tr>
                                    <td class="es-m-p0r" valign="top" align="center" style="padding:0;Margin:0;width:560px">
                                        <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tr>
                                                <td align="center" style="padding:0;Margin:0;padding-bottom:20px;font-size:0px">
                                                    <img src="https://myurist.online/assets/templates/web_tpl/images/logo.svg"
                                                         alt="Logo" style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;font-size:12px" width="200" title="Logo">
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
{{--    <img src="" alt="">--}}
    <table cellpadding="0" cellspacing="0" class="es-content" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
        <tr>
            <td align="center" style="padding:0;Margin:0">
                <table bgcolor="#ffffff" class="es-content-body" align="center" cellpadding="0" cellspacing="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#FFFFFF;width:600px">
                    <tr>
                        <td align="left" style="padding:0;Margin:0;padding-top:15px;padding-left:20px;padding-right:20px">
                            <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                <tr>
                                    <td align="center" valign="top" style="padding:0;Margin:0;width:560px">
                                        <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tr>
                                            </tr>
                                            <tr>
                                                <td align="left" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px">
                                                    <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:24px;color:#333333;font-size:16px">Новые данные сохранены и теперь отображаются на странице вашего профиля.
                                                        Ваши актуальные данные:</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td class="esdev-adapt-off" align="center" style="padding:20px;Margin:0">
                            <table cellpadding="0" cellspacing="0" class="esdev-mso-table" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#e8eafb;width:300px;margin:0 auto;border-radius:10px;">
                                <tr>
                                    <td class="esdev-mso-td" valign="top" style="padding:0;Margin:0">
                                        <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;">
                                            <tr>
                                                <td align="right" style="padding:5px 5px 5px 20px;Margin:0;">
                                                    <p style="Margin:0; line-height:18px; color:#333333; font-family:arial, 'helvetica neue', helvetica, sans-serif; font-size:12px;"><strong>Email:</strong></p>
                                                </td>
                                                <td align="left" style="padding:5px 20px 5px 5px;Margin:0;">
                                                    <p style="Margin:0; line-height:18px; color:#333333; font-family:arial, 'helvetica neue', helvetica, sans-serif; font-size:12px;">{{ $user->email }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="right" style="padding:5px 5px 5px 20px;Margin:0;">
                                                    <p style="Margin:0; line-height:18px; color:#333333; font-family:arial, 'helvetica neue', helvetica, sans-serif; font-size:12px;"><strong>ФИО:</strong></p>
                                                </td>
                                                <td align="left" style="padding:5px 20px 5px 5px;Margin:0;">
                                                    <p style="Margin:0; line-height:18px; color:#333333; font-family:arial, 'helvetica neue', helvetica, sans-serif; font-size:12px;">{{ $user->FullNameWithPatronymic }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="right" style="padding:5px 5px 5px 20px;Margin:0;">
                                                    <p style="Margin:0; line-height:18px; color:#333333; font-family:arial, 'helvetica neue', helvetica, sans-serif; font-size:12px;"><strong>Телефон:</strong></p>
                                                </td>
                                                <td align="left" style="padding:5px 20px 5px 5px;Margin:0;">
                                                    <p style="Margin:0; line-height:18px; color:#333333; font-family:arial, 'helvetica neue', helvetica, sans-serif; font-size:12px;">{{ $user->phone }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="left" style="padding:0;Margin:0;padding-top:15px;padding-left:20px;padding-right:20px">
                            <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                <tr>
                                    <td align="center" valign="top" style="padding:0;Margin:0;width:560px">
                                        <table cellpadding="0" cellspacing="0" width="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                            <tr>
                                                <td align="left" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px">
                                                    <p><i><small>Данное уведомление сформировано автоматически и не требует ответа.
                                                                Вся информация по теме Вашего обращения принимается только в личном кабинете.
                                                                Обращаем Ваше внимание, что письмо, направленное на указанный в сообщении электронный адрес, останется без ответа. С уважением, служба поддержки "Мой Юрист".</small></i></p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="left" style="padding:0;Margin:0;padding-bottom:10px;padding-left:20px;padding-right:20px">
                            <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                <tr>
                                    <td align="center" valign="top" style="padding:0;Margin:0;width:560px">
                                        <table cellpadding="0" cellspacing="0" width="100%" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;border-radius:5px" role="presentation">
                                            <tr>
                                                <td align="center" style="padding:0;Margin:0;padding-top:10px;padding-bottom:10px"><span class="es-button-border" style="border-style:solid;border-color:#ABD7A0;background:#ABD7A0;border-width:0px;display:inline-block;border-radius:6px;width:auto"><a href="{{ $href }}" class="es-button" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#FFFFFF;font-size:20px;border-style:solid;border-color:#ABD7A0;border-width:10px 30px 10px 30px;display:inline-block;background:#ABD7A0;border-radius:6px;font-family:arial, 'helvetica neue', helvetica, sans-serif;font-weight:normal;font-style:normal;line-height:24px;width:auto;text-align:center;border-left-width:30px;border-right-width:30px">Войти</a></span></td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="padding:0;Margin:0;padding-bottom:10px;padding-top:20px">
                                                    <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, 'helvetica neue', helvetica, sans-serif;line-height:21px;color:#333333;font-size:14px">
                                                        Есть вопросы? Наш&nbsp;email&nbsp;
                                                        <a target="_blank" href="mailto:support@myurist.online" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#5C68E2;font-size:14px">
                                                            support@myurist.online
                                                        </a>
                                                        &nbsp;Или же позвоните нам&nbsp;<a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;text-decoration:underline;color:#5C68E2;font-size:14px;line-height:21px" href="tel:{{ config('myurist.phone') }}">{!! config('myurist.phone_view') !!}</a>.
                                                        <br>
                                                        <br>
                                                        <br>
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection
