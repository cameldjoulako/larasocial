/*------------------------------------------------------------------
* Bootstrap Simple Admin Template
* Version: 2.0
* Author: Alexis Luna
* Copyright 2020 Alexis Luna
* Website: https://github.com/alexis-luna/bootstrap-simple-admin-template
-------------------------------------------------------------------*/
// Toggle sidebar on Menu button click
$('#sidebarCollapse').on('click', function() {
    $('#sidebar').toggleClass('active');
    $('#body').toggleClass('active');
});

function premiumVersionPopup() {
  swal("This feature is available in premium version.", "To buy full version, WhatsApp: +92-310-5461304", "warning");
}

// Auto-hide sidebar on window resize if window size is small
// $(window).on('resize', function () {
//     if ($(window).width() <= 768) {
//         $('#sidebar, #body').addClass('active');
//     }
// });