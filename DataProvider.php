<?php

/**
 * Class DataProvider
 */
class DataProvider
{
    /** @var Client */
    private Client $client;

    /** @var CacheItemPoolInterface */
    private CacheItemPoolInterface $cache;

    /** @var ILogger */
    private ILogger $logger;

    /**
     * DataProvider constructor.
     *
     * @param Client                 $client
     * @param CacheItemPoolInterface $cache
     * @param ILogger                $logger
     */
    public function __construct(
        Client $client,
        CacheItemPoolInterface $cache,
        ILogger $logger
    ) {
        $this->client = $client;
        $this->cache = $cache;
        $this->logger = $logger;
    }

    /**
     * @param array $input
     *
     * @return array
     *
     * @throws Exception
     */
    public function getResponse(array $input): array
    {
        try {
            $cacheKey = $this->getCacheKey($input);
            $cacheItem = $this->cache->getItem($cacheKey);

            if (!$cacheItem->isHit()) {
                $cacheItem->set($this->getResult($input));
                $this->cache->save($cacheItem);
            }

            return $cacheItem->get();
        } catch (Exception $e) {
            $this->logger->critical($e);

            throw $e;
        }
    }

    /**
     * @param array $input
     *
     * @return array
     */
    private function getResult(array $input): array
    {
        $dto = (new GetDataRequest())
            ->setName($input['name'])
            ->setArray($input['array']);

        return $this->client->getData($dto);
    }

    /**
     * @param array $input
     *
     * @return string
     */
    private function getCacheKey(array $input): string
    {
        return md5(json_encode($input));
    }
}
