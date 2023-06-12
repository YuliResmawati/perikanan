<?php 

if (!function_exists('telegram_send'))
{
    function telegram_send(string $chat_id, string $message, array $option = [])
    {
        $CI = &get_instance();

        $payload = array(
            "chat_id" => decrypt_url($chat_id, "telegram_chat_id", false),
            "text" => $message,
            "parse_mode" => "html"
        );

        $payload = json_encode(array_merge($payload, $option));

        $ch = curl_init( $CI->telegram_uri_path . "/sendmessage" );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec($ch);
        curl_close($ch);
    }
}

?>