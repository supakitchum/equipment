<html>
<head>
    <title>Print</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: normal;
            src: url("{{ asset('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: normal;
            font-weight: bold;
            src: url("{{ asset('fonts/THSarabunNewBold.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: normal;
            src: url("{{ asset('fonts/THSarabunNewItalic.ttf') }}") format('truetype');
        }

        @font-face {
            font-family: 'THSarabunNew';
            font-style: italic;
            font-weight: bold;
            src: url("{{ asset('fonts/THSarabunNew BoldItalic.ttf') }}") format('truetype');
        }

        body {
            font-family: "THSarabunNew" !important;
        }
    </style>
</head>
<body>
<table class="w-100 text-center" border="1">
    <tr class="text-center">
        <td><b>QRCode</b></td>
        <td><b>รายละเอียด</b></td>
    </tr>
    @foreach($equipments as $equipment)
        <tr>
            <td>
                <p class="m-0 p-0"><img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(150)->generate($equipment->code)) !!}"
                                        alt=""></p>
                <p class="m-0">{{ $equipment->code }}</p>
                <p> ({{ $equipment->serial }})</p>
            </td>
            <td class="text-left p-2">
                <p>ชื่อ : {{ $equipment->name }}</p>
                <p>หมวดหมู่ : {{ $equipment->category }}</p>
                <p>ประเภท : {{ $equipment->category }}</p>
            </td>
        </tr>
    @endforeach
</table>
</body>
</html>
