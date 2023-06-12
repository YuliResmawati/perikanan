function btn_save_form(option) {
    response = true;
    if (option.async == undefined) {
        option.async = true;
    }
    $.ajax({
      url: option.url,
      type: "POST",
      async: option.async,
      data: option.data,
      dataType: "json",
      beforeSend: function () {
        $('#loading-process').show();
        if (option.submit_btn) {
          option.submit_btn.attr('disabled', true);
        }
        if (option.spinner) {
          option.spinner.show();
        }
        if (option.icon_save) {
          option.icon_save.hide();
        }
        if (option.button_value) {
          option.button_value.html('Loading...');
        }
      },
      success: function (data) {
        bootbox.alert({
          title: "Notifikasi",
          message: data.message,
          centerVertical: true,
          callback: function (result) {
            if(data.error !== undefined){
              if(data.redirect_link !== undefined) {
                location.replace(data.redirect_link);
              }else{
                location.reload();
              }
              
            }else{
              if(data.status !== undefined && data.status == true) {
                if (option.table) {
                  option.table.ajax.reload();
                } else {
                  if (data.redirect_link != undefined) {
                    location.replace(data.redirect_link);
                  } else if (option.redirect != undefined) {
                    location.replace(option.redirect);
                  } else {
                    location.reload();
                  }
                }
              }
            }

            if (option.submit_btn) {
              option.submit_btn.attr('disabled', false);
            }
            if (option.spinner) {
              option.spinner.hide();
            }
            if (option.icon_save) {
              option.icon_save.show();
            }
            if (option.button_value) {
              if (option.button_text) {
                option.button_value.html(option.button_text);
              } else {
                option.button_value.html('Simpan');
              }
            }

            if(grecaptcha !== undefined) {
              var c = $('.g-recaptcha').length;
              for (var i = 0; i < c; i++) {
                grecaptcha.reset(i);
              }
            }
          },
        });

        $('#loading-process').hide();
  
        response = data.status;
      },
      error: function (xhr, ajaxOptions, thrownError) {
        bootbox.alert({
          title: "Error",
          centerVertical: true,
          message:
            '<span class="text-danger"><i class="mdi mdi-alert"></i> Oops, terjadi kesalahan dalam menghubungkan ke server. Silahkan periksa koneksi anda terlebih dahulu.</span>',
        });
  
        if (option.submit_btn) {
          option.submit_btn.attr('disabled', false);
        }
        if (option.spinner) {
          option.spinner.hide();
        }
        if (option.icon_save) {
          option.icon_save.show();
        }
        if (option.button_value) {
          if (option.button_text) {
            option.button_value.html(option.button_text);
          } else {
            option.button_value.html('Simpan');
          }
        }

        $('#loading-process').hide();

        response = false;

        if(grecaptcha !== undefined) {
          var c = $('.g-recaptcha').length;
          for (var i = 0; i < c; i++) {
            grecaptcha.reset(i);
          }
        }
      },
    });
  
    return response;
}

function btn_save_form_with_file(option) {
  response = true;
  if (option.async == undefined) {
      option.async = true;
  }

  if (option.beforeSend == undefined) {
    option.beforeSend = () => {};
  }

  if (option.afterSend == undefined) {
    option.afterSend = () => {};
  }

  if (option.dontRedirect == undefined) {
    option.dontRedirect = false;
  }

  $.ajax({
    url: option.url,
    type: "POST",
    async: option.async,
    processData: false,
    contentType: false,
    data: option.data,
    dataType: "json",
    beforeSend: function () {
      option.beforeSend();
      $('#loading-process').show();
      if (option.submit_btn) {
        option.submit_btn.attr('disabled', true);
      }
      if (option.spinner) {
        option.spinner.show();
      }
      if (option.icon_save) {
        option.icon_save.hide();
      }
      if (option.button_value) {
        option.button_value.html('Loading...');
      }
    },
    success: function (data) {
      option.afterSend();

      bootbox.alert({
        title: "Notifikasi",
        message: data.message,
        centerVertical: true,
        callback: function (result) {
          if(data.error !== undefined){
            if(data.redirect_link !== undefined) {
              location.replace(data.redirect_link);
            }else{
              location.reload();
            }
          }else{
            if(data.status !== undefined && data.status == true) {
              if (option.table) {
                option.table.ajax.reload();
              } else {
                if (data.redirect_link != undefined) {
                  location.replace(data.redirect_link);
                } else if (option.redirect != undefined) {
                  location.replace(option.redirect);
                } else {
                  if(option.dontRedirect===false) {
                    location.reload();
                  }
                }
              }
            }
          }

          
          if (option.submit_btn) {
            option.submit_btn.attr('disabled', false);
          }
          if (option.spinner) {
            option.spinner.hide();
          }
          if (option.icon_save) {
            option.icon_save.show();
          }
          if (option.button_value) {
            if (option.button_text) {
              option.button_value.html(option.button_text);
            } else {
              option.button_value.html('Simpan');
            }
          }

          if(grecaptcha !== undefined) {
            var c = $('.g-recaptcha').length;
            for (var i = 0; i < c; i++) {
              grecaptcha.reset(i);
            }
          }
        },
      });

      $('#loading-process').hide();

      response = data.status;
    },
    error: function (xhr, ajaxOptions, thrownError) {
      option.afterSend();
      bootbox.alert({
        title: "Error",
        centerVertical: true,
        message:
          '<span class="text-danger"><i class="mdi mdi-alert"></i> Oops, terjadi kesalahan dalam menghubungkan ke server. Silahkan periksa koneksi anda terlebih dahulu.</span>',
      });

      if (option.submit_btn) {
        option.submit_btn.attr('disabled', false);
      }
      if (option.spinner) {
        option.spinner.hide();
      }
      if (option.icon_save) {
        option.icon_save.show();
      }
      if (option.button_value) {
        if (option.button_text) {
          option.button_value.html(option.button_text);
        } else {
          option.button_value.html('Simpan');
        }
      }

      $('#loading-process').hide();

      response = false;

      if(grecaptcha !== undefined) {
        var c = $('.g-recaptcha').length;
        for (var i = 0; i < c; i++) {
          grecaptcha.reset(i);
        }
      }

      
    },
  });

  return response;
}

