<?php

namespace CoinDesk;

use Amp\Http\Client\HttpException;
use Amp\Promise;
use Amp\Websocket\Client\Connection;
use Amp\Websocket\Client\ConnectionException;
use Amp\Websocket\ClosedException;
use Amp\Websocket\Message;
use CoinDesk\Features\Ticker;
use CoinDesk\Utils\ApiRequest;

/**
 * Api
 *
 * @link    https://github.com/shahradelahi/coindesk-ticker
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/shahradelahi/coindesk-ticker/blob/master/LICENSE (MIT License)
 */
class Api
{

    /**
     * @var ApiRequest
     */
    private ApiRequest $ApiRequest;

    private Ticker $Ticker;

    /**
     * @return ApiRequest
     */
    private function getApiRequest(): ApiRequest
    {
        $this->ApiRequest = $this->ApiRequest ?: new ApiRequest();
        return $this->ApiRequest;
    }

    /**
     * @return Ticker
     */
    public function ticker(): Ticker
    {
        $this->Ticker = $this->Ticker ?: new Ticker();
        return $this->Ticker;
    }

    /**
     * It's just current price of Bitcoin in 3 different pairs.
     * Pairs: USD, EUR, GBP
     *
     * @return array
     */
    public function getCurrentPrice(): array
    {
        return $this->getApiRequest()->sendRequest("bpi/currentprice.json");
    }

}