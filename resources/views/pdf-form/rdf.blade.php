<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RDF</title>
    <style>
        body {
            width: 705px;
            text-align: center;
            font-size: 15px;
            padding: 0;
            margin: 0;
        }

        .main-div {
            width: 100%;
        }

        .table-con {
            width: 100%;
            border-collapse: collapse;
        }

        div-content .th-title,
        .td-data {
            border: 1px solid gray;
            padding: 5px;
            word-wrap: break-word;
        }

        footer {
            position: fixed;
            width: 705px;
            bottom: 0;
        }

        .main-table {
            margin-top: 20px;
        }

        .div-content {
            margin-top: 30px;
        }

        .content {
            width: 100%;
            border-collapse: collapse;
        }

        .table-header {
            border: 1px solid gray;
            text-align: center;
            line-height: 15px;
        }

        .td-data {
            border: 1px solid gray;
            text-align: center;
            font-size: 12px;
        }

        .e-title {
            font-size: 15px;
            margin-left: 20px;
            margin-top: 20px;
        }

        .e-sig {
            height: 70px;
            margin-top: -15px;
        }

        .e-sig-top {
            height: 70px;
            margin-top: -15px;
        }

        .e-name {
            font-size: 14px;
            font-weight: 600;
            margin-top: -25px;
        }

        .position {
            margin-top: -20px;
            font-size: 14px;
            text-align: center;
            text-decoration: overline;
        }

        .div-sig {
            margin-left: 5px;
            width: fit-content;
            text-align: center;
        }
    </style>
</head>

