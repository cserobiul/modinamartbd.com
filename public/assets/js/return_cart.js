$(function () {
    // localStorage.clear();
    returnCartDetails();

    $('.returnCart').click(function () {

        let productId = parseFloat($('#product_name').val());
        let productName = $('#product_full_name').attr('value');
        let price = parseFloat($('#price').val());
        let totalPrice = parseFloat($('#unit_price').val());
        let quantity = parseFloat($('#quantity').val());

        if (typeof productName == 'undefined' || isNaN(productId)) {
            alert('Select Product Name First');
        } else {
            let product = {
                'productId': productId,
                'productName': productName,
                'price': price,
                'totalPrice': totalPrice,
                'quantity': quantity,
            };

            let returnCart = [];
            if (localStorage.getItem('returnCart') === null) {

            } else {
                returnCart = JSON.parse(localStorage.getItem('returnCart'));
            }

            let index = checkReturnCart(product);
            if (index == -1) {
                addToReturnCart(returnCart, product);
            } else {
                updateReturnCart(product, index, quantity);
            }

            returnCartDetails();
        }


    });

    function addToReturnCart(returnCart, product) {
        returnCart.push(product);
        localStorage.setItem('returnCart', JSON.stringify(returnCart));
    }

    function updateReturnCart(product, index, newQuantity) {
        let returnCart = JSON.parse(localStorage.getItem('returnCart'));
        // cart[index].cusQty += cusQtyNo;
        returnCart[index].quantity = newQuantity;
        localStorage.setItem('returnCart', JSON.stringify(returnCart));
    }

    function returnCartDetails() {
        let totalPrice = 0;
        let returnCartContent = '';

        if (localStorage.getItem('returnCart') === null) {
            // $('.cart-count').html(0);
        } else {
            let returnCartData = JSON.parse(localStorage.getItem('returnCart'));

            // $('.cart-count').html(cartData.length);
            let returnCartNo = 0;
            returnCartData.forEach(function (data) {
                returnCartContent += '<tr>' +
                    '<th>#</th>' +
                    '<th>' + data.productName + '</th>' +
                    '<th>' + data.quantity + '</th>' +
                    '<th>' + data.price + '</th>' +
                    '<th>' + data.quantity * data.price + '</th>' +
                    '<th><a href="#" class="btn-cart-remove" returnCart_productId="' + data.productId + '" returnCart_item_no="' + returnCartNo + '" title="Remove Product"><i class="zmdi zmdi-delete"></i></a></th>' +
                    '</tr>';
                totalPrice += data.quantity * data.price;
                returnCartNo += 1;
            });
        }
        $('.return-cart-details').html(returnCartContent)
        $('.return-cart-total-price').html(totalPrice + ' Tk')
    }

    function checkReturnCart(product) {
        let res = -1;
        if (localStorage.getItem('returnCart') === null) {
            return -1;
        } else {
            let returnCartData = JSON.parse(localStorage.getItem('returnCart'));
            let i;
            for (i = 0; i < returnCartData.length; i++) {
                if (returnCartData[i].productId == product.productId) {
                    res = i;
                    break;
                }
            }
        }
        return res;
    }

    function checkReturnCartItems() {
        if (localStorage.getItem('returnCart') === null) {
            return false;
        } else {
            return true;
        }
    }

    $('.customerReturnProductPlace').click(function () {
        if (checkReturnCartItems()) {

            let returnCartData = JSON.parse(localStorage.getItem('returnCart'));
            let submitUrl = $(this).attr('cus-url');
            let return_date = $('#return_date').val()
            let return_type = $('#return_type').val()
            let payment_method = $('#payment_method').val();
            let transaction_id = $('#transaction_id').val();
            let order_id = $('#orderId').val();

            if ((return_type !== "")) {

                $.ajax({
                    url: submitUrl,
                    data: {returnCartData, order_id, return_date, return_type, payment_method, transaction_id},
                    type: 'post',
                    success: function (response) {
                        let res = JSON.parse(response);
                        if (res.response) {
                            localStorage.clear();

                            $(".afterReturnProduct").hide();
                            $(".beforeReturnProduct").show();
                        }
                    },
                    failed: function () {
                        alert('Something went wrong, Please try again');
                    }
                });

            } else {
                alert('Return Type... must required')
            }

        } else {
            alert('Product Select First')
        }
    });

    $(document).on('click', '.btn-cart-remove', function () {
        let productId = $(this).attr('returnCart_productId');
        let returnCartItemNo = $(this).attr('returnCart_item_no');
        let returnCart = JSON.parse(localStorage.getItem('returnCart'));

        if (productId == returnCart[returnCartItemNo].productId) {
            returnCart.splice(returnCartItemNo, 1);
        }
        localStorage.setItem('returnCart', JSON.stringify(returnCart));
        returnCartDetails();
    });

    // Get Product Price
    $('select[name="product_name"]').on('change', function () {
        var product = $(this).val();
        if (product) {
            $.ajax({
                url: 'product-price-check/' + product,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $('#unit_price').attr('value', data.product_price);
                    $('#price').attr('value', data.product_price);
                    $('#quantity').attr('value', 1);
                    $('#product_full_name').attr('value', data.product_name);
                },
            });
        }
    });

    //Product Price update base on quantity
    $('#quantity').on("keyup change", function (e) {
        var qty = $(this).val();
        if (qty) {
            let price = parseFloat($('#price').val());
            let qty = parseFloat($('#quantity').val());

            $netAmount = price * qty;

            $('#unit_price').attr('value', $netAmount);
        }
    })


    $(document).on('click', '.btn-cart-all-remove', function () {
        localStorage.clear();
        returnCartDetails();
    });

});

