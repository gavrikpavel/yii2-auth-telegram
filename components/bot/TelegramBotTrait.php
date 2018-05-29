<?php

namespace app\components\bot;

use \Exception;

trait TelegramBotTrait
{
    private $token = '***Bot Token***';

    /**
     * @param string $method
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    public function request($method, $params = array()) {
        $url = 'https://api.telegram.org/bot' . $this->token . '/' . $method . http_build_query($params);

        $raw = $this->exeCurl($url, 60);
            $response = json_decode($raw, true);
            if ($response['ok'] & $response['result']) {
                return $data = end($response['result']);
            } else {
                return false;
            }
    }

    /**
     * @param string $url
     * @param int $timeout
     * @return mixed
     * @throws Exception
     */
    private function exeCurl($url, $timeout)
    {
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_ENCODING => '',
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_RETURNTRANSFER => 1,
        ]);
        $raw = curl_exec($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);
        if (strncmp('20', $info['http_code'], 2) === 0) {
            return $raw;
        }
        //elseif ($info['http_code'] >= 400) {throw new Exception("Error Curl");}
    }
}