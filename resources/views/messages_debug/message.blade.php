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
        @foreach ($chatPreviews->getData()->response as $chatPreview)
            <li> {{ $chatPreview->name }}
                <ul>
                    <li><img src="{{ $chatPreview->avatar }}" alt="{{ $chatPreview->name }}" height="50" width="50"></li>
                    <li> {{ $chatPreview->updated_at }}</li>
                    <li> {{ $chatPreview->type }}</li>
                    <li> {{ $chatPreview->id }}</li>
                </ul>
            </li>
        @endforeach
    </ul>
    <h2>Сообщения с пользователем. ID=2 </h2>
    <ul>
        @foreach ($messages->getData()->response as $message)
            <li> {{ $message->id }}</li>
            <li> {{ $message->owner_id }}</li>
            <li> {{ $message->to_id }}</li>
            <li> owner (User)
                <ul>
                    <li>{{ $message->owner->name }}</li>
                    <li><img src="{{ $message->owner->image->image }}" alt="{{ $message->owner->image_id }}" height="50" width="50"></li>
                </ul>
            <li> Вложения:

                <ul>
                    <li>text: {{ $message->attachments->text }}</li>
                    <li>file: {{ $message->attachments->file }}</li>
                    <li>image: {{ $message->attachments->image }}</li>
                    <li>link: {{ $message->attachments->link }}</li>

                </ul>
            </li>

        @endforeach
    </ul>
{{--    <form id="form" enctype="multipart/form-data" action="">--}}
{{--        <input type="text" name="fromID" value="1">--}}
{{--        <input type="text" name="toID" value="3">--}}
{{--        <input type="text" name="body" value="Hahaha">--}}
{{--        <input type="text" name="type" value="message">--}}
{{--        <input type="text" name="link" value="https://123.com">--}}
{{--        <div >--}}
{{--            <label for="files[]" >Загрузить файлы</label>--}}
{{--            <div class="col">--}}
{{--                <input type="file" name="files[]" class="form-control" multiple="true"/>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div >--}}
{{--            <label for="images[]">Загрузить новые изображения</label>--}}
{{--            <div class="col">--}}
{{--                <input type="file" name="images[]" class="form-control" multiple="true"/>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <button type="submit">Кнопка отправки запроса на сообщение</button>--}}
{{--    </form>--}}
</body>
</html>
