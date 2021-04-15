
var file;

// =================  upload product images  ================= //

// upload base product image
if($('div').is('#single')){
    var buttonSingle = $("#single");
    var baseImg = false;
    var baseImgFirst = $(".single img:first-child").attr('data-src');

    if(baseImgFirst === '' || baseImgFirst === undefined){
        baseImg = true;
    }

    new AjaxUpload(buttonSingle, {
        action: adminpath + '/' + buttonSingle.data('url') + "?upload=1",
        data: {name: buttonSingle.data('name'), baseImg: baseImg},
        name: buttonSingle.data('name'),
        onSubmit: function(file, ext){
            if (! (ext && /^(jpg|png|jpeg|gif)$/i.test(ext))){
                alert('Ошибка! Разрешены только картинки');
                return false;
            }
            buttonSingle.closest('.file-upload').find('.overlay').css({'display':'block'});

        },
        onComplete: function(file, response){
            setTimeout(function(){
                buttonSingle.closest('.file-upload').find('.overlay').css({'display':'none'});

                response = JSON.parse(response);

                $('.' + buttonSingle.data('name')).append('<img src="/upload/products/base/' + response.file + '" style="max-height: 150px;">');
            }, 0);
        }
    });
}

// upload gallery product images
if($('div').is('#multi')){

    var buttonMulti = $("#multi");

    new AjaxUpload(buttonMulti, {
        action: adminpath + '/' + buttonMulti.data('url') + "?upload=1",
        data: {name: buttonMulti.data('name')},
        name: buttonMulti.data('name'),
        onSubmit: function(file, ext){
            if (! (ext && /^(jpg|png|jpeg|gif)$/i.test(ext))){
                alert('Ошибка! Разрешены только картинки');
                return false;
            }
            buttonMulti.closest('.file-upload').find('.overlay').css({'display':'block'});

        },
        onComplete: function(file, response){
            setTimeout(function(){
                buttonMulti.closest('.file-upload').find('.overlay').css({'display':'none'});

                response = JSON.parse(response);
                console.log(response);
                $('.' + buttonMulti.data('name')).append('<img src="/upload/products/gallery/' + response.file + '" style="max-height: 150px;">');
            }, 0);
        }
    });
}


// upload blog preview image
if($('div').is('#blog_preview')){

    var buttonBlogPreview = $("#blog_preview");

    new AjaxUpload(buttonBlogPreview, {
        action: adminpath + '/' + buttonBlogPreview.data('url') + "?upload=1",
        data: {name: buttonBlogPreview.data('name')},
        name: buttonBlogPreview.data('name'),
        onSubmit: function(file, ext){
            if (! (ext && /^(jpg|png|jpeg|gif)$/i.test(ext))){
                alert('Ошибка! Разрешены только картинки');
                return false;
            }
            buttonBlogPreview.closest('.file-upload').find('.overlay').css({'display':'block'});

        },
        onComplete: function(file, response){
            setTimeout(function(){
                buttonBlogPreview.closest('.file-upload').find('.overlay').css({'display':'none'});

                response = JSON.parse(response);
                $('.' + buttonBlogPreview.data('name')).html('<img src="/upload/blog/preview/' + response.file + '" style="max-height: 150px;">');
            }, 0);
        }
    });
}

// upload full blog image
if($('div').is('#blog_full')){

    var buttonBlogFull = $("#blog_full");

    new AjaxUpload(buttonBlogFull, {
        action: adminpath + '/' + buttonBlogFull.data('url') + "?upload=1",
        data: {name: buttonBlogFull.data('name')},
        name: buttonBlogFull.data('name'),
        onSubmit: function(file, ext){
            if (! (ext && /^(jpg|png|jpeg|gif)$/i.test(ext))){
                alert('Ошибка! Разрешены только картинки');
                return false;
            }
            buttonBlogFull.closest('.file-upload').find('.overlay').css({'display':'block'});

        },
        onComplete: function(file, response){
            setTimeout(function(){
                buttonBlogFull.closest('.file-upload').find('.overlay').css({'display':'none'});

                response = JSON.parse(response);
                $('.' + buttonBlogFull.data('name')).html('<img src="/upload/blog/full/' + response.file + '" style="max-height: 150px;">');
            }, 0);
        }
    });
}