<body>
    @foreach($val as $v)
    <div class="main-div">

        <center>
            <h3>DE LA SALLE UNIVERISTY - DASMARIÑAS</h1>
                <p style="font-size: 12px; margin-top: -10px;">
                    FINANCE OFFICE - PROPERTY SECTION
                </p>
        </center>

        <div style="text-align: right; margin-top: -25px;">
            <p style="font-size:18px;">
                RDF No. {{$v['rdf']->rdf_number}}
            </p>
        </div>

        <center>
            <label style="margin-top: -25px;">
                <strong>REQUEST FOR DISPOSAL OF FURNITURE/EQUIPMENT</strong>
            </label>
        </center>


        <div class="main-table">
            <table>
                <tr>
                    <td style="width: 12px;">To: </td>
                    <td style="width: 400px;">
                        <p class="top-v">
                            FINANCE OFFICE - PROPERTY SECTION
                        </p>
                    </td>
                    <td style="width: 15px; margin-left: 10px;">Date: </td>
                    <td style="width: 240px; text-decoration: underline;">
                        <p class="top-v">{{$v['rdf']->date}}</p>
                    </td>
                </tr>
                <tr>
                    <td style="width: 12px;">From: </td>
                    <td style="width: 400px;">
                        <div class="div-sig-t">
                            <img src="./storage/esigs/{{$v['from_sig']}}" alt="" class="e-sig-t">
                            <p class="top-v">
                                {{$v['from']}}
                            </p>
                            <p class="position-t">(Full Name & Signature of Department Head)</p>
                        </div>
                    </td>
                    <td style="width: 15px; margin-left: 10px;">Date: </td>
                    <td style="width: 240px;">
                        <p class="top-v">{{$v['rdf']->date}}</p>
                    </td>
                </tr>

            </table>
        </div>


        <!--Table content-->
        <div class="div-content main-t">

            <p style="text-align: left;">
                This is to request for the disposal of the following furniture/equipment:
                (please fill up corresponding box)
            </p>

            <table class="content">
                <thead>
                    <tr>
                        <th class="table-header">Qty / Unit</th>
                        <th class="table-header">Item description</th>
                        <th class="table-header">Serial No.</th>
                        <th class="table-header">Fea No.</th>
                        <th class="table-header">Acq. date</th>
                        <th class="table-header">Property No.</th>
                        <th class="table-header">ICTC/BFMO Evalutaion / Remarks</th>
                        <th class="table-header">Recommendation / Action to be</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($v['item'] as $i)
                    <tr>
                        <td class="td-data">
                            {{$i->qty}} {{$i->unit}}
                        </td>
                        <td class="td-data">
                            {{$i->name}} <br>
                            {{$i->item_description}}
                        </td>
                        <td class="td-data">
                            {{$i->serial_number}}
                        </td>
                        <td class="td-data">
                            {{$i->fea_number}}
                        </td>
                        <td class="td-data">
                            {{$i->acq_date}}
                        </td>
                        <td class="td-data">
                            {{$i->property_number}}
                        </td>
                        <td class="td-data">
                            {{$i->remarks}}
                        </td>
                        <td class="td-data">
                            {{$i->action}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



    <footer>
        <table class="main-sig">
            <tr>
                <td class="td-sig">
                    <div class="each">
                        <label class="s-label">Reason for Disposal</label>
                        <p class="reason">
                            {{$v['rdf']->reason}}
                        </p>
                    </div>
                    <div class="botom">
                        <label class="e-title">Endorsed to Warehouse</label><br>
                        <div class="div-sig">
                            <img src="./storage/esigs/{{$v['drby_sig']}}" alt="" class="e-sig">
                            <p class="e-name">
                                {{$v['drname']}}
                            </p>
                            <p class="position">Warehouse Head</p>
                        </div>
                    </div>
                </td>


                <td class="td-sig">
                    <div class="each">
                        <label class="e-title">Item/s Checked by:</label><br>
                        <div class="div-sig">
                            <img src="./storage/esigs/{{$v['cby_sig']}}" alt="" class="e-sig">
                            <p class="e-name">
                                {{$v['cname']}}
                            </p>
                            <p class="position">Property Representative / Date</p>
                        </div>
                    </div>
                    <div class="botom">
                        <label class="e-title">Approved by:</label><br>
                        <div class="div-sig">
                            <img src="./storage/esigs/{{$v['aby_sig']}}" alt="" class="e-sig">
                            <p class="e-name">
                                {{$v['aname']}}
                            </p>
                            <p class="position">Finance Director</p>
                        </div>
                    </div>
                </td>


                <td class="td-sig">
                    <div class="last-t">
                        <label class="e-title">Evaluated by:</label><br>
                        <div class="div-sig">
                            <img src="./storage/esigs/{{$v['eby_sig']}}" alt="" class="e-sig">
                            <p class="e-name">
                                {{$v['ename']}}
                            </p>
                            <p class="position">ICTC / BFMO Staff / Date</p>
                        </div>
                    </div>
                    <div class="last">
                        <label class="e-title">Noted by:</label><br>
                        <div class="div-sig">
                            <img src="./storage/esigs/{{$v['eby_sig']}}" alt="" class="e-sig">
                            <p class="e-name">
                                {$v['ename']}}
                            </p>
                            <p class="position">ICTC / BFMO Staff / Date</p>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
    </footer>
    @endforeach

    <style>
        .each {
            height: 90px;
            padding: 5px;
            border-right: 1px solid gray;
        }

        .last-t {
            height: 90px;
            padding: 5px;
        }

        .botom {
            border-right: 1px solid gray;
            border-top: 1px solid lightgray;
            height: 90px;
            padding: 5px;
        }

        .last {
            border-top: 1px solid lightgray;
            height: 90px;
            padding: 5px;
        }

        .reason {
            word-wrap: break-word;
            text-decoration: underline;
        }

        .td-sig {
            width: 235px;
        }

        .main-sig {
            border: 1px solid gray;
        }

        .top-v {
            border-bottom: 1px solid black;
            width: 95%;
            margin-left: 5px;
        }

        .e-sig-t {
            position: absolute;
            height: 60px;
            top: 180px;
            margin-left: 30px;
        }

        .position-t {
            position: absolute;
            margin-top: -14px;
            margin-left: 10px;
        }
    </style>

</body>

</html>