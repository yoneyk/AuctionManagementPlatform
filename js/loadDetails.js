/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function validateForm(){
    var startPrice = $("#start_price").val();
    var bidPrice = $("#bid_price").val();
    
    if(bidPrice === "" || bidPrice < startPrice){
        $('#errBidPrice').show();
        $('#bid_price').focus();
        return false;
    }
    return true;
    
}



