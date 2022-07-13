<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            width: 705px;
            text-align: center;
            font-size: 15px;
        }

        div {
            width: 100%;
        }

        table {
            width: 100%;
            table-layout: fixed;
        }

        td {
            height: 20px;
        }

        .p {
            font-size: 13px;
            margin-top: -1px;
        }

        .pt {
            font-size: 14px;
            margin-top: -20px;
        }

        .h {
            font-weight: 600px;
            font-size: 18px;
        }

        .t-header,
        .td-data {
            border: 1px solid black;
            padding: 1px;
            text-align: center;
        }

        .td-dat {
            border: 1px solid black;
            padding: 1px;
            text-align: right;
        }

        .lower {
            font-weight: 900;
            font-size: 16px;
            text-align: right;
        }
    </style>
</head>

<body>
    <div>

        <center>
            <strong><label class="h">DE LA SALLE UNIVERISTY - DASMARIÑAS</label><br>
                <label class="pt">
                    FINANCE OFFICE/PROPERTY SECTION</strong>
            </p>
        </center>


        <br><br>
        <center>
            <LABEL>RECEIVING REPORT</h1>
                <br>
                <label class="p">
                    <strong>{{$dates}}</strong>
                </label>
        </center>


        <table style="table-layout:fixed; margin-top: 20px; border-collapse: collapse;">
            <thead>
                <tr>
                    <th class="t-header">RDF No.</th>
                    <th class="t-header">No. of Items</th>
                    <th class="t-header">Req Dept Code</th>
                    <th class="t-header">Date Created</th>
                    <th class="t-header">Date Recorded</th>
                    <th class="t-header">Duration</th>
                </tr>
            </thead>

            <tbody>
                @if(!empty($items))
                @foreach($items as $i)
                <tr>
                    <td class="td-data">{{$i['rdf_number']}}</td>
                    <td class="td-data">{{$i['numItem']}}</td>
                    <td class="td-data">{{$i['subdept']}}</td>
                    <td class="td-data">{{$i['date_created']}}</td>
                    <td class="td-data">{{$i['date_recorded']}}</td>
                    <td class="td-data">{{$i['duration']}}</td>
                </tr>
                @endforeach
                @endif


                <tr>
                    <td colspan="7"></td>
                </tr>

                <tr>
                    <td colspan="5" style="text-align: right;">
                        Total No. of RDF/s:
                    </td>
                    <td colspan="2" class="lower">
                        {{$total_num}}
                    </td>
                </tr>


                <tr>
                    <td colspan="5" style="text-align: right;">
                        Total No. of Item/s Disposed:
                    </td>
                    <td colspan="2" class="lower">

                        {{$totalItem}}
                    </td>
                </tr>


                <tr>
                    <td colspan="5" style="text-align: right;">
                        Average Duration:
                    </td>
                    <td colspan="2" class="lower">
                        {{$average}} day/s
                    </td>
                </tr>

            </tbody>
        </table>




    </div>
</body>

</html>