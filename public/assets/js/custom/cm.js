$(function (){

    $('.btn-quickview').click(function (){
        let cusId = $(this).attr('cus-id');
        $.ajax({
            url:cusId,
            dataType:"json",
            type:'get',
            success: function (data){
                $('.product-title').html(data.product.name)
                $('.product-short-desc').html(data.product.excerpts)
                $('.product-price').html('New Price: ৳ '+data.product.sale_price)
                $('.old-price').html('Old Price: ৳ '+(data.product.sale_price + data.product.discount_amount))
                $('.price-discount').html('Discount: ৳ '+data.product.discount_amount)
                $('.product-image').html('<img src="'+data.product.photo+'"/>')
                $('.product-slug').html('<a href="products/'+data.product.slug+'" style="color: #fff0ff"> <i class="w-icon-cart"></i> <span>Details</span></a>')
            },
            failed: function (){
                alert('Something went wrong, Please try again');
            }
        });
    });

});
