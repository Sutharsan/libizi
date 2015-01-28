<?php

/**
 * @file
 * Contains \Triquanta\IziTravel\Client\MtgObjectClient.
 */

namespace Triquanta\IziTravel\Client;

use Triquanta\IziTravel\DataType\FullMtgObject;

/**
 * Provides a client that handles MTGObjects.
 */
class MtgObjectClient implements MtgObjectClientInterface {

    /**
     * The request handler.
     *
     * @var \Triquanta\IziTravel\Client\RequestHandlerInterface
     */
    protected $requestHandler;

    /**
     * Constructs a new instance.
     *
     * @param \Triquanta\IziTravel\Client\RequestHandlerInterface $requestHandler
     */
    public function __construct(RequestHandlerInterface $requestHandler) {
        $this->requestHandler = $requestHandler;
    }

    public function getMtgObjectByUuid($uuid, array $languages) {
        return $this->getMtgObjectsByUuids([$uuid], $languages)[0];
    }

    public function getMtgObjectsByUuids(array $uuids, array $languages) {
        $json = $this->requestHandler->request('/mtgobjects/' . implode(',', $uuids), [
          'languages' => $languages,
        ]);
        $data = json_decode($json);
        $objects = [];
        foreach ($data as $object_data) {
            $objects[] = FullMtgObject::createFromData($object_data);
        }

        return $objects;
    }

}