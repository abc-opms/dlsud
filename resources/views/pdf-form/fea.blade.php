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
            border-top: none;
            text-align: center;
            line-height: 15px;

        }

        .td-data {
            border: 1px solid gray;
            text-align: center;
            border-bottom: none;
            font-size: 12px;
        }

        .td-left {
            border: 1px solid gray;
            border-left: none;
            border-bottom: none;
            font-size: 12px;
            text-align: center;
        }

        .td-right {
            border: 1px solid gray;
            border-right: none;
            border-bottom: none;
            font-size: 12px;
            text-align: center;
        }

        .main-t {
            border: 1px solid black;
            border-radius: 10px;
        }


        .content {
            width: 100%;
            border-collapse: collapse;
        }

        footer {
            position: fixed;
            width: 705px;
            bottom: 0;
        }

        .sig-cby,
        .sig-nby,
        .sig-rby {
            height: 60px;
            position: absolute;
            left: 70px;
        }

        .sig-cby {
            top: 70px;
        }

        .sig-nby {
            top: 133px;
        }

        .sig-rby {
            top: 193px;
        }

        .sig-reby {
            height: 60px;
            position: absolute;
            left: 330px;
            top: 168px;
        }

        .sig-nrby {
            height: 60px;
            position: absolute;
            left: 510px;
            top: 168px;
        }

        .property {
            border: solid 1px black;
            border-radius: 10px;

        }

        .bottom-left {
            width: 40%;
            padding: 5px;
        }

        .bottom-right {
            width: 60%;
            padding: 5px;
            border: solid 1px black;
            border-radius: 10px;
        }
    </style>
</head>

<body>


    @foreach ($val as $v)
    <div style="width: 705px; background-color: white; margin-top:-20px;">
        <center>
            <h3>DE LA SALLE UNIVERISTY - DASMARIÑAS</h1>
                <p>
                    Dasmariñas, Cavite<br>
                    <strong>Warehouse Office</strong>
                </p>
        </center>

        <div style="width: 705px;">
            <table>
                <tr>
                    <td class="top-left">
                        <div>
                            <table>
                                <tr>
                                    <td>
                                        Supplier:
                                    </td>
                                    <td>
                                        MANILA IMPERIAL MOTOR SALES
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Address:
                                    </td>
                                    <td>
                                        109 Veronica St. , Tytana Center, Binondo, Manila
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Tel No.
                                    </td>
                                    <td>
                                        708-5355 to 60
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Fax No.
                                    </td>
                                    <td>
                                        708-5359
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </td>
                    <td class="top-right">
                        <div>
                            <table>
                                <tr>
                                    <td>
                                        Deliver Date:
                                    </td>
                                    <td>
                                        09-Jul-20
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Invoive Date:
                                    </td>
                                    <td>
                                        08-Jul-20
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Supplier's Invoice:
                                    </td>
                                    <td>
                                        03262
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        PO / RR No. :
                                    </td>
                                    <td>
                                        28703-38797
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </div>



        <!--Table content-->
        <div class="div-content main-t">
            <table class="content">
                <thead>
                    <tr>
                        <th>QTY / UNIT</th>
                        <th class="table-header">ITEM DESCRIPTION</th>
                        <th class="table-header">PROP. CODE</th>
                        <th class="table-header">SRL. CODE</th>
                        <th class="table-header">UNIT COST</th>
                        <th class="table-header">AMOUNT</th>
                        <th>REMARKS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($v['rritems'] as $i)
                    <tr>
                        <td class="td-left">
                            {{$i->deliver_qty}} {{$i->oum}}
                        </td>
                        <td class="td-data">
                            {{$i->name}} <br>
                            {{$i->item_description}}
                        </td>
                        <td class="td-data">
                            @foreach($v['items'] as $p)
                            @if($p->rritems_id == $i->id)
                            {{$p->property_code}}<br>
                            @endif
                            @endforeach
                        </td>
                        <td class="td-data">
                            @foreach($v['items'] as $p)
                            @if($p->rritems_id == $i->id)
                            {{$p->serial_number}}<br>
                            @endif
                            @endforeach
                        </td>
                        <td class="td-data">
                            {{$i->unit_cost}}
                        </td>
                        <td class="td-data">
                            {{$i->amount}}
                        </td>
                        <td class="td-right">
                            Acct. Code: {{$i->acc_code}}
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

        </div>


        <footer>
            <table>
                <tr>
                    <td class="bottom-left">
                        <div>
                            <p class="signtitle">ACCOUNTING / PROPERTY SECTION ACKNOWLEDGEMENT</p>

                            <div class="property">
                                <table>
                                    <tr>
                                        <td>
                                            Item Checked by / Date:
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="p-line" style="width: 290px; height:40px;">
                                            <img class="sig-cby" src="./storage/esigs/{{$v['cby']}}" alt="">
                                            <br><label style="margin-left: 50px;">{{$v['cbyname']}} {{$v['cbydate']}}</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Noted by / Date:
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="p-line" style="width: 290px; height:40px;">
                                            <img class="sig-nby" src="./storage/esigs/{{$v['nby']}}" alt="">
                                            <br><label style="margin-left: 50px;">{{$v['nbyname']}} {{$v['nbydate']}}</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Recorded by / Date:
                                        </td>

                                    </tr>
                                    <tr>
                                        <td class="p-line" style="width: 290px; height:40px;">
                                            <img class="sig-rby" src="./storage/esigs/{{$v['rby']}}" alt="">
                                            <br><label style="margin-left: 50px;">{{$v['rbyname']}} {{$v['rbydate']}}</label>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                    <td class="bottom-right">
                        <div>

                            <div style="border-bottom: 1px solid black;">
                                <p class=" note">
                                    This is to certify that I recieved the following equipment / furniture from Accounting Office / Property Section for which I am responsibile. <br>
                                    In a case of loss and if it could be proven that the loss was due to my negligence, I will pay the above article(s). <br>
                                    In the event of loss, it is my duty to report to the security officer within seventy-two hours. Failure to do so, means administrative negligence on my part.
                                </p>
                            </div>

                            <div style="border-bottom: 1px solid black;">
                                <div style="margin-top: 10px; margin-bottom: 10px;">
                                    Department: [{{$v['subdept']}}/{{$v['dept']}}] - {{$v['sbname']}}
                                </div>
                            </div>

                        </div>


                        <table style="width: 340px;">
                            <tr>
                                <td>
                                    Recieved by/ Date: <br>
                                </td>
                                <td>
                                    Noted by / Date:
                                </td>
                            </tr>
                            <tr>
                                <td style="height:40px;">
                                    <img class="sig-reby" src="./storage/esigs/{{$v['reby']}}" alt="">
                                    <br><label style="margin-left: 5px;">{{$v['rebyname']}}</label>
                                </td>
                                <td style="height:40px;">
                                    <img class="sig-nrby" src="./storage/esigs/{{$v['reby']}}" alt="">
                                    <br><label style="margin-left: 5px;">{{$v['rebyname']}}</label>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </footer>


    </div>
    @endforeach

</body>

</html>