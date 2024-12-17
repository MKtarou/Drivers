<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>家計簿アプリ</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f0fc;
            color: #333;
        }
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">

        .edit-page {
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
        }

        .form-balance {
            display: flex;
            flex-direction: column;
        }

        .form-balance label {
            font-weight: bold;
            margin-top: 10px;
        }

        .form-balance input, .form-balance select {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px;
            margin-top: 5px;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .edit-button, .back-button {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 5px;
            color: #fff;
        }

        .edit-button {
            background-color: #9b59b6;
        }

        .edit-button:hover {
            background-color: #7d3c98;
        }

        .back-button {
            background-color: #c0392b;
        }

        .back-button:hover {
            background-color: #a93226;
        }

        .error {
            color: tomato;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <header>
        <h1>収支編集</h1>
    </header>

    <div class="edit-page">
        <form action="{{route('homebudget.update')}}" method="POST" class="form-balance">
            @csrf
            @method('put')
            <input type="hidden" id="id" name="id" value="{{$homebudget->id}}">

            <label for="date">日付:</label>
            <input type="date" id="date" name="date" value="{{$homebudget->date}}">
            @if($errors->has('date')) <span class="error">{{$errors->first('date')}}</span> @endif

            <label for="category_id">カテゴリ:</label>
            <select name="category_id" id="category_id">
                @foreach($categories as $category)
                <option value="{{$category->id}}" {{$category->id == $homebudget->category_id ? 'selected' : ''}}>
                    {{$category->name}}
                </option>
                @endforeach
            </select>

                <label for="price">金額:</label>
                <input type="text" id="price" name="price" value="{{ abs($homebudget->price) }}">
                @if($errors->has('price')) <span class="error">{{$errors->first('price')}}</span> @endif

            <div class="button-container">
                <button type="submit" class="edit-button">更新</button>
                <input type="button" class="back-button" value="戻る" onclick="window.location.href='{{ url('/') }}'">
            </div>
        </form>
    </div>
</body>
</html>
