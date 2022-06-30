$(function () {
    // localStorage.clear();
    buyerReturnCartDetails();

    $('.buyerReturnCart').click(function () {

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

            let buyerReturnCart = [];
            if (localStorage.getItem('buyerReturnCart') === null) {

            } else {
                buyerReturnCart = JSON.parse(localStorage.getItem('buyerReturnCart'));
            }

            let index = checkBuyerReturnCart(product);
            if (index == -1) {
                addToBuyerReturnCart(buyerReturnCart, product);
            } else {
                updateBuyerReturnCart(product, index, quantity);
            }

            buyerReturnCartDetails();
        }


    });

    function addToBuyerReturnCart(buyerReturnCart, product) {
        buyerReturnCart.push(product);
        localStorage.setItem('buyerReturnCart', JSON.stringify(buyerReturnCart));
    }

    function updateBuyerReturnCart(product, index, newQuantity) {
        let buyerReturnCart = JSON.parse(localStorage.getItem('buyerReturnCart'));
        // cart[index].cusQty += cusQtyNo;
        buyerReturnCart[index].quantity = newQuantity;
        localStorage.setItem('buyerReturnCart', JSON.stringify(buyerReturnCart));
    }

    function buyerReturnCartDetails() {
        let totalPrice = 0;
        let buyerReturnCartContent = '';

        if (localStorage.getItem('buyerReturnCart') === null) {
            // $('.cart-count').html(0);
        } else {
            let buyerReturnCartData = JSON.parse(localStorage.getItem('buyerReturnCart'));

            // $('.cart-count').html(cartData.length);
            let buyerReturnCartNo = 0;
            buyerReturnCartData.forEach(function (data) {
                buyerReturnCartContent += '<tr>' +
                    '<th>#</th>' +
                    '<th>' + data.productName + '</th>' +
                    '<th>' + data.quantity + '</th>' +
                    '<th>' + data.price + '</th>' +
                    '<th>' + data.quantity * data.price + '</th>' +
                    '<th><a href="#" class="btn-cart-remove" buyerReturnCart_productId="' + data.productId + '" buyerReturnCart_item_no="' + buyerReturnCartNo + '" title="Remove Product"><i class="zmdi zmdi-delete"></i></a></th>' +
                    '</tr>';
                totalPrice += data.quantity * data.price;
                buyerReturnCartNo += 1;
            });
        }
        $('.return-cart-details').html(buyerReturnCartContent)
        $('.return-cart-total-price').html(totalPrice + ' Tk')
    }

    function checkBuyerReturnCart(product) {
        let res = -1;
        if (localStorage.getItem('buyerReturnCart') === null) {
            return -1;
        } else {
            let buyerReturnCartData = JSON.parse(localStorage.getItem('buyerReturnCart'));
            let i;
            for (i = 0; i < buyerReturnCartData.length; i++) {
                if (buyerReturnCartData[i].productId == product.productId) {
                    res = i;
                    break;
                }
            }
        }
        return res;
    }

    function checkBuyerReturnCartItems() {
        if (localStorage.getItem('buyerReturnCart') === null) {
            return false;
        } else {
            return true;
        }
    }

    $('.buyerReturnProductPlace').click(function () {
        if (checkBuyerReturnCartItems()) {

            let buyerReturnCartData = JSON.parse(localStorage.getItem('buyerReturnCart'));
            let submitUrl = $(this).attr('cus-url');
            let return_date = $('#return_date').val()
            let return_type = $('#return_type').val()
            let payment_method = $('#payment_method').val();
            let transaction_id = $('#transaction_id').val();
            let sale_id = $('#saleId').val();

            if ((return_type !== "")) {

                $.ajax({
                    url: submitUrl,
                    data: {buyerReturnCartData, sale_id, return_date, return_type, payment_method, transaction_id},
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
        let productId = $(this).attr('buyerReturnCart_productId');
        let buyerReturnCartItemNo = $(this).attr('buyerReturnCart_item_no');
        let buyerReturnCart = JSON.parse(localStorage.getItem('buyerReturnCart'));

        if (productId == buyerReturnCart[buyerReturnCartItemNo].productId) {
            buyerReturnCart.splice(buyerReturnCartItemNo, 1);
        }
        localStorage.setItem('buyerReturnCart', JSON.stringify(buyerReturnCart));
        buyerReturnCartDetails();
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
        buyerReturnCartDetails();
    });

});

