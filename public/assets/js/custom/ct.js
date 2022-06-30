$(function (){
    cartDetails();
    cartPageDetails();
    checkoutPageDetails();
    $('.btn-cart').click(function (){

        let productId = $(this).attr('cus-product-id');
        let productName = $(this).attr('cus-product-name');
        let productSlug = $(this).attr('cus-product-slug');
        let cusPrice = $(this).attr('cus-price');
        let cusDiscount = $(this).attr('cus-discount');
        let withDiscountPrice = parseFloat(cusPrice)+parseFloat(cusDiscount);

        let cusPhoto = $(this).attr('cus-photo');
        let brandName = $(this).attr('cus-brand');
        let categoryName = $(this).attr('cus-category');

        let cusQtyNo = parseFloat($('#qty').val());

        if (isNaN(cusQtyNo)){
            cusQtyNo = 1;
        }
        if (cusQtyNo < 1){
            alert('Min Quantity 1')
        }

        let product = {
            'productId':productId,
            'productName':productName,
            'productSlug':productSlug,
            'cusPrice':cusPrice,
            'cusDiscount':cusDiscount,
            'withDiscountPrice':withDiscountPrice,
            'cusPhoto':cusPhoto,
            'brandName':brandName,
            'categoryName':categoryName,
            'cusQty':cusQtyNo,
        };

        let cart = [];
        if(localStorage.getItem('cart') === null){

        }else{
            cart = JSON.parse(localStorage.getItem('cart'));
        }

        let index = checkCart(product);
        if(index == -1){
            addToCart(cart,product);
        }else{
            updateCart(product,index,cusQtyNo);
        }
        cartDetails();
    });


function addToCart(cart,product){
    cart.push(product);
    localStorage.setItem('cart',JSON.stringify(cart));
}

function updateCart(product,index,cusQtyNo){
    let cart = JSON.parse(localStorage.getItem('cart'));
    cart[index].cusQty += cusQtyNo;
    // cart[index].cusQty = cusQtyNo;
    localStorage.setItem('cart',JSON.stringify(cart));
}

function cartDetails() {
    let totalPrice = 0;
    let totalSubtotal = 0;
    let totalDiscount= 0;
    let withDiscount= 0;
    let cartContent = '';

    if (localStorage.getItem('cart') === null) {
        $('.cart-count').html(0);
    } else {
        let cartData = JSON.parse(localStorage.getItem('cart'));

        $('.cart-count').html(cartData.length);
        let cartNo = 0;
        cartData.forEach(function (data) {
            cartContent += '<li><a href="' + data.productSlug + '"> <img alt="megastore1" style="width: 50px !important;" class="me-3" src="' + data.cusPhoto + '"> </a>' +
                '<div class="media-body">' +
                    ' <a href="' + data.productSlug + '"> <h4>'+ data.productName + '</h4> </a>' +
                    ' <h6>' + data.cusQty + ' X ৳ ' + data.cusPrice + ' </h6>' +
                    ' <button class="btn btn-link btn-close btn-remove" cus-product-id="'+data.productId+'" cart_item_no="'+cartNo+'" title="Remove Product" aria-label="button">' +
                '</div>' +

                '</li>';

            totalPrice += (data.cusPrice * data.cusQty);
            totalSubtotal += (data.withDiscountPrice * data.cusQty);
            totalDiscount += (data.cusDiscount * data.cusQty);
            cartNo +=1;
        });
    }
    $('.header-cart-details').html(cartContent)
    $('.cart-total-price').html('৳ '+totalPrice)
    $('.cart-subtotal-price').html('৳ '+totalSubtotal)
    $('.cart-discount-price').html('৳ '+totalDiscount)
    localStorage.setItem('totalPrice',JSON.stringify(totalPrice));
    localStorage.setItem('totalDiscount',JSON.stringify(totalDiscount));
}

function cartPageDetails() {
    let totalPrice = 0;
    let cartContent = '';

    if (localStorage.getItem('cart') === null) {
        $('.cart-count').html(0);
    } else {
        let cartData = JSON.parse(localStorage.getItem('cart'));

        $('.cart-count').html(cartData.length);
        let cartNo = 0;
        cartData.forEach(function (data) {
            cartContent += '<tr>' +
                    ' <td>' +
                    '     <a href="'+data.productSlug+'"> <img src="' + data.cusPhoto + '" alt="product photo" style="width: 100px !important; height: 100px !important;"> </a>' +
                    ' </td>' +
                    ' <td><a href="'+data.productSlug+'">' + data.productName + '</a>' +
                    '     <div class="mobile-cart-content">' +
                    '         <div class="col-xs-3">' +
                    '             <div class="qty-box">' +
                    '                 <div class="input-group">' +
                    '                      <input type="number" id="qtyCart_'+data.productId+'" cus-product-id="'+data.productId+'" cart_item_no="'+cartNo+'" class="form-control qtyCart" min="1" value="'+ data.cusQty +'" >' +
                    '                 </div>' +
                    '             </div>' +
                    '         </div>' +
                    '         <div class="col-xs-3">' +
                    '             <h2 class="td-color">৳ ' + data.cusPrice + '</h2></div>' +
                    '         <div class="col-xs-3">' +
                    '             <h2 class="td-color"><a href="#" style="cursor: pointer"  class="icon btn-remove" cus-product-id="'+data.productId+'" cart_item_no="'+cartNo+'" title="Remove Product"><i class="ti-close"></i></a></h2></div>' +
                    '     </div>' +
                    ' </td>' +
                    ' <td>' +
                    '     <h2>৳ ' + data.cusPrice + '</h2></td>' +
                    ' <td>' +
                    '     <div class="">' +
                    '         <div class="input-group" style="width: 100px; margin-left: 23%;">' +
                    '             <input type="number" id="qtyCart'+data.productId+'" cus-product-id="'+data.productId+'" cart_item_no="'+cartNo+'" class="form-control text-center qtyCart"  value="'+data.cusQty+'">' +
                    '         </div>' +
                    '     </div>' +
                    ' </td>' +
                    ' <td><a href="#" style="cursor: pointer" class="icon btn-remove" cus-product-id="'+data.productId+'" cart_item_no="'+cartNo+'" title="Remove Product"><i class="ti-close"></i></a></td>' +
                    ' <td>' +
                    ' <h2 class="td-color amount">৳ ' + data.cusPrice * data.cusQty + '</h2></td>' +
                    '</tr>';

            totalPrice += (data.cusPrice * data.cusQty);
            cartNo +=1;
        });
    }
    $('.cart-page-view').html(cartContent)
    $('.checkout-page-view').html(cartContent)
    $('.cart-total-price').html('৳ '+totalPrice)
}

function checkoutPageDetails() {
    let totalPrice = 0;
    let cartContent = '';

    if (localStorage.getItem('cart') === null) {
        $('.cart-count').html(0);
    } else {
        let cartData = JSON.parse(localStorage.getItem('cart'));

        $('.cart-count').html(cartData.length);
        let cartNo = 0;
        cartData.forEach(function (data) {
            cartContent += '<li>' + data.productName + ' × '+ data.cusQty +' <span> ৳ '+ data.cusPrice * data.cusQty +'</span></li>' +
                '';

            totalPrice += (data.cusPrice * data.cusQty);
            cartNo +=1;
        });
    }
    $('.checkout-page-view').html(cartContent)
    $('.cart-total-price').html('৳ '+totalPrice)
}

function checkoutSuccessPageDetails() {
    let afterCheckoutContent = '';
    let order_id = localStorage.getItem('order_id');
    afterCheckoutContent += '<h5 class="checkout-title">Congratulation You have place an Order Successfully.</h5>' +
                '<h2 class="checkout-title">Order No: <span style="color: #fcb941; font-weight: bold;">'+order_id+'</span> </h2>'+
                '<h2 class="checkout-title">You may <a href="/login">Login</a> for order update or contact via Live Chat</h2>'+
                '<h2></h2>'+
                '<label>Thank you very much.</label>' ;

        $('.checkout-success').html(afterCheckoutContent)
    }

function checkCart(product){
    let res = -1;
    if(localStorage.getItem('cart') === null){
        return -1;
    }else{
        let cartData = JSON.parse(localStorage.getItem('cart'));
        let i;
        for(i = 0; i < cartData.length; i++){
            if(cartData[i].productId == product.productId){
                res = i;
                break;
            }
        }
    }
    return res;
}

function checkCartItems(){
    if(localStorage.getItem('cart') === null){
        return false;
    }else{
        return true;
    }
}

$('.orderPlaceBtn').click(function (){

    // if (checkCartItems()){
    let cartData = JSON.parse(localStorage.getItem('cart'));
    if (cartData.length > 0){
        let url = $(this).attr('cus-url');
        let name = $('#name').val()
        let phone = $('#phone').val()
        let address = $('#address').val()
        let email = $('#email').val()
        let password = $('#password').val()
        let order_note = $('#order_note').val()
        let totalPrice= JSON.parse(localStorage.getItem('totalPrice'));
        let totalDiscount = JSON.parse(localStorage.getItem('totalDiscount'));

        if((name !== "") && (phone !== "") && (address !== "") && (email !== "")){


            $.ajax({
                url:url,
                data:{cartData, name,  phone,   address, email, password, order_note,totalPrice,totalDiscount},
                type:'post',
                success: function (data){
                    if($.isEmptyObject(data.error)){
                        localStorage.clear();
                        cartDetails();
                        checkoutPageDetails();
                        $(".summary").hide();
                        $(".afterCheckout").hide();
                        localStorage.setItem('order_id',data.orderId);
                        checkoutSuccessPageDetails();
                    }else{
                        $(".print-error-msg").find("ul").html('');
                        $(".print-error-msg").css('display','block');
                        $.each( data.error, function( key, value ) {
                            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                        });
                    }
                },
                failed: function (){
                    alert('Something went wrong, Please try again');
                }
            });

        }else {
            alert('Name, Phone, Address, Email must require');
        }

    }else {
        alert('Product add to cart first')
    }
});

$(document).on('click','.btn-remove',function (){
        let productId = $(this).attr('cus-product-id');
        let cartItemNo = $(this).attr('cart_item_no');
        let cart = JSON.parse(localStorage.getItem('cart'));
        if(productId == cart[cartItemNo].productId){
            cart.splice(cartItemNo,1);
        }
        localStorage.setItem('cart',JSON.stringify(cart));
        cartDetails();
        cartPageDetails();
    });

$(document).on('click','.btn-clear',function (){
    localStorage.clear();
    cartDetails();
    cartPageDetails();
    checkoutPageDetails();
});

$(document).on('input','.qtyCart',function (){
    let productId = $(this).attr('cus-product-id');
    let cartItemNo = $(this).attr('cart_item_no');
    let qtyCart = parseFloat($('#qtyCart'+productId).val());

    let cart = JSON.parse(localStorage.getItem('cart'));
    // cart[index].cusQty += cusQtyNo;
    cart[cartItemNo].cusQty = qtyCart;
    localStorage.setItem('cart',JSON.stringify(cart));

    // if(productId == cart[cartItemNo].productId){
    //     cart.splice(cartItemNo,1);
    // }
    // localStorage.setItem('cart',JSON.stringify(cart));
    cartDetails();
    cartPageDetails();
});


});




