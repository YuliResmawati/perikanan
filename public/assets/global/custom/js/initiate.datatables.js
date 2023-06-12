if ($.fn.DataTable) {
  $.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings) {
    return {
      iStart: oSettings._iDisplayStart,
      iEnd: oSettings.fnDisplayEnd(),
      iLength: oSettings._iDisplayLength,
      iTotal: oSettings.fnRecordsTotal(),
      iFilteredTotal: oSettings.fnRecordsDisplay(),
      iPage: Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
      iTotalPages: Math.ceil(
        oSettings.fnRecordsDisplay() / oSettings._iDisplayLength
      ),
    };
  };
}

function intiate_datatables(option) {
  if (!option.groupColumn) {
    option.groupColumn = false;
  }
  if (!option.ordering) {
    option.ordering = false;
  }

  if (!option.stateSave) {
    option.stateSave = false;
  } 

  if (option.search_features == false) {
    option.search_features = false;
  } else {
    option.search_features =  true;
  }
  
  return option.table.DataTable({
    scrollX:!0,
    processing: true,
    serverSide: true,
    ordering: option.ordering,
    stateSave: option.stateSave,
    searching: option.search_features,
    language: {
      url: uri_dasar + "assets/global/lang.json",
    },
    ajax: {
      url: option.url,
      type: "POST",
      data: option.data,
      beforeSend: function () {
        if (option.btnfilter) {
          option.btnfilter.hide();
        }
        if (option.spinner) {
          option.spinner.show();
        }
      },
      dataSrc: function (json) {
        if (option.btnfilter) {
          option.btnfilter.show();
        }
        if (option.spinner) {
          option.spinner.hide();
        }

        if(json.error !== undefined){
          location.reload();
        }else{
          return json.data;
        }
        
      },
    },
    columns: option.columns,
    aaSorting: [
        [1, "asc"]
    ],
    initComplete: function (setting, json) {
      //Mengaktifkan Kembali Tooltip
    },
    columnDefs: [
      {
        visible: false,
        targets: option.groupColumn,
      },
    ],
    rowCallback: function (row, data, iDisplayIndex) {
      var info = this.fnPagingInfo();
      var page = info.iPage;
      var length = info.iLength;
      var index = page * length + (iDisplayIndex + 1);
      $("td:eq(0)", row).html(index);
    },
    drawCallback: function () {
      $(".dataTables_paginate > .pagination").addClass(
        "pagination-rounded custom-pagination pagination-filled pagination-wrap justify-content-center"
      );

      $('.avatar-initial').initial();
      $.Components.initTippyTooltips()
      feather.replace()

      if (option.groupColumn) {
        var api = this.api();
        var rows = api
          .rows({
            page: "current",
          })
          .nodes();
        var last = null;

        api
          .column(option.groupColumn, {
            page: "current",
          })
          .data()
          .each(function (group, i) {
            if (last !== group) {
              $(rows)
                .eq(i)
                .before(
                  '<tr class="table-active"><td colspan="' +
                  option.colspan +
                  '">' +
                  group +
                  "</td></tr>"
                );

              last = group;
            }
          });
      }
    },
  });
}

// for sidebar menu horizontal item
$("ul.nav-navhorizontal a")
  .filter(function () {
    var tesulr = $(this).attr("href");
    return tesulr == window.location;
  })
  .closest(".nav-item")
  .addClass("active");

// for sidebar menu entirely but not cover treeview
$("ul.nav-sidebar a")
  .filter(function () {
    var tesulr = $(this).attr("href");
    return tesulr == window.location;
  })
  .closest(".nav-item")
  .addClass("active");

// for treeview
$("li.treeview-menu a")
  .filter(function () {
    var tesulr = $(this).attr("href");
    return tesulr == window.location;
  })
  .closest(".treeview-menu")
  .addClass("active");

$("ul.treeview-menu-collapse a")
  .filter(function () {
    var tesulr = $(this).attr("href");
    return tesulr == window.location;
  })
  .closest(".treeview-menu-collapse")
  .addClass("collapse show");

