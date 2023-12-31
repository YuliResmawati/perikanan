<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
defined('RECAPTCHA_SITE_KEY')                 OR define('RECAPTCHA_SITE_KEY', '6LcD97UoAAAAAJwb0pE-2ZHb52dLKi2LIL2Jknju');
defined('RECAPTCHA_SITE_SECRET')              OR define('RECAPTCHA_SITE_SECRET', '6LcD97UoAAAAALqsjqONgRBxBzKHgVXTzCpuXo3Y');
defined('RECAPTCHA_ACCEPTABLE_SPAM_SCORE')    OR define('RECAPTCHA_ACCEPTABLE_SPAM_SCORE', 0.5);

if(!function_exists('get_recapture_score')) {
    function get_recapture_score($secret){
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $request = $url .'?secret='.RECAPTCHA_SITE_SECRET.'&response='.$secret.'';
        $response = file_get_contents($request);
        $response = json_decode($response);

        if($response->success == false){
            foreach($response->{'error-codes'} as $code){
                switch ($code){
                    case 'missing-input-secret':
                        log_message('error', 'RECAPTCHA: The secret parameter is missing. ' . $request);
                        break;
                    case 'invalid-input-secret':
                        log_message('error', 'RECAPTCHA: The secret parameter is invalid or malformed. '. $request);
                        break;
                    case 'missing-input-response':
                        log_message('error', 'RECAPTCHA: The response parameter is missing. '. $request);
                        break;
                    case 'invalid-input-response':
                        log_message('error', 'RECAPTCHA: The response parameter is invalid or malformed. ' . $request);
                        break;
                    case 'bad-request':
                        log_message('error', 'RECAPTCHA: The request is invalid or malformed. ' . $request);
                        break;
                    case 'timeout-or-duplicate':
                        log_message('error', 'RECAPTCHA: The response is no longer valid: either is too old or has been used previously.');
                        break;
                    default:
                        log_message('error', 'RECAPTCHA: Unknown error');
                }
            }
            return 0;
        }

        return $response->score;
    }
}