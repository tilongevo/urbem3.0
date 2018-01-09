<?php

namespace Urbem\PrestacaoContasBundle\Service\TribunalStrategy;

use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Twig\TwigEngine;

/**
 * Interface ConfiguracaoInterface
 * @package Urbem\PrestacaoContasBundle\Service\TribunalStrategy
 */
interface ConfiguracaoInterface
{
    /**
     * @return mixed Adiciona JS nas páginas montadas dinâmicamente
     */
    function includeJs();

    /**
     * @return mixed Processa todos os parametros recebidos via formulário
     */
    function processParameters();

    /**
     * @return mixed Adiciona blocos dinâmicos a página processada
     */
    function dynamicBlockJs();

    /**
     * @return mixed Salva conteúdo dinâmico de acordo com sua factory
     */
    function save();

    /**
     * @return mixed Realiza processamento de serviço com chamada via AJAX
     */
    function buildServiceProvider(TwigEngine $templating = null);

    /**
     * @param \Sonata\AdminBundle\Form\FormMapper $formMapper
     * @param \Urbem\PrestacaoContasBundle\Service\TribunalStrategy\TceInterface $objectAdmin
     * @return mixed
     */
    function view(FormMapper $formMapper, TceInterface $objectAdmin);
}