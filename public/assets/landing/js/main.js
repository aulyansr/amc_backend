$(document).ready(function () {
    var swiper = new Swiper(".sw-promo", {
        loop: true,
        spaceBetween: 10,
        slidesPerView: 3,
        freeMode: true,
        watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".sw-promo2", {
        loop: true,
        spaceBetween: 10,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiper,
        },
    });

    var swiper = new Swiper('.sw-slider', {
        pagination: {
            el: ".swiper-pagination",
        },
        breakpoints: {
            1200: {
                spaceBetween: 22,
                centeredSlides: false,
                loop: true,
                slidesPerView: 3
            },
            920: {
                spaceBetween: 20,
                centeredSlides: true,
                loop: true,
                slidesPerView: 2,
            },
            820: {
                spaceBetween: 20,
                centeredSlides: true,
                loop: true,
                slidesPerView: 1,
            },
            // when window width is >= 320px
            320: {
                centeredSlides: true,
                slidesPerView: 1,
                spaceBetween: 20,

            },
            // when window width is >= 480px
            480: {
                centeredSlides: true,
                slidesPerView: 1,
                spaceBetween: 20,

            }
            // when window width is >= 640px

        },
    });

    $('.same-height').matchHeight();
    $('.same-height-footer').matchHeight({
        byRow: false,
        property: 'min-height',
        target: null,
        remove: false
    });
});
var swiper = new Swiper('.sw-service', {
    slidesPerView: 'auto',
    spaceBetween: 16,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    autoplay: {
        delay: 3000, // Set the delay between slides in milliseconds (ms)
        disableOnInteraction: false, // Allow interaction with the slider (swiping) to prevent autoplay from stopping
    },
});

function numberInput(e) {
    let data = $(e).val().replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');
    console.log(data);
    return $(e).val(data);

}

document.addEventListener('DOMContentLoaded', function () {
    const orderModal = document.getElementById('orderModal');
    if (orderModal) {
        orderModal.addEventListener('show.bs.modal', event => {
            // Button that triggered the modal
            const button = event.relatedTarget;
            // Extract info from data-bs-* attributes
            const service_type = button.getAttribute('data-bs-whatever');
            // If necessary, you could initiate an Ajax request here
            // and then do the updating in a callback.

            // Update the modal's content.
            const modalTitle = orderModal.querySelector('.modal-title');
            const modalBodyInput = orderModal.querySelector('.modal-body .service_type_value');

            modalTitle.textContent = `Pesan Jasa ${service_type}`;
            modalBodyInput.value = service_type;
        });
    }
});



$(document).on('click', '.send_form_order', function () {
    var input_blanter = document.getElementById('wa_email');

    /* Whatsapp Settings */
    var walink = 'https://web.whatsapp.com/send',
        phone = '6285210632227',
        walink2 = 'Halo Admin AMC, saya ingin order untuk',
        text_yes = 'Terkirim.',
        text_no = 'Isi semua Formulir lalu klik Pesan.';

    /* Smartphone Support */
    if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
        var walink = 'whatsapp://send';
    }

    if ("" != input_blanter.value) {

        /* Call Input Form */
        var input_select = $("#service_type_value").val(),
            input_name1 = $("#wa_name").val(),
            input_email = $("#wa_email").val(),
            input_number = $("#wa_number").val(),
            input_count = $("#wa_count").val(),
            input_keluhan = $("#wa_keluhan").val(),
            input_province = $("#province_id :selected").text(),
            input_city = $("#city_id :selected").text(),
            input_kecamatan = $("#kecamatan_id :selected").text(),
            input_kelurahan = $("#kelurahan_id :selected").text(),
            input_no_rumah = $("#input_no_rumah").val(),
            input_address = $("#wa_address").val();
        input_pengerjaan = $("#pengerjaan").val();
        /* Final Whatsapp URL */
        var blanter_whatsapp = walink + '?phone=' + phone + '&text=' + walink2 + '%0A%0A' +
            '*Layanan* : ' + input_select + '%0A' +
            '*Name* : ' + input_name1 + '%0A' +
            '*Pengerjaan* : ' + input_name1 + '%0A' +
            '*Email Address* : ' + input_email + '%0A' +
            '*Nomor Handphone* : ' + input_number + '%0A' +
            '*Tanggal Pengerjaan* : ' + input_pengerjaan + '%0A' +
            '*Jumlah AC* : ' + input_count + '%0A' +
            '*Keluhan* : ' + input_keluhan + '%0A' +
            '*Alamat* : ' + input_address + ',' + input_province + ',' + input_city + ',' + input_kecamatan + ',' + input_kelurahan + ',' + input_kelurahan + '%0A' +
            '*Note Alamat*: ' + input_no_rumah + '%0A';

        /* Whatsapp Window Open */
        window.open(blanter_whatsapp, '_blank');
        document.getElementById("text-info").innerHTML = '<span class="p-3 mb-2 w-100 bg-success text-white rounded-3">' + text_yes + '</span>';
    } else {
        document.getElementById("text-info").innerHTML = '<span class="p-3 mb-2 w-100 bg-danger text-white rounded-3">' + text_no + '</span>';
    }
});
