require('./bootstrap');

//Для подключения глобально
global.$ = global.jQuery = require('jquery');

// Bootstrap 4
require('admin-lte/plugins/bootstrap/js/bootstrap.bundle')

// DataTables  & Plugins
window.DataTable = require('admin-lte/plugins/datatables/jquery.dataTables')
require('admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4')
require('admin-lte/plugins/datatables-responsive/js/dataTables.responsive')
require('admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4')
require('admin-lte/plugins/datatables-select/js/dataTables.select')
require('admin-lte/plugins/datatables-buttons/js/dataTables.buttons')
require('admin-lte/plugins/datatables-buttons/js/buttons.bootstrap4')
require('admin-lte/plugins/datatables-buttons/js/buttons.html5')
require('admin-lte/plugins/datatables-buttons/js/buttons.print')
require('admin-lte/plugins/datatables-buttons/js/buttons.colVis')

// Daterange picker
require('admin-lte/plugins/daterangepicker/daterangepicker')

// Select2
require('admin-lte/plugins/select2/js/select2.full.min')

// Clipboard.min.js
window.ClipboardJS = require('clipboard/dist/clipboard.min')

// Chart
require('admin-lte/plugins/chart.js/Chart')

// SweetAlert2
window.Swal = require('admin-lte/plugins/sweetalert2/sweetalert2')

// Toastr
window.toastr = require('toastr/toastr')

// AdminLTE App
require('admin-lte/dist/js/adminlte')

// CustomFiles
window.bsCustomFileInput = require('bs-custom-file-input/dist/bs-custom-file-input')

// Bootstrap toggle
require('bootstrap4-toggle/js/bootstrap4-toggle.min');

// Input mask
require('inputmask/dist/inputmask.min');

// File Pond
window.FilePondPluginFileValidateSize = require('filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min');
window.FilePondPluginFileMetadata  = require('filepond-plugin-file-metadata/dist/filepond-plugin-file-metadata.min');
window.FilePond = require('filepond/dist/filepond.min');

window.moment = require('moment');
const flatpickr = require('flatpickr');
require('flatpickr/dist/flatpickr.css');
require('flatpickr/dist/l10n/ru');
