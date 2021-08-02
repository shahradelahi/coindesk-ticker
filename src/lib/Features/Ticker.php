<?php

namespace CoinDesk\Features;

use CoinDesk\Utils\WebSocket;
use Exception;

class Ticker
{

    /**
     * @var int
     */
    private int $CloseTime;

    private WebSocket $WebSocket;

    private $Connection;

    public function __construct()
    {
        require_once __DIR__ . '/../Utils/WebSocket.php';
        $this->WebSocket = new WebSocket();
    }

    /**
     * @param array $settings
     */
    private function Initialization(array $settings): void
    {
        ini_set('max_execution_time', '0');
        $this->CloseTime = $settings['close_time'] ?: 0;
    }

    private function subscribeChannel(WebSocket $WebSocket, $Connection): void
    {
        usleep(500 * 1000);
        $WebSocket->websocket_write($Connection, '{"type":"hello","version":"2","id":1}');
        usleep(500 * 1000);
        $WebSocket->websocket_write($Connection, '{"type":"sub","path":"/v2/ticker/all","id":2}');
        usleep(500 * 1000);
    }

    /**
     * @return bool
     * @throws Exception
     */
    private function makeConnection(): bool
    {
        if ($this->Connection = $this->WebSocket->websocket_open('production.api.coindesk.com', 443, '', $errstr, 10, true)) {

            // Starting for receiver
            return true;


        } else {
            throw new Exception("Connection Failed: $errstr");
        }
    }

    /**
     * @param $Query
     * @param array $Settings
     * @throws Exception
     */
    public function setTicker($Query, array $Settings): void
    {
        $this->Initialization($Settings);
        if ($this->makeConnection()) {

            // Subscribe to stream
            $this->subscribeChannel($this->WebSocket, $this->Connection);

            // Starting for receiver
            while ($this->CloseTime > time()) {
                $message = $this->WebSocket->websocket_read($this->Connection, $errstr);
                if ($message != "") {
                    $JsonMessage = json_decode($message, true);
                    if ($JsonMessage['type'] == "pub") {
                        $Query($JsonMessage['message']);
                    }
                }
            }

        }
    }

    /**
     * @throws Exception
     */
    public function getOneTick(): array|bool
    {
        $oneTick = false;
        if ($this->makeConnection()) {

            // Subscribe to stream
            $this->subscribeChannel($this->WebSocket, $this->Connection);

            // Setup close timer
            $this->CloseTime = strtotime('+10 second', time());

            // Starting for receiver
            while ($this->CloseTime > time()) {
                $message = $this->WebSocket->websocket_read($this->Connection, $errstr);
                if ($message != "") {
                    $JsonMessage = json_decode($message, true);
                    if ($JsonMessage['type'] == "pub") {

                        $oneTick = $JsonMessage['message'];
                        break;

                    }
                }
            }

        }

        return $oneTick;
    }

}