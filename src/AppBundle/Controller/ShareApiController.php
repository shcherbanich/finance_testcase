<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Share controller.
 *
 * @Route("/shares/api")
 */
class ShareApiController extends Controller
{

    /**
     *
     * @Route("/get-name", name="get_share_name")
     * @Method("GET")
     */
    public function nameAction()
    {

        $request = Request::createFromGlobals();

        $share = $request->query->get('q');

        $cache = $this->get('cache');

        $cache->setNamespace('api.nameAction1.cache');

        if (false === ($cached_data = $cache->fetch($share))) {

            $client = new \GuzzleHttp\Client();

            $request = $client->createRequest('GET', "https://s.yimg.com/aq/autoc?query={$share}&lang=en-US&callback=YAHOO.util.UHScriptNodeDataSource.callbacks", ['exceptions' => false]);

            $response = $client->send($request);

            $json = str_replace('YAHOO.util.UHScriptNodeDataSource.callbacks(', '', $response->getBody());

            $cached_data = str_replace(']}})', ']}}', $json);

            $cache->save($share, $cached_data, 3600);
        }

        $response = new JsonResponse(json_decode($cached_data));

        $response->setPublic();
        $response->setMaxAge(600);
        $response->setSharedMaxAge(600);
        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }

    /**
     *
     * @Route("/chart/{share}", name="get_chart")
     * @Method("GET")
     */
    public function chartAction($share)
    {

        $cache = $this->get('cache');

        $cache->setNamespace('api.chartAction.cache');

        if (false === ($cached_data = $cache->fetch($share))) {

            $client = new \GuzzleHttp\Client();

            $request = $client->createRequest('GET', 'https://finance-yql.media.yahoo.com/v7/finance/chart/' . $share, ['exceptions' => false]);

            $time = time();

            $request->setQuery([
                'period1' => ($time - 63113851),
                'period2' => $time,
                'interval' => '1d'
            ]);

            $cached_data = $client->send($request)->json();

            $cache->save($share, $cached_data, 3600);
        }

        $response = new JsonResponse($cached_data);

        $response->setPublic();
        $response->setMaxAge(600);
        $response->setSharedMaxAge(600);

        $response->headers->addCacheControlDirective('must-revalidate', true);

        return $response;
    }
}
