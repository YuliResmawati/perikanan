<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?= $page_title.' | '.$site_name ?></title> 
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
  </head>

  <body width="100%" style="min-height: 1vh; max-width: 600px; margin: 0 auto;margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #f1f1f1;font-family: 'Lato', sans-serif; color: #000000">	
    <div style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
      Kami mendeteksi percobaan <b><?= $description ?></b> pada akun anda
    </div>
    <table role="presentation" align="center" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
      <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 1em 0; background: #ffffff;" style="text-align: center;">
          <img src="<?= base_url('assets/global/images/email_icon.png') ?>" alt="" style="width: 75px; max-width: 100px; height: auto; margin: auto; display: block;">
        </td>
      </tr>
      <tr>
        <td valign="middle" class="hero bg_white" style="padding: 2em 0 4em 0; background: #ffffff;text-align: center;">
          <h2>Hi <?= $email_receiver ?></h2>
          <h3>JANGAN BERI kode ini ke siapapun, termasuk pihak SIMPEG Agam. WASPADA pencurian data akun anda. Kode ini hanya berlaku 5 menit.</h3>
          <h3><?= $otp ?></h3>
          <h4>Kode diatas merupakan Kode OTP reset kata sandi akun simpeg anda. Jika anda merasa tidak pernah melakukan reset kata sandi akun, abaikan email ini dan segera lakukan pergantian kata sandi anda demi kemanan akun.</h4>
        </td>
      </tr>
      <tr>
        <td class="hero bg_light" style="text-align: center;">
          <p><?= date('Y') ?> &copy; <strong class="text-dark"><?= $site_name ?></strong> by <a href="https://agamkab.go.id" class="text-dark"><strong><?= $regency ?></strong></a></p>
        </td>
      </tr>
    </table>
  </body>
</html>