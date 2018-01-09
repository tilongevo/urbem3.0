<?php

namespace Urbem\RedeSimplesBundle\Service\Protocolo;

use Sonata\AdminBundle\Form\FormMapper;
use Urbem\RedeSimplesBundle\Service\Protocolo\Cache\CacheInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherParameters;
use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherResult;
use Urbem\RedeSimplesBundle\Service\Protocolo\Fetch\FetcherResultInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\Parse\ParserInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\Parse\ProcessorInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\Result\Fetch\FieldCollectionInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\Result\Fetch\FieldInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\Result\Fetch;

class FormBuilder
{
    /**
     * @var ProcessorInterface
     */
    protected $processor;

    /**
     * @var FetcherInterface
     */
    protected $fetcher;

    /**
     * @var ParserInterface
     */
    protected $parser;

    /**
     * @var CacheInterface
     */
    protected $cache;

    /**
     * @var ParameterBagInterface
     */
    protected $parameters;

    /**
     * This service is created on
     * src/Urbem/RedeSimplesBundle/DependencyInjection/RedeSimplesExtension.php
     *
     * The parameters definition are located on
     * src/Urbem/RedeSimplesBundle/DependencyInjection/Configuration.php
     *
     * FormBuilder constructor.
     * @param FetcherInterface $fetcher
     * @param ProcessorInterface $processor
     * @param ParserInterface $parser
     * @param CacheInterface $cache
     * @param ParameterBagInterface $parameters
     */
    public function __construct(
        ProcessorInterface $processor,
        FetcherInterface $fetcher,
        ParserInterface $parser,
        CacheInterface $cache,
        ParameterBagInterface $parameters
    ) {
        $this->processor = $processor;
        $this->fetcher = $fetcher;
        $this->parser = $parser;
        $this->cache = $cache;
        $this->parameters = $parameters;
    }

    /**
     * @param FormMapper $formMapper
     * @return FormMapper
     * @throws ProtocoloException
     */
    public function build(FormMapper $formMapper)
    {
        $result = $this->processor->process($this->getCachedResult(), $this->parser);

        if (false === is_object($result) || false === is_subclass_of($result, FieldCollectionInterface::class)) {
            throw ProtocoloException::expectedMethodReturnType(ProcessorInterface::class, 'process', FieldCollectionInterface::class, $result);
        }

        if (0 === $result->count()) {
            return $formMapper;
        }

        /** @var $result FieldCollectionInterface */
        /** @var $field FieldInterface */
        foreach ($result as $field) {
            if ($this->processTitleSeparator($formMapper, $field)) {
                continue;
            }

            $formMapper->add($field->getName(), $field->getType(), $field->getOptions());
        }

        $formMapper->hasOpenTab() === true ? $formMapper->end() : null;
        return $formMapper;
    }

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\RedeSimplesBundle\Service\Protocolo\Result\Fetch\FieldInterface $field
     * @return bool
     */
    protected function processTitleSeparator(FormMapper $formMapper, FieldInterface $field)
    {
        if ($field->getType() != Fetch\Field::TYPE_TITLE) {
            return false;
        }

        if ($formMapper->hasOpenTab()) {
            $formMapper->end();
        }

        $formMapper->with($field->getName());
        return true;
    }

    /**
     * @param bool $opened
     */
    protected function setTitleOpened($opened = false)
    {
        $this->titleOpened = $opened;
    }

    /**
     * @return FetcherResultInterface
     * @throws ProtocoloException
     */
    public function getCachedResult()
    {
        $cacheKey = $this->parameters->get(ParameterBag::CACHE_KEY);

        if (true === $this->cache->has($cacheKey)) {
            return unserialize($this->cache->get($cacheKey));
        }

        $result = $this->fetcher->fetch(new FetcherParameters([
            FetcherParameters::ENDPOINT => $this->parameters->get(ParameterBag::ENDPOINT_FETCH),
            FetcherParameters::TOKEN => $this->parameters->get(ParameterBag::ENDPOINT_TOKEN)
        ]));

        if (false === is_object($result) || false === is_subclass_of($result, FetcherResultInterface::class)) {
            throw ProtocoloException::expectedMethodReturnType(FetcherInterface::class, 'fetch', FetcherResultInterface::class, $result);
        }

        if (FetcherResult::OK !== $result->getCode()) {
            throw ProtocoloException::invalidResponse($result);
        }

        $this->cache->set($cacheKey, serialize($result));

        return $result;
    }

    /**
     * Remove the current FORM cache
     *
     * @return void
     */
    public function removeCachedResult()
    {
        $cacheKey = $this->parameters->get(ParameterBag::CACHE_KEY);

        if (true === $this->cache->has($cacheKey)) {
            $this->cache->remove($cacheKey);
        }
    }
}
