  <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>

  <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

  <!-- jQuery Scrollbar -->
  <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>

  <!-- Chart JS -->
  <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>

  <!-- jQuery Sparkline -->
  <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>

  <!-- Chart Circle -->
  <script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>

  <!-- Datatables -->
  <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>

  <!-- Bootstrap Notify -->
  <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>

  <!-- jQuery Vector Maps -->
  <script src="{{ asset('assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugin/jsvectormap/world.js') }}"></script>

  <!-- Sweet Alert -->
  <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

  <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>

  <script src="{{ asset('assets/js/setting-demo.js') }}"></script>

  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

  <script>
      $(document).ready(function() {
          $('.table:not(.no-datatable)').DataTable({
              pageLength: 25,
              lengthMenu: [10, 25, 50, 100],
              ordering: false,

          });
          $('.dataTables_info').remove();
      });
  </script>
  <style>
      .dataTables_length label {
          font-size: 0 !important;
      }

      /* .dataTables_paginate {
          display: none !important;
      } */

      .dataTables_info {
          display: none !important;
      }

      p.small.text-muted {
          display: none !important;
      }

      .dataTables_length select {
          font-size: 14px !important;
      }

      table.dataTable tbody td {
          padding: 10px 15px !important;
      }

      table.dataTable thead th {
          padding: 12px 15px !important;
      }

      table.dataTable thead .sorting,
      table.dataTable thead .sorting_asc,
      table.dataTable thead .sorting_desc {
          background-image: none !important;
          cursor: default !important;
      }
  </style>


  <script>
      $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
          type: "line",
          height: "70",
          width: "100%",
          lineWidth: "2",
          lineColor: "#177dff",
          fillColor: "rgba(23, 125, 255, 0.14)",
      });

      $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
          type: "line",
          height: "70",
          width: "100%",
          lineWidth: "2",
          lineColor: "#f3545d",
          fillColor: "rgba(243, 84, 93, .14)",
      });

      $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
          type: "line",
          height: "70",
          width: "100%",
          lineWidth: "2",
          lineColor: "#ffa534",
          fillColor: "rgba(255, 165, 52, .14)",
      });
  </script>
  <script>
      // Hilangkan saat semua asset selesai dimuat
      window.addEventListener('load', function() {
          const el = document.getElementById('preloader');
          if (el) el.classList.add('hidden');
          // remove dari DOM setelah transisi
          setTimeout(() => el && el.remove(), 350);
      });

      // (Opsional) Tampilkan saat AJAX mulai & sembunyikan saat selesai (butuh jQuery)
      if (window.jQuery) {
          $(document).on('ajaxStart', function() {
              $('#preloader').removeClass('hidden').show();
          });
          $(document).on('ajaxStop', function() {
              $('#preloader').addClass('hidden');
              setTimeout(() => $('#preloader').hide(), 350);
          });
      }

      // (Opsional) Jika kamu pakai DataTables dan mau tunggu inisialisasinya:
      // $('.table').on('init.dt', function(){ $('#preloader').addClass('hidden'); });
  </script>
