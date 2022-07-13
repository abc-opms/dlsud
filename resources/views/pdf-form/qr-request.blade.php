<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QR request (subdept-{{$subdept}})</title>

    <style>
        .main {
            content: '';
            display: block;
            clear: both;
            page-break-after: always;
            width: 150px;
            text-align: center;
        }

        .label {
            text-align: center;
            margin-left: -1px;
            overflow-wrap: break-word;
        }

        @page {
            margin: 0px;
        }
    </style>
</head>

<body>

    @foreach($items as $i)
    <page class="main">
        <img src="data:image/png;base64, {!! base64_encode(QrCode::size(130)->margin(1)->backgroundColor(235, 237, 236)->eyeColor(0, 68, 124, 64, 0, 0, 0)
            ->generate($i->property_number)) !!} ">
        <div class="label">
            <label>{{$i->property_number}}</label>
        </div>
    </page>
    @endforeach

</body>

</html>