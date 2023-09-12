<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="hanabishi japon,bistronippon, currykitano">
    <meta name="generator" content="Hugo 0.84.0">
    <title>{{ $subject }}</title>    
    <!-- Bootstrap -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <p>
        <h4>Finance error  {{ $body['fuseau_horaires_display'] }}</h4>
        <p>担当：{{ $body['close_name_now'] }}</p>
    </p>
    <hr>
    <p style="padding: 5px">入力 chips: {{ $body['chips'] }}</p>
    <hr>
    <p>売上データ( +init)</p>
    <table style="border: 1px solid #000;">
        <tbody>
            <tr>
                <td>recettes {{ $body['fuseau_horaires_display'] }}</td>
                <td>{{ $body['recettes_soir'] }}</td>
            </tr>
            <tr>
                <td>initial</td>
                <td>{{ $body['montant_initial'] }}</td>
            </tr>
            <tr>
                <td><b>合計</b></td>
                <td><b>{{ $body['recettes_and_init'] }}</b></td>
            </tr>
        </tbody>
    </table>

    <p style="padding-top: 5px">レジ</p>
    <table style="border: 1px solid #000;">
        <tbody>
        <tr>
            <td>cash</td>
            <td>{{ $body['cash'] }}</td>
        </tr>
        <tr>
            <td>carte</td>
            <td>{{ $body['carte'] }}</td>
        </tr>
        <tr>
            <td>cheque</td>
            <td>{{ $body['cheque'] }}</td>
        </tr>
        <tr>
            <td>合計</td>
            <td><b>{{ $body['compte_in_caisse'] }}</b></td>
        </tr>
        </tbody>
    </table>
    <hr>
    <p><b style="color: red;">RESULTAT: {{ $body['resultat'] }}</b></p>
</body>
</html>