<?php

namespace App\Http\Livewire\Property;

use App\Models\QrItems;
use App\Models\qrtagging;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Notifications\OpmsNotification;
use Illuminate\Support\Facades\Notification;
use App\Mail\FormEmailNotification;

class QrTrans extends Component
{
    public $rqr_number, $search, $reason, $date, $dept, $ItemArray = array(), $action;
    public $historyItems, $rowIndex, $ItemCount, $property;
    public $editStatus, $requestby;




    public function mount($id)
    {
        if ($id == "logs") {
            //
        } else {
            $v = qrtagging::where('rqr_number', $id)->first();
            if (!empty($v)) {
                if ($v->status == 'Active') {
                    $this->openForm($v->rqr_number);
                } else {
                    //
                }
            } else {
                return abort(404);
            }
        }
    }

    /*-----------------------------------------------
   SAVE QR
    -----------------------------------------------*/

    public function saveQR()
    {
        try {
            $actionNull = QrItems::where('rqr_number', $this->rqr_number)
                ->whereNull('item_status')->count();

            if ($actionNull != 0) {
                $this->dispatchBrowserEvent('swal_mode', [
                    'text' => 'You need to add action to all Items.',
                    'type' => 'warning',
                    'w' => 400,
                    'timer' => 3000,
                ]);
            } else {
                qrtagging::where('rqr_number', $this->rqr_number)->update([
                    'status' => 'Done',
                ]);

                QrItems::where('rqr_number', $this->rqr_number)->update([
                    'status' => 'Done'
                ]);

                $this->dispatchBrowserEvent('changeURL', [
                    'entURL' =>  'logs',
                ]);

                $this->sendEmailNotif();
                $this->notif();

                $r = $this->rqr_number;
                $this->clearVars();

                if (!empty($qrIgnore)) {
                    return redirect('/qrretagging/printing/' . $r);
                } else {
                    return redirect('/qrretagging/' . $r);
                }
            }
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong, please try again later.',
                'type' => 'error',
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }


    /*-----------------------------------------------
    NOTIFICATION
    -----------------------------------------------*/

    public function sendEmailNotif()
    {
        $emailto = $this->requestby;
        $subject = 'RQR No. ' . $this->rqr_number . ' has been queued for processing.';
        $form_type = 'RQR';
        $form_number = $this->rqr_number;
        $link = "http://127.0.0.1:8000/c/qrretagging/" . $this->rqr_number;
        $s = "Done";

        Mail::to($emailto->email)->queue(new FormEmailNotification($subject, $form_type, $form_number, $link, $s));
    }


    public function notif()
    {
        $type = 'RQR';
        $message =  'RQR No. ' . $this->rqr_number . ' has been queued for processing.';
        $link = '/c/qrretagging/' . $this->rqr_number;
        $user = $this->requestby;
        $s = "Done";

        Notification::send($user, new OpmsNotification($type, $message, $link, $s));
    }
    /*-----------------------------------------------
    EDIT 
    -----------------------------------------------*/


    public function editAction($prty)
    {
        try {
            $this->validate($rules = ['action' => 'required']);

            QrItems::where('property_number', $prty)
                ->where('rqr_number', $this->rqr_number)
                ->update(['item_status' => $this->action]);

            $this->ItemArray = QrItems::where('rqr_number', $this->rqr_number)->get();
            $this->dispatchBrowserEvent('hideQrHistory');
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong, please try again later.',
                'type' => 'error',
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }


    public function showEdit($prty, $index)
    {
        try {
            $this->editStatus = $prty;
            $this->historyItems = QrItems::join('qrtaggings', 'qrtaggings.rqr_number', '=', 'qr_items.rqr_number')
                ->where('qr_items.property_number', $prty)
                ->where('qr_items.status', 'Done')
                ->get();

            $this->action = (QrItems::where('property_number', $prty)
                ->where('rqr_number', $this->rqr_number)
                ->first())->item_status;

            $this->dispatchBrowserEvent('showQrHistory');
            $this->property = $prty;
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong, please try again later.',
                'type' => 'error',
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }


    /*-----------------------------------------------
    showHistory 
    -----------------------------------------------*/

    public function showHistory($prty, $index)
    {
        try {
            $this->editStatus = null;
            $this->historyItems = QrItems::join('qrtaggings', 'qrtaggings.rqr_number', '=', 'qr_items.rqr_number')
                ->where('qr_items.property_number', $prty)
                ->where('qr_items.status', 'Done')
                ->get();

            $this->dispatchBrowserEvent('showQrHistory');
            $this->rowIndex = $index;
            $this->property = $prty;
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong, please try again later.',
                'type' => 'error',
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }


    public function saveAction()
    {
        try {
            if (!empty($this->action)) {
                QrItems::where('property_number', $this->property)
                    ->where('rqr_number', $this->rqr_number)
                    ->update([
                        'item_status' => $this->action
                    ]);
                $this->ItemArray = QrItems::where('rqr_number', $this->rqr_number)->get();
                $this->dispatchBrowserEvent('hideQrHistory');
            } else {
                $this->dispatchBrowserEvent('swal_mode', [
                    'text' => 'Please add action before saving',
                    'type' => 'warning',
                    'w' => 300,
                    'timer' => 3000,
                ]);
            }
            //
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong, please try again later.',
                'type' => 'error',
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }

    /*-----------------------------------------------
    SHOW
    -----------------------------------------------*/
    public function openForm($rqr)
    {
        try {
            $this->clearVars();
            $this->rqr_number = $rqr;
            $data = qrtagging::where('rqr_number', $rqr)->first();
            $this->reason = $data->reason;
            $this->date = $data->req_date;
            $this->dept = $data->subdept_code;
            $n = User::where('school_id', $data->reqby)->first();
            $this->name = $n->first_name . ' ' . $n->last_name;

            $this->requestby = $n;

            $this->ItemArray = QrItems::where('rqr_number', $rqr)->get();
            $this->ItemCount = count($this->ItemArray);

            $this->dispatchBrowserEvent('changeURL', [
                'entURL' =>  $this->rqr_number,
            ]);

            //mark as read
            if (empty($data->read_at)) {
                $this->readat();
            }

            //
        } catch (Exception $e) {
            $this->dispatchBrowserEvent('swal_mode', [
                'text' => 'Something went wrong, please try again later.',
                'type' => 'error',
                'w' => 400,
                'timer' => 3000,
            ]);
        }
    }

    /*-----------------------------------------------------------
   Read at
    -----------------------------------------------------------*/

    public function readat()
    {
        try {
            qrtagging::where('rqr_number', $this->rqr_number)->update($this->readData());
        } catch (Exception $e) {
            //
        }
    }
    public function readData()
    {
        return [
            'read_at' => Carbon::now(),
        ];
    }

    /*-----------------------------------------------
    CLEAR
    -----------------------------------------------*/
    public function clearVars()
    {
        $this->name = null;
        $this->date = null;
        $this->dept = null;
        $this->reason = null;
        $this->rqr_number = null;
        $this->itemStatus = null;
        $this->ItemArray = null;
        $this->ItemCount = null;
    }


    public function clear()
    {
        $this->clearVars();
        $this->dispatchBrowserEvent('changeURL', [
            'entURL' =>  'logs',
        ]);
    }

    /*-----------------------------------------------
    RENDER  
    -----------------------------------------------*/

    public function render()
    {
        if (!empty($this->rqr_number)) {
            $this->dispatchBrowserEvent('sample', [
                'rowindex' => $this->rqr_number
            ]);
        }

        return view('livewire.property.qr-trans', [
            'rqr' => qrtagging::where('status', 'Active')
                ->where('rqr_number', 'like', '%' . $this->search . '%')->latest()->get(),
        ]);
    }
}
