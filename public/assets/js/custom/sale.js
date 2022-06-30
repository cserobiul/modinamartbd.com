$(function () {
    saleCartDetails();
    $('.saleCart').click(function () {

        let productId = parseFloat($('#product_name').val());
        let productName = $('#product_full_name').attr('value');
        let price = parseFloat($('#price').val());
        let point = parseFloat($('#point').val());
        let total_point = parseFloat($('#reward_point').val());
        let totalPrice = parseFloat($('#unit_price').val());
        let quantity = parseFloat($('#quantity').val());

        let stock = $('#quantity').attr('max');

        if (typeof productName == 'undefined' || isNaN(productId)) {
            alert('Select Product Name First');
        } else if (quantity > stock) {
            alert('Stock Empty or Low Stock');
        } else {
            let product = {
                'productId': productId,
                'productName': productName,
                'price': price,
                'point': point,
                'totalPrice': totalPrice,
                'quantity': quantity,
            };

            let saleCart = [];
            if (localStorage.getItem('saleCart') === null) {

            } else {
                saleCart = JSON.parse(localStorage.getItem('saleCart'));
            }

            let index = checkSaleCart(product);
            if (index == -1) {
                addToSaleCart(saleCart, product);
            } else {
                updateSaleCart(product, index, quantity);
            }

            saleCartDetails();
        }


    });

    function addToSaleCart(saleCart, product) {
        saleCart.push(product);
        localStorage.setItem('saleCart', JSON.stringify(saleCart));

    }

    function updateSaleCart(product, index, newQuantity) {
        let saleCart = JSON.parse(localStorage.getItem('saleCart'));
        // cart[index].cusQty += cusQtyNo;
        saleCart[index].quantity = newQuantity;
        localStorage.setItem('saleCart', JSON.stringify(saleCart));
    }

    function saleCartDetails() {
        let totalPrice = 0;
        let totalPoint = 0;
        let saleCartContent = '';

        if (localStorage.getItem('saleCart') === null) {

        } else {
            let saleCartData = JSON.parse(localStorage.getItem('saleCart'));

            // $('.cart-count').html(cartData.length);
            let saleCartNo = 0;
            saleCartData.forEach(function (data) {
                saleCartContent += '<tr>' +
                    '<th>#</th>' +
                    '<th>' + data.productName + '</th>' +
                    '<th>' + data.quantity + '</th>' +
                    '<th>' + data.price + '</th>' +
                    '<th>' + data.quantity * data.price + '</th>' +
                    '<th><a href="#" class="btn-cart-remove" saleCart_productId="' + data.productId + '" saleCart_item_no="' + saleCartNo + '" title="Remove Product"><i class="zmdi zmdi-delete"></i></a></th>' +
                    '</tr>';
                totalPrice += data.quantity * data.price;
                totalPoint += data.quantity * data.point;
                saleCartNo += 1;
            });
        }
        $('.sale-cart-details').html(saleCartContent)
        $('.sale-cart-total-price').html(totalPrice + ' Tk')
        $('#sale_amount').attr('value', totalPrice);
        $('#totalRewardPoint').attr('value', totalPoint);
        $('#pay_amount').attr('max', totalPrice);
    }

    function checkSaleCart(product) {
        let res = -1;
        if (localStorage.getItem('saleCart') === null) {
            return -1;
        } else {
            let saleCartData = JSON.parse(localStorage.getItem('saleCart'));
            let i;
            for (i = 0; i < saleCartData.length; i++) {
                if (saleCartData[i].productId == product.productId) {
                    res = i;
                    break;
                }
            }
        }
        return res;
    }

    function checkSaleCartItems() {
        if (localStorage.getItem('saleCart') === null) {
            return false;
        } else {
            return true;
        }
    }

    //Form Submission
    $('#salePlaceForm').submit(function (e) {
        e.preventDefault();

        // if (checkSaleCartItems()){
        if (localStorage.getItem('saleCart') === null) {
            alert('Product Select First')
        } else {
            let saleCartData = JSON.parse(localStorage.getItem('saleCart'));
            // let formData = $(this).serialize();
            let url = $(this).attr('action');
            let sale_date = $('#sale_date').val()
            let invoice_no = $('#invoice_no').val()
            let payment_method = $('#payment_method').val();
            let transaction_id = $('#transaction_id').val();

            let total_point = $('#totalRewardPoint').val();
            let special_discount = $('#special_discount').val();
            let sale_amount = $('#sale_amount').val();
            let pay_amount = $('#pay_amount').val();
            let due_amount = $('#due_amount').val();

            let buyer_name = $('#buyer_name').val()
            let name = $('#name').val()
            let phone = $('#phone').val()
            let email = $('#email').val()
            let address = $('#address').val()

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "POST",
                headers: {
                    Accept: "application/json"
                },
                url: url,
                data: {
                    saleCartData,
                    sale_date,
                    invoice_no,
                    payment_method,
                    transaction_id,
                    total_point,
                    special_discount,
                    sale_amount,
                    pay_amount,
                    due_amount,
                    buyer_name,
                    name,
                    phone,
                    email,
                    address
                },

                success: function (data) {
                    if ($.isEmptyObject(data.error)) {
                        localStorage.clear();
                        saleCartDetails();
                        $(".print-error-msg").find("ul").html('');
                        $(".print-error-msg").css('display', 'none');
                        $("#salePlaceForm")[0].reset();

                        $(".print-success-msg").css('display', 'block');
                        $(".print-success-msg").find("strong").html('');
                        $(".print-success-msg").find("strong").append(data.success);
                    } else {
                        $(".print-success-msg").find("ul").html('');
                        $(".print-success-msg").css('display', 'none');

                        $(".print-error-msg").find("ul").html('');
                        $(".print-error-msg").css('display', 'block');
                        $.each(data.error, function (key, value) {
                            $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
                        });
                    }
                },

                failed: function () {
                    alert('Something went wrong, Please try again');
                }
            });
        }


    });


    //Product remove from sale cart when click remove icon
    $(document).on('click', '.btn-cart-remove', function () {
        let productId = $(this).attr('saleCart_productId');
        let saleCartItemNo = $(this).attr('saleCart_item_no');
        let saleCart = JSON.parse(localStorage.getItem('saleCart'));

        if (productId == saleCart[saleCartItemNo].productId) {
            saleCart.splice(saleCartItemNo, 1);
        }
        localStorage.setItem('saleCart', JSON.stringify(saleCart));
        saleCartDetails();
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
                    $('#reward_point').attr('value', data.reward_point);
                    $('#point').attr('value', data.reward_point);
                    $('#warranty').attr('value', data.warranty);
                    $('#quantity').attr('value', 1);
                    $('#quantity').attr('max', data.stock);
                    $('#qtyTxt').find("span").html('');
                    $('#qtyTxt').find("span").append('<span>Stock: ' + data.stock + '</span>');
                    $('#product_full_name').attr('value', data.product_name);
                },
            });
        }
    });

    // Show Hide New Customer Div
    $('select[name="buyer_name"]').on('change', function () {
        var buyer = $(this).val();

        if (buyer == 'newBuyer') {
            $('.newBuyerDiv').show();
        } else {
            $('.newBuyerDiv').hide();
        }
    });


    //Product Price update base on quantity
    $('#quantity').on("keyup change", function (e) {
        var qty = $(this).val();
        if (qty) {
            let price = parseFloat($('#price').val());
            let point = parseFloat($('#point').val());
            let qty = parseFloat($('#quantity').val());

            $netAmount = price * qty;
            $netPoint = point * qty;

            $('#unit_price').attr('value', $netAmount);
            $('#reward_point').attr('value', $netPoint);
        }
    })
    //Product Point update base on quantity
    // $('#quantity').on("keyup change", function(e) {
    //     var qty = $(this).val();
    //     if(qty) {
    //         let point = parseFloat($('#reward_point').val());
    //         let qty = parseFloat($('#quantity').val());
    //
    //         $netAmount = point * qty;
    //
    //         $('#unit_price').attr('value',$netAmount);
    //     }
    // })


    $('#pay_amount').on("keyup change", function (e) {

        var pay_amount = $(this).val();
        if (pay_amount) {
            var pay_amount = parseFloat($('#pay_amount').val());
            var sale_amount = parseFloat($('#sale_amount').val());
            var special_discount = parseFloat($('#special_discount').val());

            $due_amount = (sale_amount - special_discount) - pay_amount;

            if ($due_amount < 0) {
                alert('Pay amount could not bigger than Sale amount')
                $('#pay_amount').attr('value', 0);
            } else {
                $('#due_amount').attr('value', $due_amount);
            }
        }
    })

    $('#discountPercentage').on("keyup change", function (e) {

        var discountPercentage = $(this).val();
        if (discountPercentage) {
            var discountPercentage = parseFloat($('#discountPercentage').val());
            var sale_amount = parseFloat($('#sale_amount').val());

            $sd = (sale_amount * discountPercentage) / 100;
            $pay_amount = sale_amount - $sd;

            if ($sd > sale_amount) {
                alert('Discount amount could not bigger than Sale amount')
                $('#pay_amount').attr('value', 0);
            } else {
                $('#pay_amount').attr('max', $pay_amount);
                $('#pay_amount').attr('placeholder', $pay_amount);
                $('#discountPercentage').find("span").html('');
                $('#special_discount').attr('value', $sd);
            }
        }
    })

    $('#special_discount').on("keyup change", function (e) {

        var special_discount = $(this).val();
        if (special_discount) {
            var special_discount = parseFloat($('#special_discount').val());
            var sale_amount = parseFloat($('#sale_amount').val());

            $pay_amount = sale_amount - special_discount;

            if (special_discount > sale_amount) {
                alert('Discount amount could not bigger than Sale amount')
                $('#pay_amount').attr('value', 0);
            } else {
                $('#pay_amount').attr('max', $pay_amount);
                $('#pay_amount').attr('placeholder', $pay_amount);
            }
        }
    })



    $(document).on('click', '.btn-cart-all-remove', function () {
        localStorage.clear();
        saleCartDetails();
    });

});