// =================  upload product images  ================= //


// =================  upload category images  ================= //
if($('div').is('#categoryImage')){
    var buttonSingle = $("#categoryImage");
    new AjaxUpload(buttonSingle, {
        action: adminpath + '/' + buttonSingle.data('url') + "?upload=1",
        data: {name: buttonSingle.data('name')},
        name: buttonSingle.data('name'),
        onSubmit: function(file, ext){
            if (! (ext && /^(jpg|png|jpeg|gif)$/i.test(ext))){
                alert('Ошибка! Разрешены только картинки');
                return false;
            }
            buttonSingle.closest('.file-upload').find('.overlay').css({'display':'block'});

        },
        onComplete: function(file, response){
            setTimeout(function(){
                buttonSingle.closest('.file-upload').find('.overlay').css({'display':'none'});

                response = JSON.parse(response);

                $('.' + buttonSingle.data('name')).html('<img src="/upload/categories/' + response.file + '" style="max-height: 150px;">');
            }, 1000);
        }
    });
}
// =================  upload category images  ================= //


// =================  reset product filters  ================= //
$('#reset-filter').click(function(){
    $('#product-filters-tabs input[type=radio]').iCheck('uncheck');
    $('#product-filters-tabs input[type=radio]').prop("checked", false);
    return false;
});

// =================  remove product filters  ================= //

// =================  delete item  ================= //
$('.delete').click(function(){
    var res = confirm('Подтвердите действие');
    if(!res) return false;
});


// delete gallery image OR base image
$('.del-item').on('click', function(){
    var res = confirm('Подтвердите действие');
    if(!res) return false;

    var $this = $(this),
        id = $this.data('id'),
        src = $this.data('src'),
        delType = $this.hasClass('del-single') ? 'delete-baseImg' : 'delete-gallery';

    $.ajax({
        url: adminpath + '/product/' + delType,
        data: {id: id, src: src},
        type: 'POST',
        beforeSend: function(){
            $this.closest('.file-upload').find('.overlay').css({'display':'block'});
        },
        success: function(res){
            setTimeout(function(){
                $this.closest('.file-upload').find('.overlay').css({'display':'none'});
                if(res == 1){
                    $this.fadeOut();
                }
            }, 1000);
        },
        error: function(){
            setTimeout(function(){
                $this.closest('.file-upload').find('.overlay').css({'display':'none'});
                alert('Ошибка');
            }, 1000);
        }
    });
});

// =================  active menu item  ================= //
var locationUrl = window.location.protocol + '//' + window.location.host + window.location.pathname;

$('.sidebar-menu a').each(function(){
    var linkUrl = $(this).attr('href');
    if(locationUrl === linkUrl){
        $(this).parent().addClass('active');
        $(this).closest('.treeview').addClass('active');
    }
});
// =================  active menu item  ================= //

// =================  form select beauty  ================= //
$('.select2').select2();

$(".select2.related-products").select2({
    placeholder: "Начните вводить наименование товара",
    //minimumInputLength: 2,
    cache: true,
    ajax: {
        url: adminpath + "/product/related-product",
        delay: 250,
        dataType: 'json',
        data: function (params) {
            return {
                q: params.term,
                page: params.page
            };
        },
        processResults: function (data, params) {
            return {
                results: data.items
            };
        }
    }
});


// =================  ckEditor init  ================= //
// Replace the <textarea id="editor1"> with a CKEditor
// instance, using default configuration.
//CKEDITOR.replace('editorProduct');
$('#editorProduct, .categoryForm #text, .articleForm #text').ckeditor();


//iCheck for checkbox and radio inputs
$('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
    checkboxClass: 'icheckbox_minimal-blue',
    radioClass   : 'iradio_minimal-blue'
});
//Red color scheme for iCheck
$('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
    checkboxClass: 'icheckbox_minimal-red',
    radioClass   : 'iradio_minimal-red'
});
//Flat red color scheme for iCheck
$('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
    checkboxClass: 'icheckbox_flat-green',
    radioClass   : 'iradio_flat-green'
});
