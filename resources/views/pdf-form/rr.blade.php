<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Receiving Report</title>

    <style type="text/css">
        h3 {
            margin-bottom: -10px;
        }

        .dlsud-logo {
            position: absolute;
            height: 70px;
            left: 85px;
            top: 15px;
        }

        .left-top {
            border: solid 1px;
            height: 120px;
            width: 50%;
            margin-right: 5px;
            padding: 5px;
        }

        .right-top {
            border: solid 1px;
            height: 120px;
            width: 50%;
            padding: 5px;
        }

        table {
            width: 100%;
            font-size: 13px;
        }

        .td-top {
            width: 60%;
            border-top: 1px solid;
        }

        .div-content {
            margin-top: 30px;
        }

        .td-title {
            width: 40%;
            border-right: 1px solid;
            border-top: 1px solid;
        }

        .td-con {
            margin-left: 10px;
            margin-bottom: -1px;
        }

        .table-header {
            border: 1px solid;
            text-align: center;
            line-height: 15px;
            font-size: 11px;
        }

        .content {
            width: 100%;
            border-collapse: collapse;
        }

        .table-val {
            font-size: 12px;
            word-wrap: break-word;
        }

        .table-val-c {
            text-align: center;
            font-size: 12px;
        }

        .table-val-r {
            text-align: right;
            font-size: 12px;
        }

        .main-tr:nth-child(even) {
            background-color: rgb(233, 234, 236);
        }

        .nothing {
            font-size: 11px;
            font-weight: 400;
        }

        .supplier {
            font-size: 15px;
            line-height: 20px;
            margin-left: 10px;
        }

        .signature {
            position: relative;
            margin-top: 200px;
        }



        .sig-left {
            width: 50%;
            height: 200px;
            border: solid 1px gray;
        }

        .sig-right {
            width: 50%;
            height: 200px;
            border: 1px solid gray;
        }

        .div-sig {
            margin-left: 60px;
            width: fit-content;
            text-align: center;
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

        .e-name {
            font-size: 14px;
            font-weight: 600;
            margin-top: -25px;
            text-decoration: underline;

        }

        .position {
            margin-top: -20px;
            font-size: 14px;
            text-align: center;
        }

        .div-date {
            margin-top: -20px;
        }

        .e-date {
            font-size: 14px;
            font-weight: 600;
            text-decoration: underline;
        }

        .ft {
            margin-top: 15px;
            bottom: 5px;
            line-height: 20px;
            font-size: 12px;
        }

        footer {
            position: fixed;
            width: 705px;
            bottom: 0;
        }
    </style>
</head>

<body>


    @foreach ($val as $v)
    <div style="width: 705px; background-color: white;">
        <img src="./images/dlsud.png" alt="" class="dlsud-logo">
        <center>
            <h3>DE LA SALLE UNIVERISTY - DASMARIÑAS</h1>
                <p>
                    Dasmariñas, Cavite<br>
                    <strong>Warehouse Office</strong>
                </p>
        </center>

        <div>
            <table class="content">
                <tr>
                    <td class="left-top">
                        <p class="supplier">
                            {{$v['skey']}} <br>
                            <strong>{{$v['sname']}}</strong><br>
                            {{$v['sadd']}}<br>
                            Tel. & Fax no.: {{$v['telnum']}}
                        </p>
                    </td>

                    <td class="right-top">
                        <label><strong>RECEIVING REPORT</strong></label>
                        <table>
                            <tr>
                                <td class="td-title">RR No.</td>
                                <td class="td-top">
                                    <p class="td-con">
                                        {{ $v['rr']['rr_number']}}
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="td-title">Date received</td>
                                <td class="td-top">
                                    <p class="td-con">
                                        {{$v['rr']['delivery_date']}}
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="td-title">PO No.</td>
                                <td class="td-top">
                                    <p class="td-con">
                                        {{$v['rr']['ponum']}}
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td class="td-title">Invoice/OR</td>
                                <td class="td-top">
                                    <p class="td-con">
                                        {{$v['rr']['invoice']}}
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>

        <!--Table content-->
        <div class="div-content">
            <table class="content">
                <thead>
                    <tr>
                        <th class="table-header">DEPT/ACCT<br>CODE</th>
                        <th class="table-header">ITEM DESCRIPTION</th>
                        <th class="table-header">OUM</th>
                        <th class="table-header">UNIT COST</th>
                        <th class="table-header">ORDER<br>QTY</th>
                        <th class="table-header">DELIVERY<br>QTY</th>
                        <th class="table-header">AMOUNT</th>
                        <th class="table-header">RECEIVED BY <br> END USER <br> DATE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($v['item'] as $i)
                    <tr>
                        <td>
                            <p class="table-val-c">
                                {{$v['rr']['dept_code']}}/ {{$i->acc_code}}
                            </p>
                        </td>
                        <td>
                            <p class="table-val">
                                {{$i->name}} <br>
                                {{$i->item_description}}
                            </p>
                        </td>
                        <td>
                            <p class="table-val-c">
                                {{$i->oum}}
                            </p>
                        </td>
                        <td>
                            <p class="table-val-r">
                                {{$i->unit_cost}}
                            </p>
                        </td>
                        <td>
                            <p class="table-val-r">
                                {{$i->order_qty}}
                            </p>
                        </td>
                        <td>
                            <p class="table-val-r">
                                {{$i->deliver_qty}}
                            </p>
                        </td>
                        <td>
                            <p class="table-val-r">
                                {{$i->amount}}
                            </p>
                        </td>
                        <td>
                            <div style="margin-bottom: -25px; margin-left:10px;">
                                <img src="./storage/esigs/{{$v['rby_sig']}}" alt="" style="height:40px">
                            </div>
                            <p class="table-val-c">
                                {{$v['rr']['received_date']}}
                            </p>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <center>
                <label class="nothing">********************NOTHING FOLLOWS********************</label>
            </center>
        </div>


        <footer>
            <!--Sinature-->
            <div class="signature">
                <table class="content">
                    <tr>
                        <td class="left-top">
                            <div>
                                <label class="e-title">Prepared By:</label><br>
                                <div class="div-sig">
                                    <img src="./storage/esigs/{{$v['pby_sig']}}" alt="" class="e-sig">
                                    <p class="e-name">
                                        {{$v['preparedby']}}
                                    </p>
                                    <p class="position">Warehouse Head</p>
                                </div>
                            </div>
                            <div class="div-date">
                                <label class="e-title">Date:</label><br>
                                <div class="div-sig">
                                    <p class="e-date">
                                        {{$v['pby_date']}}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="right-top">
                            <div>
                                <label class="e-title">Checked and Verified By:</label><br>
                                <div class="div-sig">
                                    <img src="./storage/esigs/{{$v['cby_sig']}}" alt="" class="e-sig">
                                    <p class="e-name">
                                        {{$v['checkedby']}}

                                    </p>
                                    <p class="position">Warehouse Head</p>
                                </div>
                            </div>
                            <div class="div-date">
                                <label class="e-title">Date:</label><br>
                                <div class="div-sig">
                                    <p class="e-date">
                                        {{$v['cby_date']}}
                                    </p>
                                </div>
                            </div>
                        </td>
                    </tr>

                </table>
            </div>

            <div class="ft">
                <p>
                    WAREHOUSE FORM NO. 01<br>
                    06-06-07
                </p>
            </div>
        </footer>


    </div>
    @endforeach

</body>

</html>