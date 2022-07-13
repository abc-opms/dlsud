//Pop up Message
window.addEventListener('swal_mode', event => {
    Swal.fire({
        title: event.detail.text,
        width: event.detail.w,
        icon: event.detail.type,
        target: '#form-content',
        customClass: {
            container: 'position-absolute'
        },
        toast: true,
        timer: event.detail.timer,
        position: 'center',
        showConfirmButton: false,

    });
});



window.addEventListener('changeURL', event => {
  let id = event.detail.entURL;
  history.pushState(null, ``, `./${id}`);
});


/*---------------------------------------
~ Side Navigation Bar
-----------------------------------------*/

//Highlight curent tab
$(document).ready(function() {
    $('.side-b a').each(function() {
      if (window.location.href.indexOf(this.id) > -1) {
         $(this).addClass('active-page');
         $(this).closest('.nav-item').find('ul.sidebar-nav').slideDown();
      }
    }); 
});



/*---------------------------------------
~ RECORD
-----------------------------------------*/

//Table Row Highlight
window.addEventListener('val', event => {
  var index = event.detail.rowindex;
  $('tr.record').eq(index).addClass('active-table');
  $('tr.record').eq(index).siblings().removeClass('active-table');
});

//Hide Modal Supplier
window.addEventListener('hideSupplier', event => {
  $('#viewSupplier').modal('hide');
});

//Show Modal Supplier
window.addEventListener('showSupplier', event => {
  $('#viewSupplier').modal('show');
});


//Hide Modal Supplier
window.addEventListener('hideCustodian', event => {
  $('#viewCustodian').modal('hide');
});

//Show Modal Supplier
window.addEventListener('showCustodian', event => {
  $('#viewCustodian').modal('show');
});


//Hide Modal Department
window.addEventListener('hideDepartment', event => {
  $('#viewDepartment').modal('hide');
});

//Show Modal Department
window.addEventListener('showDepartment', event => {
  $('#viewDepartment').modal('show');
});


//Hide Modal Supplier
window.addEventListener('hideSubDepartment', event => {
  $('#viewSubDepartment').modal('hide');
});

//Show Modal Supplier
window.addEventListener('showSubDepartment', event => {
  $('#viewSubDepartment').modal('show');
});


/*---------------------------------------
~ REceving report LOGS
-----------------------------------------*/
//Show Modal Supplier
window.addEventListener('open-modalRR', event => {
  $('#previewFinalizeModalRR').modal('show');
});



window.addEventListener('openRrForm', event => {
  $('#openRrForm').modal('show');
});

window.addEventListener('closeRrForm', event => {
  $('#openRrForm').modal('hide');
});



$(document).ready(function() {
  $('.list-group-item').each(function() {
      if (window.location.href.indexOf(this.id) > -1) {
          $(this).addClass('active-page');
          $(this).closest('.nav-item').find('ul.sidebar-nav').slideDown();
      }
  });
});

//RR Custodian List Highlight
window.addEventListener('sample', event => {
  var index = event.detail.rowindex;
  $('#' + index).addClass('num-list-hlt');
  $('#' + index).siblings().removeClass('num-list-hlt');
  
});





window.addEventListener('hideSignRR', event => {
  $('#viewsignRR').modal('hide');
});


//FEAAAAAAAAAA
window.addEventListener('hideAddSerial', event => {
  $('#AddSerialModal').modal('hide');
});


window.addEventListener('showAddSerial', event => {
  $('#AddSerialModal').modal('show');
});


window.addEventListener('hideDeleteSerial', event => {
  $('#deleteSerial').modal('hide');
});


window.addEventListener('showDeleteSerial', event => {
  $('#deleteSerial').modal('show');
});

window.addEventListener('hidePreviewFea', event => {
  $('#previewFea').modal('hide');
});


window.addEventListener('showPreviewFea', event => {
  $('#previewFea').modal('show');
});



//DISPOSAL

//Table Row Highlight
window.addEventListener('inv-item', event => {
  var index = event.detail.rowindex;
  $('tr.inv-item').eq(index).addClass('active-table');
  $('tr.inv-item').eq(index).siblings().removeClass('active-table');
});



//

window.addEventListener('hidePass', event => {
  $('#openPass').modal('hide');
});




//NOTIFICATION
function myNotification() {
  document.getElementById("demo").innerHTML = "Hello World";
  alert(JSON.stringify(data));
  Livewire.emit('postAdded');
}



//Table Row iTEMS
window.addEventListener('selectItem', event => {
  var index = event.detail.rowindex;
  $('tr.itemSelect').eq(index).addClass('active-item');
  $('tr.itemSelect').eq(index).siblings().removeClass('active-item');
});




//QR HISTORY
window.addEventListener('showQrHistory', event => {
  $('#modalHistory').modal('show');
});

window.addEventListener('hideQrHistory', event => {
  $('#modalHistory').modal('hide');
});


//ITEM DISPOSAL
window.addEventListener('hideSuccessView', event => {
  $('#viewSuccess').modal('hide');
});

window.addEventListener('showSuccessView', event => {
  $('#viewSuccess').modal('show');
});




window.addEventListener('hidemodalChangeEval', event => {
  $('#modalChangeEval').modal('hide');
});

window.addEventListener('showmodalChangeEval', event => {
  $('#modalChangeEval').modal('show');
});