function btn_action(option) {
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
       $('#loading-process').show();
        if (option.action_button) {
          option.action_button.attr('disabled', true);
        }
        if (option.spinner) {
          option.spinner.show();
        }
        if (option.icon_save) {
          option.icon_save.hide();
        }
        if (option.button_value) {
          option.button_value.html('Loading...');
        }
    },
    success: function (data) {
      bootbox.alert({
        title: "Notifikasi",
        message: data.message,
        centerVertical: true,
        callback: function (result) {
          if(data.error !== undefined){
            if(data.redirect_link !== undefined) {
              location.replace(data.redirect_link);
            }else{
              location.reload();
            }
            
          }else{
            if(data.status !== undefined && data.status == true) {
              if (option.table) {
                option.table.ajax.reload();
              } else {
                if (data.redirect_link != undefined) {
                  location.replace(data.redirect_link);
                } else if (option.redirect != undefined) {
                  location.replace(option.redirect);
                }
              }
            }
          }

          if (option.action_button) {
            option.action_button.attr('disabled', false);
          }
          if (option.spinner) {
            option.spinner.hide();
          }
          if (option.icon_save) {
            option.icon_save.show();
          }
          if (option.button_value) {
            option.button_value.html(option.button_text);
          }

          if(grecaptcha !== undefined) {
            var c = $('.g-recaptcha').length;
            for (var i = 0; i < c; i++) {
              grecaptcha.reset(i);
            }
          }
        },
      });

      $('#loading-process').hide();

      response = data.status;

    },
    error: function (xhr, ajaxOptions, thrownError) {
      bootbox.alert({
        title: "Error",
        centerVertical: true,
        message:
          '<span class="text-danger"><i class="mdi mdi-alert"></i> Oops, terjadi kesalahan dalam menghubungkan ke server. Silahkan periksa koneksi anda terlebih dahulu.</span>',
      });

      if (option.action_button) {
        option.action_button.attr('disabled', false);
      }
      if (option.spinner) {
        option.spinner.hide();
      }
      if (option.icon_save) {
        option.icon_save.show();
      }
      if (option.button_value) {
        option.button_value.html(option.button_text);
      }

      $('#loading-process').hide();

      response = false;
    },
  }).done(function(data) {
    if(option.onSuccess !== undefined){
      option.onSuccess(data);
    }
  });

  return response;
}

function request_custom(option) {
  response = true;

  if (option.async == undefined) {
    option.async = true;
  }

  if (option.type == undefined) {
    option.type = "POST";
  }

  $.ajax({
    url: option.url,
    type: option.type,
    async: option.async,
    data: option.data,
    dataType: "json",
    beforeSend: function () {
      $('#loading-process').show();
      if (option.submit_btn) {
        option.submit_btn.attr('disabled', true);
      }
      if (option.spinner) {
        option.spinner.show();
      }
      if (option.icon_button) {
        option.icon_button.hide();
      }
      if (option.button_value) {
        option.button_value.html('Loading...');
      }
    },
    success: function (data) {
      if (data.status) {
        bootbox.alert({
          title: "Notifikasi",
          message: data.message,
          centerVertical: true,
          callback: function (result) {
            if(data.error !== undefined){
              if(data.redirect_link !== undefined) {
                location.replace(data.redirect_link);
              }else{
                location.reload();
              }
            }else{
              if(data.status !== undefined && data.status == true) {
                if (option.table) {
                  option.table.ajax.reload();
                } else {
                  if (data.redirect_link != undefined) {
                    location.replace(data.redirect_link);
                  } else if (option.redirect != undefined) {
                    location.replace(option.redirect);
                  } else {
                    location.reload();
                  }
                }
              }
            }
          },
        });
        response = data.status;
      } else if (data.hidemsg == undefined || data.hidemsg == false) {
        bootbox.alert({
          title: "Error",
          centerVertical: true,
          message: data.message,
          callback: function (result) {
            response = false;
          },
        });
      }

      if (option.submit_btn) {
        option.submit_btn.attr('disabled', false);
      }
      if (option.spinner) {
        option.spinner.hide();
      }
      if (option.icon_button) {
        option.icon_button.show();
      }
      if (option.button_value) {
        if (option.button_text) {
          option.button_value.html(option.button_text);
        }
      }

      $('#loading-process').hide();
    },
    error: function (xhr, ajaxOptions, thrownError) {
      bootbox.alert({
        title: "Error",
        centerVertical: true,
        message:
          '<span class="text-danger"><i class="mdi mdi-alert"></i> Oops, terjadi kesalahan dalam menghubungkan ke server. Silahkan periksa koneksi anda terlebih dahulu.</span>',
      });

      if (option.submit_btn) {
        option.submit_btn.attr('disabled', false);
      }
      if (option.spinner) {
        option.spinner.hide();
      }
      if (option.icon_button) {
        option.icon_button.show();
      }
      if (option.button_value) {
        if (option.button_text) {
          option.button_value.html(option.button_text);
        }
      }

      $('#loading-process').hide();    
    },
  }).done(function (data) {
    if (option.onSuccess !== undefined) {
      option.onSuccess(data);
    }
  });

  return response;
}