<?php

namespace Lr001001\Newpay\Gateways\Wechat;

use Symfony\Component\HttpFoundation\Request;
use Lr001001\Newpay\Events;
use Lr001001\Newpay\Exceptions\GatewayException;
use Lr001001\Newpay\Exceptions\InvalidArgumentException;
use Lr001001\Newpay\Exceptions\InvalidSignException;
use Yansongda\Supports\Collection;

class ScanGateway extends Gateway
{
    /**
     * Pay an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $endpoint
     *
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidSignException
     */
    public function pay($endpoint, array $payload): Collection
    {
        $payload['spbill_create_ip'] = Request::createFromGlobals()->server->get('SERVER_ADDR');
        $payload['trade_type'] = $this->getTradeType();

        Events::dispatch(new Events\PayStarted('Wechat', 'Scan', $endpoint, $payload));

        return $this->preOrder($payload);
    }

    /**
     * Get trade type config.
     *
     * @author yansongda <me@yansongda.cn>
     */
    protected function getTradeType(): string
    {
        return 'NATIVE';
    }
}
