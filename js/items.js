/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function validateForm(){  
    var itemname = $('#item').val();
    var selectedDate = $('#selectedDate').val();
    var endDate = $('#endDate').val();
    var startPrice = $('#price').val();
    var status = $('#status').val();
    var image = $('#avatar').val();

    if(itemname === ""){
        $('#errItemname').show();
        $('#item').focus();
        return false;
    }

    if(selectedDate === ""){
        $('#errRegDate').show();
        //$('#selectedDate').focus();
        return false;
    }

    if(endDate === ""){
        $('#errEndDate').show();
        //$('#endDate').focus();
        return false;
    }
    
    if(endDate < selectedDate){
        $('#errWrongEndDate').show();
        //$('#endDate').focus();
        return false;
    }

    if(startPrice === ""){
        $('#errStartPrice').show();
        $('#price').focus();
        return false;
    }

    if(status === ""){
        $('#errSelectStatus').show();
        //$('#status').focus();
        return false;
    }
    
    if(image === ""){
        $('#errChooseFile').show();
        //$('#avatar').focus();
        return false;
    }
    return true;
}




