<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventory</title>

    <style type="text/css">
        .container {
            width: 705px;
        }

        .left {
            width: 40%;
            background: pink;
        }

        .center {
            width: 50%;
        }

        .right {
            width: 50%;
        }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            word-wrap: break-word;
        }

        .table-header {
            border: 1px solid;
            text-align: center;
            line-height: 15px;
            font-weight: 900;
        }

        .div-item {
            width: 705px;
            margin-top: 30px;
            font-size: 13px;
        }

        .table-body {
            border: 1px solid;
            text-align: center;
            line-height: 15px;
        }

        .total-val {
            text-align: right;
        }

        .total-con {
            border: 1px solid black;
            font-size: 16px;
        }

        .note-left {
            border: 1px solid black;
            border-right: none;
        }

        .note-right {
            border: 1px solid black;
            border-left: none;
            text-align: justify;
        }

        .note-con {
            width: 705px;
            border-collapse: collapse;
            margin-top: 20px;

        }

        .top-header {
            margin-top: 10px;
        }

        .e-sigb {
            position: absolute;
            top: 13px;
            left: 70;
            width: 150px;
        }

        .e-sigR {
            position: absolute;
            top: 35px;
            width: 150px;
            right: 50px;
        }

        input {
            border-bottom: 1px solid black;
            border-left: none;
            border-right: none;
            border-top: none;
        }
    </style>

</head>

<body>

    <div class="container">
        <center>
            <label>
                UNIVERSITY LINKAGES OFFICE PROPERTY AND EQUIPMENT INVENTORY LIST
                <br>
                Voucher Date: {{($inv_main[array_key_first($inv_main)])['acq_date']}} to {{($inv_main[array_key_first($inv_main)])['acq_date']}}
            </label>
        </center>


        @if(!empty($nby))
        <table class="top-header">
            <tr>
                <td class="center">
                    <div>
                        <label>
                            Counted by:
                            <img src="./storage/esigs/{{$cby->signature_path}}" alt="sig" class="e-sigb">
                            <input type="text" name="" value="{{$cby->first_name}} {{$cby->last_name}}">
                        </label><br>
                        <label>
                            Noted by: {{$nby->first_name}} {{$nby->last_name}}
                        </label>
                    </div>
                </td>

                <td class="right">
                    <div>
                        <label>
                            Noted by Receiving <br>Dept/Unit Head:
                            <img src="./storage/esigs/{{$rby->signature_path}}" alt="sig" class="e-sigR">
                            <input type="text" name="" value="{{$rby->first_name}} {{$rby->last_name}}">
                    </div>
                </td>
            </tr>
        </table>
        @endif
        <div class="div-item">
            <table class="item-table">
                <thead>
                    <tr>
                        <td class="table-header">Property #</td>
                        <td class="table-header">Item Description</td>
                        <td class="table-header">Serial Number</td>
                        <td class="table-header">FEA#</td>
                        <td class="table-header">Acq. Date</td>
                        <td class="table-header">Qty</td>
                        <td class="table-header">Unit Cost</td>
                        <td class="table-header">Amount</td>
                        <td class="table-header">Subdept Code</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inv_main as $i)
                    <tr>
                        <td class="table-body">{{$i['property_number']}}</td>
                        <td class="table-body">
                            {{$i['name']}}<br />{{$i['item_description']}}
                        </td>
                        <td class="table-body">
                            @if(!empty($i['serial_number']))
                            {{$i['serial_number']}}
                            @else
                            -
                            @endif
                        </td>
                        <td class="table-body">{{$i['fea_number']}}</td>
                        <td class="table-body">{{$i['acq_date']}}</td>
                        <td class="table-body">{{$i['qty']}}</td>
                        <td class="table-body">{{$i['amount']}}</td>
                        <td class="table-body">{{$i['qty'] * $i['amount']}}</td>
                        <td class="table-body">{{$i['subdept_code']}}</td>
                        <td></td>
                    </tr>
                    @endforeach

                    <tr>
                        <td colspan="10"></td>
                    </tr>


                    <tr class="total-con">
                        <td colspan="3" style="padding:10px">TOTAL</td>
                        <td colspan="7" class="total-val" style="padding:10px">
                            <strong>{{$total}}</strong>
                        </td>
                    </tr>


                </tbody>
            </table>


            <table class="note-con">
                <tr>
                    <td class="note-left" style="padding: 6px;">
                        <strong>Note:</strong>
                        <br />
                        <br />
                        <br />
                        <br />
                    </td>
                    <td class="note-right" style="padding: 6px;">
                        This is to certify that I received the following equipment/furniture from Accounting Office/Property Section for which I am responsible.
                        In case loss and if it could be proven that the loss was due to my negligence, I will pay for the abve article(s).
                        In the event of lost, it is my duty to report to the security office within 72 hours. Failure to do so means administrative negligence on my part.
                    </td>
                </tr>
            </table>
        </div>

    </div>

</body>

</html>