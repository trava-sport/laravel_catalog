$('document').ready(function () {
    $('.ui-slider').slider({
        animate: false,
        range: true,
        values: [0, 2000],
        min: 0,
        max: 2000,
        step: 1,
        slide: function (event, ui) {
            if (ui.values[1] - ui.values[0] < 1) return false;
            $('.ui-slider-min').val(ui.values[0]);
            $('.ui-slider-max').val(ui.values[1]);
        },
        stop:function (event, ui) {
            let priceFrom = ui.values[0];
            let priceTo = ui.values[1];
            Cookies.set('priceFrom', priceFrom);
            Cookies.set('priceTo', priceTo);

            $.ajax({
                url: '/catalog',
                type: "GET",
                data: {
                    priceFrom: priceFrom,
                    priceTo: priceTo,
                    razmer: Cookies.get('razmer'),
                    tkan: Cookies.get('tkan')
                },
                headers: {
                    'X-CSRF': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    let positionParameters = location.pathname.indexOf('?');
                    let url = location.pathname.substring(positionParameters, location.pathname.length);
                    let newURL = (priceTo == 2000 && priceFrom == 0 && !Cookies.get('razmer') && !Cookies.get('tkan')) ? url : url + '?';
                    if (Cookies.get('razmer')) {
                        newURL += 'razmer=' + Cookies.get('razmer');
                    }
                    if (Cookies.get('razmer') && Cookies.get('tkan')) {
                        newURL += '&tkan=' + Cookies.get('tkan');
                    }
                    if (!Cookies.get('razmer') && Cookies.get('tkan')) {
                        newURL += 'tkan=' + Cookies.get('tkan');
                    }
                    if (priceFrom != 0 && !Cookies.get('razmer') && !Cookies.get('tkan')) {
                        newURL += 'priceFrom=' + priceFrom;
                    }
                    if (priceFrom != 0 && (Cookies.get('razmer') || Cookies.get('tkan'))) {
                        newURL += '&priceFrom=' + priceFrom;
                    }
                    if (priceTo != 2000 && (priceFrom != 0 || Cookies.get('razmer') || Cookies.get('tkan'))) {
                        newURL += '&priceTo=' + priceTo;
                    }
                    if (priceTo != 2000 && priceFrom == 0 && !Cookies.get('razmer') && !Cookies.get('tkan')) {
                        newURL += 'priceTo=' + priceTo;
                    }
                    history.pushState({}, '', newURL);
                    $('.column .columns').html(data);
                }
            });
        }
    });

    $(".price-input").change(function() {
        var $this = $(this);
        $(".ui-slider").slider("values",  $this.attr('index'), $this.val());
    });

    $('.filter-list').on('click', 'input:checkbox', function () {
        let razmer = '';
       let tkan = '';
       let id = $(this).attr('id');
       Cookies.set(id, '');

       $('.filter-size input:checkbox:checked').each(function() {
           id = $(this).attr('id');
           Cookies.set(id, '1');
           let value = $(this).val();
           if (razmer) {
               razmer += "," + value;
           }
           else {
               razmer += value;
           }
       })

       $('.filter-tkan input:checkbox:checked').each(function(){
           id = $(this).attr('id');
           Cookies.set(id, '1');
           let value = $(this).val()
           if (tkan) {
               tkan += "," + value;
           }
           else {
               tkan += value;
           }
       })

       Cookies.set('razmer', razmer);
       Cookies.set('tkan', tkan);

       $.ajax({
           url: '/catalog',
           type: "GET",
           data: {
               razmer: razmer,
               tkan: tkan,
               priceFrom: Cookies.get('priceFrom'),
               priceTo: Cookies.get('priceTo')
           },
           headers: {
               'X-CSRF': $('meta[name="csrf-token"]').attr('content')
           },
           success: (data) => {
               let positionParameters = location.pathname.indexOf('?');
               let url = location.pathname.substring(positionParameters, location.pathname.length);
               let newURL = (Cookies.get('priceTo') == 2000 && Cookies.get('priceFrom') == 0 && !razmer && !tkan) ? url : url + '?';
               if (razmer) {
                   newURL += 'razmer=' + razmer;
               }
               if (tkan && razmer) {
                   newURL += '&tkan=' + tkan;
               }
               if (tkan && !razmer) {
                   newURL += 'tkan=' + tkan;
               }
               if (Cookies.get('priceFrom') != 0 && !razmer && !tkan) {
                    newURL += 'priceFrom=' + Cookies.get('priceFrom');
                }
                if (Cookies.get('priceFrom') != 0 && (razmer || tkan)) {
                    newURL += '&priceFrom=' + Cookies.get('priceFrom');
                }
                if (Cookies.get('priceTo') != 2000 && (Cookies.get('priceFrom') != 0 || razmer || tkan)) {
                    newURL += '&priceTo=' + Cookies.get('priceTo');
                }
                if (Cookies.get('priceTo') != 2000 && Cookies.get('priceFrom') == 0 && !razmer && !tkan) {
                    newURL += 'priceTo=' + Cookies.get('priceTo');
                }
               history.pushState({}, '', newURL);

               $('.column .columns').html(data);
           }
       });
   });

    $('input:checkbox').each(function() {
        id = $(this).attr('id');
        let isCheck = false;
        let checkbox_length = $('.filter-size').length;
        isCheck = Cookies.get(id) ? true : false;

        if (isCheck){
            $('#' + id).attr('checked','checked');
        }else{
            $('#' + id).removeAttr('checked') ;
        }
    });

    $(".ui-slider-min").val(Cookies.get('priceFrom'));
    $(".ui-slider-max").val(Cookies.get('priceTo'));
    $(".ui-slider").slider("values", '0', Cookies.get('priceFrom'));
    $(".ui-slider").slider("values", '1', Cookies.get('priceTo'));

    $('.filter-content .btn').click(function () {
        Cookies.set('priceFrom', 0);
        Cookies.set('priceTo', 2000);
        Cookies.set('razmer', '');
        Cookies.set('tkan', '');
        $('input:checkbox').prop('checked', false);
        $('input:checkbox').each(function() {
            id = $(this).attr('id');
            Cookies.set(id, '');
        });
        $(".ui-slider-min").val(0);
        $(".ui-slider-max").val(2000);
        $(".ui-slider").slider("values", '0', 0);
        $(".ui-slider").slider("values", '1', 2000);

       $.ajax({
           url: '/catalog',
           type: "GET",
           data: {
           },
           headers: {
               'X-CSRF': $('meta[name="csrf-token"]').attr('content')
           },
           success: (data) => {
            let positionParameters = location.pathname.indexOf('?');
            let url = location.pathname.substring(positionParameters, location.pathname.length);
            let newURL = url;
            history.pushState({}, '', newURL);
            $('.column .columns').html(data);
           }
       });
    });
});