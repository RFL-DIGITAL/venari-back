<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Document</title>
</head>
<body>
    <h1>Пользователь {{ auth()->user()->id }}</h1>
    <h2> Превью его чатов </h2>
    {{ $chatPreviews }}
    <ul>
        @foreach ($chatPreviews->original as $chatPreview)
            <li> {{ $chatPreview->values() }}
{{--                <ul>--}}
{{--                    <li><img src="{{ $chatPreview->avatar }}" alt="{{ $chatPreview->name }}"></li>--}}
{{--                    <li> {{ $chatPreview->updated_at }}</li>--}}
{{--                    <li> {{ $chatPreview->type }}</li>--}}
{{--                    <li> {{ $chatPreview->id }}</li>--}}
{{--                </ul>--}}
{{--            </li>--}}
        @endforeach
    </ul>
    <h2>Сообщения с пользователем. ID=2 </h2>
    <ul>
{{--        @foreach ($messages as $message)--}}
{{--            <li> {{ $message->id }}</li>--}}
{{--            <li> {{ $message->owner_id }}</li>--}}
{{--            <li> {{ $message->to_id }}</li>--}}
{{--            <li> owner (User)--}}
{{--                <ul>--}}
{{--                    <li>{{ $message->owner->name }}</li>--}}
{{--                    <li><img src="{{ $message->owner->avatar }}" alt=""></li>--}}
{{--                </ul>--}}
{{--            <li> {{ $message->id }}</li>--}}

{{--        @endforeach--}}
    </ul>
    <button>Кнопка отправки запроса на сообщение</button>
</body>
</html>
