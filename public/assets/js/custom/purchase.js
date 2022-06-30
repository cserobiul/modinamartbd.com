$(function (){
    // localStorage.clear();
    purchaseCartDetails();

    $('.purchaseCart').click(function (){

        let productId = parseFloat($('#product_name').val());
        let productName = $('#product_full_name').attr('value');
        let warranty = parseFloat($('#warranty').val());
        let price = parseFloat($('#price').val());
        let totalPrice = parseFloat($('#unit_price').val());
        let quantity = parseFloat($('#quantity').val());
        let serial = parseFloat($('#serial').val());

        if (typeof productName == 'undefined' || isNaN(productId)){
            alert('Select Product Name First');
        }else{
            let product = {
                'productId':productId,
                'productName':productName,
                'warranty':warranty,
                'price':price,
                'totalPrice':totalPrice,
                'quantity':quantity,
                'serial':serial,
            };

            let purchaseCart = [];
            if(localStorage.getItem('purchaseCart') === null){

            }else{
                purchaseCart = JSON.parse(localStorage.getItem('purchaseCart'));
            }

            let index = checkPurchaseCart(product);
            if(index == -1){
                addToPurchaseCart(purchaseCart,product);
            }else{
                updatePurchaseCart(product,index,quantity);
            }

            purchaseCartDetails();
        }

    });

    function addToPurchaseCart(purchaseCart,product){
        purchaseCart.push(product);
        localStorage.setItem('purchaseCart',JSON.stringify(purchaseCart));

    }

    function updatePurchaseCart(product,index,newQuantity){
        let purchaseCart = JSON.parse(localStorage.getItem('purchaseCart'));
        // cart[index].cusQty += cusQtyNo;
        purchaseCart[index].quantity = newQuantity;
        localStorage.setItem('purchaseCart',JSON.stringify(purchaseCart));
    }

    function purchaseCartDetails() {
        let totalPrice = 0;
        let purchaseCartContent = '';

        if (localStorage.getItem('purchaseCart') === null) {
            // $('.cart-count').html(0);
        } else {
            let purchaseCartData = JSON.parse(localStorage.getItem('purchaseCart'));

            // $('.cart-count').html(cartData.length);
            let purchaseCartNo = 0;
            purchaseCartData.forEach(function (data) {
                purchaseCartContent += '<tr>'+
                    '<th>#</th>'+
                    '<th>'+ data.productName +'</th>'+
                    '<th>'+ data.quantity +'</th>'+
                    '<th>'+ data.price +'</th>'+
                    '<th>'+ data.quantity * data.price +'</th>'+
                    '<th><a href="#" class="btn-cart-remove" purchaseCart_productId="'+data.productId+'" purchaseCart_item_no="'+purchaseCartNo+'" title="Remove Product"><i class="zmdi zmdi-delete"></i></a></th>'+
                    '</tr>';
                totalPrice += data.quantity * data.price;
                purchaseCartNo +=1;
            });
        }
        $('.purchase-cart-details').html(purchaseCartContent)
        $('.purchase-cart-total-price').html(totalPrice+' Tk')
        $('#purchase_amount').attr('value',totalPrice);
        $('#pay_amount').attr('max',totalPrice);
    }

    function checkPurchaseCart(product){
        let res = -1;
        if(localStorage.getItem('purchaseCart') === null){
            return -1;
        }else{
            let purchaseCartData = JSON.parse(localStorage.getItem('purchaseCart'));
            let i;
            for(i = 0; i < purchaseCartData.length; i++){
                if(purchaseCartData[i].productId == product.productId){
                    res = i;
                    break;
                }
            }
        }
        return res;
    }

    function checkPurchaseCartItems(){
        if(localStorage.getItem('purchaseCart') === null){
            return false;
        }else{
            return true;
        }
    }

    //Form Submission
    $('#purchasePlaceForm').submit(function (e) {
        e.preventDefault();

        if (checkPurchaseCartItems()){
            let purchaseCartData = JSON.parse(localStorage.getItem('purchaseCart'));
            // let formData = $(this).serialize();
            let url = $(this).attr('action');
            let invoice_no = $('#invoice_no').val()
            let purchase_date = $('#purchase_date').val()
            let supplier_name = $('#supplier_name').val()
            let payment_method = $('#payment_method').val();
            let transaction_id = $('#transaction_id').val();
            let purchase_amount = $('#purchase_amount').val();
            let pay_amount = $('#pay_amount').val();
            let due_amount = $('#due_amount').val();

            $.ajax({
                type: "POST",
                headers: {
                    Accept: "application/json"
                },
                url: url,
                data:{purchaseCartData,invoice_no,purchase_date,supplier_name,payment_method,transaction_id,purchase_amount,pay_amount,due_amount},

                success: function (data){
                    if($.isEmptyObject(data.error)){
                        localStorage.clear();
                        purchaseCartDetails();
                        $(".print-error-msg").find("ul").html('');
                        $(".print-error-msg").css('display','none');
                        $("#purchasePlaceForm")[0].reset();

                        $(".print-success-msg").css('display','block');
                        $(".print-success-msg").find("strong").html('');
                        $(".print-success-msg").find("strong").append(data.success);
                    }else{
                        $(".print-success-msg").find("ul").html('');
                        $(".print-success-msg").css('display','none');

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
            alert('Product Select First')
        }



    });


    //Product remove from purchase cart when click remove icon
    $(document).on('click','.btn-cart-remove',function (){
        let productId = $(this).attr('purchaseCart_productId');
        let purchaseCartItemNo = $(this).attr('purchaseCart_item_no');
        let purchaseCart = JSON.parse(localStorage.getItem('purchaseCart'));

        if(productId == purchaseCart[purchaseCartItemNo].productId){
            purchaseCart.splice(purchaseCartItemNo,1);
        }
        localStorage.setItem('purchaseCart',JSON.stringify(purchaseCart));
        purchaseCartDetails();
    });

    // Get Product Price
    $('select[name="product_name"]').on('change', function(){
        var product = $(this).val();
        if(product) {
            $.ajax({
                url: 'product-price-check/'+product,
                type:"GET",
                dataType:"json",
                success:function(data) {
                    $('#unit_price').attr('value',data.product_price);
                    $('#price').attr('value',data.product_price);
                    $('#quantity').attr('value',1);
                    $('#product_full_name').attr('value',data.product_name);
                },
            });
        }
    });


    //Product Price update base on quantity
    $('#quantity').on("keyup change", function(e) {
        var qty = $(this).val();
        if(qty) {
            let price = parseFloat($('#price').val());
            let qty = parseFloat($('#quantity').val());

            $netAmount = price * qty;

            $('#unit_price').attr('value',$netAmount);
        }
    })


    $(document).on('click','.btn-cart-all-remove',function (){
        localStorage.clear();
        purchaseCartDetails();
    });

});

