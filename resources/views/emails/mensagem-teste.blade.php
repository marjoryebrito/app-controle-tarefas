@component('mail::message')
# Introdução

Conteúdo da Mensagem

@component('mail::button', ['url' => ''])
Botão de teste
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
