<?php

declare(strict_types=1);

namespace App\Presenters;

use App\ApiEvaluator\RecipeJsonRPCEvaluator;
use Datto\JsonRpc\Server;
use Nette;
use Nette\Application\Responses\VoidResponse;


final class HomepagePresenter extends Nette\Application\UI\Presenter
{

    public function __construct(private readonly RecipeJsonRPCEvaluator $evaluator)
    {
        parent::__construct();
    }

    public function renderDefault()
    {
        $server = new Server($this->evaluator);
        try {
            $request_array = Nette\Utils\Json::decode($this->getHttpRequest()->getRawBody(), JSON_OBJECT_AS_ARRAY);
            $reply = $server->rawReply($request_array);

            if (is_array($reply)) {
                $this->sendJson($reply);
            } else {
                $this->getHttpResponse()->setCode(Nette\Http\Response::S204_NO_CONTENT);
                $this->sendResponse(new VoidResponse());
            }
        } catch (Nette\Utils\JsonException $e) {
            $this->getHttpResponse()->setCode(Nette\Http\Response::S400_BAD_REQUEST, $e->getMessage());
            $this->sendResponse(new VoidResponse());
        }

    }
}
