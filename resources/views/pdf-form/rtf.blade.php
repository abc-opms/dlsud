<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RTF</title>
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
            margin-top: 10px;
            text-decoration: underline;
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
            <p style="font-size:18px; text-decoration: underline;">
                RTF No. {{$v['rdf']->rtf_number}}
            </p>
        </div>

        <center>
            <label style="margin-top: -25px;">
                <strong>REQUEST FOR TRANSFER OF FURNITURE/EQUIPMENT</strong>
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
                    <td style="width: 240px;">
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
                This is to request for the disposal of the following furniture/equipement.
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
                        <th class="table-header">Evaluated & Noted by</th>
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
                            @if($i->eval_by == 'BFMO')
                            <div style="margin-bottom: -25px; margin-left:10px;">
                                <img src="./storage/esigs/{{$v['bby_sig']}}" alt="" style="width:90px">
                            </div>
                            <p class="table-val-c">
                                {{$v['bname']}}
                            </p>
                            @else
                            <div style="margin-bottom: -25px; margin-left:10px;">
                                <img src="./storage/esigs/{{$v['iby_sig']}}" alt="" style="width:90px">
                            </div>
                            <p class="table-val-c">
                                {{$v['iname']}}
                            </p>
                            @endif
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
                <td colspan="2">
                    <div class="reason">
                        Reason for Transfer: {{$v['rdf']->reason}}
                    </div>
                </td>
            </tr>


            <tr>
                <td colspan="2">
                    <div style="border-bottom: 1px solid black;">

                    </div>
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">
                    <div style="border-right:1px solid gray;">
                        <p style="font-size: 14px;">
                            Note: This is to cerity that I recived the following equipment/furniture from other deperatment/colleges for which I am responsibile. In case of loss and if I could be proven thta the loss was due to my negligence, I will pay for the above item(s). In the event of loss, it is my duty to report to the security officer within 72 hours. Failure to do so means administrative negligence on my part.
                        </p>
                    </div>
                </td>
                <td style="width: 50%;">
                    <div class="s-g">
                        <div>
                            Receiving Report: {{$v['rdf']->subdept_code}}
                        </div>
                        <div style="margin-top: 8px;">
                            Custodian: {{$v['tname']}}
                        </div>
                        <div>
                            <img src="./storage/esigs/{{$v['tby_sig']}}" alt="" class="e-sig">
                            <br>
                            <p style="margin-top: -25px;">Dept/Unit: {{$v['tname']}} </p>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div style="border-top: 1px solid gray;"></div>
                </td>
            </tr>
            <tr style="border: 1px solid gray">
                <td>
                    <div style="border-right: 1px solid gray;">
                        Item/s Cheked by:
                        <img src="./storage/esigs/{{$v['cby_sig']}}" alt="" class="e-sigg">
                        <p class="e-namee">
                            {{$v['cname']}}
                        </p>
                        <p class="position">property Representative</p>
                    </div>
                </td>
                <td>
                    <div style="border-right: 1px solid gray;">
                        Approved by:
                        <img src="./storage/esigs/{{$v['aby_sig']}}" alt="" class="e-sigg">
                        <p class="e-namee">
                            {{$v['aname']}}
                        </p>
                        <p class="position">property Representative</p>
                    </div>
                </td>
            </tr>
        </table>
        <div class="sv">
            <img src="./storage/esigs/{{$v['cby_sig']}}" alt="" class="e-sigb">
            Posted by : {{$v['cname']}}
        </div>
    </footer>
    @endforeach


    <style>
        .sv {
            text-align: left;
            margin-top: 20px;
        }

        .label-bm {
            margin-left: 80px;
            text-decoration: overline;
            margin-top: -1px;
        }

        .e-sigg {
            position: absolute;
            top: 130;
            height: 70px;

        }

        .e-sigb {
            position: absolute;
            top: 180;
            height: 70px;
            left: 70;

        }

        .e-namee {
            text-align: center;
        }

        .each {
            height: 90px;
            padding: 5px;
        }

        .s-r {
            text-decoration: underline;
        }

        .last-t {
            height: 90px;
            padding: 5px;
        }

        .middle {
            border-right: 1px solid gray;
            border-top: 1px solid gray;
            height: 140px;
        }

        .last {
            border-top: 1px solid lightgray;
            height: 90px;
            padding: 5px;
        }

        .reason {
            width: 705px;
            height: 20px;
        }

        .reason-text {
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

        .e-sig-h {
            position: absolute;
            height: 40px;
        }

        .s-g {
            height: 120px;
        }
    </style>
</body>

</html>