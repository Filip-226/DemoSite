{{ Lang::get('email.greeting') }} {{ $name }},<br/><br/>

{{ Lang::get('email.thanks_sentence') }}<br/><br/>

1. {{ Lang::get('email.user_id')}} : {{ $email }}<br/>
2. {{ Lang::get('email.activation_code')}} : {{ $code }}<br/><br/>

To activate your account please visit <a href="{{ $link }}">{{ $link }}</a> or click on the activation link below:
<a href="{{ $activatelink }}">{{ $activatelink }}</a>
<br/><br/>


{{ Lang::get('email.thanks_surfing_sentence') }}<br/>
{{ Lang::get('general.app_name') }}<br/>
