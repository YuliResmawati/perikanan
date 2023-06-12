  function intiate_ajax_select(option) {
    let _onSuccess = (data) => {}
    if(option.onSuccess != undefined) _onSuccess = option.onSuccess;
    
    option.onSuccess = function(data) {
      let s_select = "";
      $.each(data.data, function (index, item) {
        s_select += "<option value='" + item.id + "' " + item.selected + ">" + item.name + "</option>";
      });

      option.container.html(s_select);
      option.container.val(option.container.val()).trigger("change");
      _onSuccess(data);
    }
    
    get_data_by_id(option);
  }
  
  function initate_ajax_autocomplete(option) {
    if (option.type == undefined) {
      option.type = "POST";
    }
  
    option.container.autoComplete({
      resolver: 'custom',
      formatResult: function (item) {
          return {
          value: item.id,
          text: item.text,
          html: [ 
              item.text
              ] 
          };
      },
      events: {
          search: function (qry, callback) {
            if(autocomplete_ajax && autocomplete_ajax.readyState != 4) {
              autocomplete_ajax.abort();
            }
  
            autocomplete_ajax = $.ajax({
                url: option.url,
                type: option.type,
                data: {...option.data, 'qry': qry},
                dataType :"json",
  
            }).done(function (res) {
                callback(res.data);
                on_process = false;
            });
          }
      }
  });
  }
  
  function bx_alert(msg, redirect, title) {
    if (title === undefined) {
      title =
        '<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Peringatan ';
    }
    bootbox.alert({
      title: title,
      message: msg,
      closeButton: false,
      centerVertical: true,
      buttons: {
        ok: {
          label: "Baiklah",
          className: "btn-info",
        },
      },
      callback: function (result) {
        if (redirect != undefined) {
          location.replace(redirect);
        }
      },
    });
  }
  
  function get_data_by_id(option) {
    var response = false;
    if (option.type == undefined) {
      option.type = "POST";
    }
  
    if (option.async == undefined) {
      option.async = false;
    }
  
    $.ajax({
      url: option.url,
      type: option.type,
      async: option.async,
      data: option.data,
      dataType: "json",
      beforeSend: function () {
        if (option.button) {
          option.button.attr('disabled', true);
        }
  
        if (option.spinner) {
          option.spinner.show();
        }
      },
      success: function (data) {
        if (data.status) {
          response = data;
        } else {
          bootbox.alert({
            title: "Error",
            centerVertical: true,
            message: data.message,
            callback: function (result) {
              response = false;
            },
          });
        }
  
        if (option.button) {
          option.button.attr('disabled', false);
        }
        if (option.spinner) {
          option.spinner.hide();
        }
  
      },
      error: function (xhr, ajaxOptions, thrownError) {
        bootbox.alert({
          title: "Error",
          centerVertical: true,
          message:
            '<span class="text-danger"><i class="mdi mdi-alert"></i> Oops, terjadi kesalahan dalam menghubungkan ke server. Silahkan periksa koneksi anda terlebih dahulu.</span>',
        });
  
        if (option.button) {
          option.button.attr('disabled', false);
        }
        if (option.spinner) {
          option.spinner.hide();
        }
      },
    }).done(function(data) {
      if(option.onSuccess !== undefined){
        option.onSuccess(data);
      }
    });

    return response;
  }
  
  function ajax_load_html(option) {
    $.ajax({
      type: option.type,
      url: option.url,
      data: option.data,
      dataType: "json",
      error: function () {
        bx_alert(
          "Error: Gagal menghubungkan ke server cobalah mengulang halaman ini kembali",
          location.href
        );
      },
      success: function (res) {
        if (res.status == false) {
          if (res.confirmation !== undefined && res.confirmation == true) {
            if (res.data_confirmation !== undefined) {
              data_confirmation = res.data_confirmation;
            } else {
              data_confirmation = {};
            }
            option_confirm = {
              title: "Konfirmasi",
              message: res.message,
              data: data_confirmation,
              url: option.url,
            };
            btn_confirm_action(option_confirm);
          } else {
            bx_alert(res.message, location.href);
          }
        } else {
          option.divider.html(res.data);
          init_select2();
        }
      }
    });
  }
  
  function btn_confirm_action(option) {
    response = true;
    bootbox.confirm({
      title: option.title,
      message: option.message,
      centerVertical: true,
      buttons: {
        cancel: {
          label: "Tidak",
          className: "btn-danger",
        },
        confirm: {
          label: "Ya",
          className: "btn-info",
        },
      },
      callback: function (result) {
        if (result) {
          if (option.type == undefined) {
            type = "POST";
          } else {
            type = option.type;
          }
          $.ajax({
            url: option.url,
            type: type,
            data: option.data,
            dataType: "json",
            success: function (data) {
              bootbox.alert({
                title: "Notifikasi",
                centerVertical: true,
                message: data.message,
                callback: function (result) {
                  if (data.error !== undefined){
                    location.reload();
                  }else{
                    if (option.table) {
                      option.table.ajax.reload();
                    } else {
                      if (option.redirect != undefined) {
                        location.replace(option.redirect);
                      } else {
                        location.reload();
                      }
                    }
  
                    if(data.status !== undefined && data.status == true) {
                      response = true;
                    }else{
                      response = false;
                    }
                  }
                },
              });
            },
            error: function (xhr, ajaxOptions, thrownError) {
              bootbox.alert({
                title: "Error",
                centerVertical: true,
                message:
                  '<span class="text-danger"><i class="mdi mdi-alert"></i> Oops, terjadi kesalahan dalam menghubungkan ke server. Silahkan periksa koneksi anda terlebih dahulu.</span>',
              });
  
              response = false;
            },
          });
        }
      },
    });
  
    return response;
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
  
  function bx_alert_success(msg) {
    bootbox.dialog({
      message: '<i class="ion ion-md-checkmark-circle text-success"></i> ' + msg,
      closeButton: false,
      centerVertical: true,
      buttons: {
        add: {
          label: '<i class="icon-pen-plus mr-1"></i> Tambah data',
          className: "btn-info",
          callback: function (result) {
            if (result) {
              location.reload();
            }
          },
        },
        main: {
          label: '<i class="fa fa-chevron-left"></i> Kembali',
          className: "bg-success-400",
          callback: function (result) {
            if (result) {
              history.go(-1);
            }
          },
        },
      },
    });
  }
  
  function bx_alert_successUpadate(msg) {
    bootbox.dialog({
      message: '<i class="ion ion-md-checkmark-circle text-success"></i> ' + msg,
      closeButton: false,
      centerVertical: true,
      buttons: {
        main: {
          label: '<i class="fa fa-chevron-left"></i> Kembali',
          className: "bg-success-400",
          callback: function (result) {
            if (result) {
              history.go(-1);
            }
          },
        },
      },
    });
  }
  
  function bx_alert_ok(msg, redirect) {
    bxdialog = bootbox.dialog({
      message: '<i class="ion ion-md-checkmark-circle text-success"></i> ' + msg,
      closeButton: true,
      centerVertical: true,
      onEscape: function (result) {
        if (redirect != undefined) {
          location.replace(redirect);
        }
      },
    });
  
    setTimeout(function () {
      bxdialog.modal("hide");
      if (redirect != undefined) {
        location.replace(redirect);
      }
    }, 2500);
  }
  
  function check_valid_number(number) {
    if (Number.isNaN(number)) {
      return 0;
    } else {
      return number;
    }
  }