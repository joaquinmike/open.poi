og = {};
og.paId = 0;
og.createOption = function(data){
  var htmlOption = '<option value="">Seleccione</option>';
  var htmlImagePay = '';
  $.each(data,function(indice,value) {
    htmlOption+= '<option tag="'+value.type+'" value="'+value.name+'">' + value.name +'</option>';
    htmlImagePay+= '<li><img src="'+ og.getStatic +'s/img/icons/pm/'+value.nameImage+'" alt="' + value.name +'"></li>';
  });
  $('#cbxPayment').html(htmlOption);
  $('#idImagesPay').html(htmlImagePay);
}
og.getPaymentMethod = function(pais){
  var loading = '<li style="width:100%;margin-right:0;"><div class="loading-gif" style="width:100%;text-align:center;"><img src="'+og.getStatic+'s/img/loading.gif" /></div></li>';
  $('#idImagesPay').html(loading);
  $.ajax({
    url: og.getContent + "pgp/payment/payment-methods",
    data: {country : pais,transactionId:og.transactionId},
    type: "POST",
    dataType: "json",
    success: function(response) {
      og.createOption(response);
    },
    error: function(xhr, status, errorThrown) {
      console.dir('NOT');
    },
    complete: function(xhr, status) {
      //alert("The request is complete!");
    }
  });
}
og.guardarFormulario = function(fpago) {
  og.formaPago = fpago;
  var varParams = '&ip=' + og.site.ip;
  varParams += '&formaPago=' + og.formaPago;
  varParams += '&sessionid=' + og.transactionId;
  varParams += '&' + $('#formPagos').serialize();
  //document.getElementById("btnPagar").disabled = true;
  var loadingModal = '<div id="modalLoad" style="width:100%;text-align:center;position: absolute;top: 10px;z-index: 9999;"><img src="'+og.getStatic+'s/img/loading.gif" /></div>';
  $('body').prepend(loadingModal);
  $.ajax({
    url: og.getContent + "pgp/payment/save-order",
    data: varParams,
    type: "POST",
    dataType: "json",
    success: function(response) {
      
      if(response.status > 0){
        if(og.formaPago=='PE'){
          og.paId = response.data.paid;
          $("#frame").attr("src", response.data.redirect);
          $('#modalPay').modal('show')
        }
        else{
          location.href = og.getContent + 'pgp/complete/' + response.data.paid;
          //og.postAndRedirect(response.data.redirect, response.data.params);
        }
      }else{
        jAlert(response.message, '');
      }
      $("#modalLoad").remove();
      $('#cbxPayment').attr('value', '');

    },
    error: function(xhr, status, errorThrown) {
        jAlert('Error de conexion, por favor vuelva a intentarlo.', '');
      $("#modalLoad").remove();

    },
    complete: function(xhr, status) {
        //$("#modalLoad").remove();
    }
  });
  return false;
}
og.postAndRedirect = function(url, postData)
{
  var postFormStr = "<form method='POST' action='" + url + "'>\n";
  for (var key in postData)
  {
    if (postData.hasOwnProperty(key))
    {
      postFormStr += "<input type='hidden' name='" + key + "' value='" + postData[key] + "'></input>";
    }
  }
  postFormStr += "</form>";
  var formElement = $(postFormStr);
  $('body').append(formElement);
  $(formElement).submit();
}


$(document).ready(function() {
    $('#countries').change(function(){
      og.getPaymentMethod(this.value);
    })
    $('#cbxPayment').change(function(){
      var element = $("option:selected", this);
      var tag = element.attr("tag");
      if(tag=='PE') {
        og.guardarFormulario(tag);
        //document.getElementById("btnPagar").disabled = true;
      }
    });
    $('#modalPay').on('hidden', function(e){console.log('close')});
    $('#modalPay').on('hidden.bs.modal', function () {
      location.href = og.getContent + "pgp/pending/" + og.paId;
    })
});
