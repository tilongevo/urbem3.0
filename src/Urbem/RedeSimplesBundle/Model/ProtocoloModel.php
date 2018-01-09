<?php

namespace Urbem\RedeSimplesBundle\Model;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Urbem\CoreBundle\AbstractModel;
use Urbem\CoreBundle\Entity\Administracao\Usuario;
use Urbem\CoreBundle\Entity\RedeSimples\Protocolo;
use Urbem\CoreBundle\Entity\RedeSimples\ProtocoloItem;
use Urbem\RedeSimplesBundle\Service\Protocolo\ProtocoloException;
use Urbem\RedeSimplesBundle\Service\Protocolo\Result\Fetch\FieldInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\Result\Send\SendResponseInterface;
use Urbem\RedeSimplesBundle\Service\Protocolo\Result\Status\StatusResponseInterface;

class ProtocoloModel extends AbstractModel
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var EntityRepository
     */
    protected $repository;

    /**
     * ProtocoloModel constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $this->entityManager->getRepository("CoreBundle:RedeSimples\Protocolo");
    }

    protected function convertType(FormInterface $form)
    {
        $type = get_class($form->getConfig()->getType()->getInnerType());

        if (TextType::class === $type) {
            return 'text';
        }

        if (TextareaType::class === $type) {
            return 'textarea';
        }

        /* http://symfony.com/doc/current/reference/forms/types/choice.html */
        $expanded = $form->getConfig()->getOption('expanded');
        $multiple = $form->getConfig()->getOption('multiple');

        if (false === $expanded && false === $multiple) {
            return 'select';
        }

        if (false === $expanded && true === $multiple) {
            return 'multiple';
        }

        if (true === $expanded && false === $multiple) {
            return 'radio';
        }

        return 'checkbox';
    }

    protected function convertValue(FormInterface $form)
    {
        $data = $form->getData();

        if (false === $form->getConfig()->hasOption('choices')) {
            return json_encode($data);
        }

        $data = false === is_array($data) ? [$data] : $data;

        $data = array_filter(array_flip($form->getConfig()->getOption('choices')), function ($key) use ($data) {
            return true === in_array($key, $data);
        }, ARRAY_FILTER_USE_KEY);

        return json_encode($data);
    }

    public function normalizeObjectByForm(Protocolo $protocolo, Usuario $usuario, FormInterface $form)
    {
        $protocolo->setStatus(Protocolo::STATUS_CRIADO);
        $protocolo->setDataCriacao(new \DateTime());
        $protocolo->setFkAdministracaoUsuario($usuario);

        /** @var FormInterface $item */
        foreach ($form as $item) {
            $protocoloItem = new ProtocoloItem();
            $protocoloItem->setCampo($item->getConfig()->getOption('label'));
            $protocoloItem->setIdentificador($item->getName());
            $protocoloItem->setValor($this->convertValue($item));
            $protocoloItem->setTipo($this->convertType($item));

            $protocolo->addFkRedeSimplesProtocoloItem($protocoloItem);
        }

        return $protocolo;
    }

    /**
     * @param Protocolo $protocolo
     * @return array
     */
    public function getDataToSend(Protocolo $protocolo)
    {
        $data = [];

        /** @var ProtocoloItem $item */
        foreach ($protocolo->getFkRedeSimplesProtocoloItens() as $item) {
            $valor = json_decode($item->getValor(), true);
            $valor = true === is_array($valor) ? current($valor) : $valor;

            $data[$item->getIdentificador()] = $valor;
        }

        return $data;
    }

    /**
     * @param Protocolo $protocolo
     * @param SendResponseInterface $response
     * @return Protocolo
     */
    public function setNumeroProtocolo(Protocolo $protocolo, SendResponseInterface $response)
    {
        $protocolo->setProtocolo($response->getProtocolo());
        $protocolo->setStatus(Protocolo::STATUS_AGUARDANDO);
        $protocolo->setDataUltimaConsulta(new \DateTime());

        $this->entityManager->persist($protocolo);
        $this->entityManager->flush();

        return $protocolo;
    }

    /**
     * @return array
     */
    public function getAvailableStatus()
    {
        return [
            Protocolo::STATUS_CRIADO => Protocolo::STATUS_CRIADO,
            Protocolo::STATUS_AGUARDANDO => Protocolo::STATUS_AGUARDANDO,
            Protocolo::STATUS_FINALIZADO => Protocolo::STATUS_FINALIZADO,
            Protocolo::STATUS_PROTOCOLADO => Protocolo::STATUS_PROTOCOLADO,
            Protocolo::STATUS_RECEBIDO => Protocolo::STATUS_RECEBIDO,
            Protocolo::STATUS_DIGITALIZADO => Protocolo::STATUS_DIGITALIZADO,
            Protocolo::STATUS_DISTRIBUIDO => Protocolo::STATUS_DISTRIBUIDO,
            Protocolo::STATUS_CONCLUIDO => Protocolo::STATUS_CONCLUIDO,
            Protocolo::STATUS_INDEFERIDO => Protocolo::STATUS_INDEFERIDO,
        ];
    }

    /**
     * @param Protocolo $protocolo
     * @return bool
     */
    public function canCheckStatus(Protocolo $protocolo)
    {
        return null !== $protocolo->getId() &&
            0 < strlen($protocolo->getProtocolo()) &&
            $protocolo->getStatus() !== Protocolo::STATUS_FINALIZADO;
    }

    /**
     * @param Protocolo $protocolo
     * @param StatusResponseInterface $response
     * @return Protocolo
     * @throws ProtocoloException
     */
    public function setChecked(Protocolo $protocolo, StatusResponseInterface $response)
    {
        if (false === is_string($response->getStatus()) || true === is_null($response->getStatus())) {
            throw ProtocoloException::expectedType('$status', 'string', $response->getStatus());
        }

        if (false === is_string($response->getMensagem()) || true === is_null($response->getMensagem())) {
            throw ProtocoloException::expectedType('$mensagem', 'string', $response->getMensagem());
        }

        if (false === in_array($response->getStatus(), $this->getAvailableStatus())) {
            throw new \OutOfBoundsException(sprintf(
                '$status %s is not available',
                $response->getStatus()
            ));
        }

        $protocolo->setStatus($response->getStatus());
        $protocolo->setDataUltimaConsulta(new \DateTime());
        $protocolo->setRetorno($response->getMensagem());

        /** @var FieldInterface $field */
        foreach ($response->getFields() as $field) {
            $protocoloItem = $protocolo->getFkRedeSimplesProtocoloItens()->filter(function (ProtocoloItem $item) use ($field) {
                return $item->getIdentificador() === $field->getName();
            });

            $protocoloItem = $protocoloItem->first();

            if (false === ($protocoloItem instanceof ProtocoloItem)) {
                $protocoloItem = new ProtocoloItem();
            }

            $options = $field->getOptions();

            $protocoloItem->setCampo($options['label']);
            $protocoloItem->setIdentificador($field->getName());
            $protocoloItem->setValor(json_encode($options['data']));
            $protocoloItem->setTipo('text');

            $this->entityManager->persist($protocoloItem);

            $protocolo->addFkRedeSimplesProtocoloItem($protocoloItem);
        }

        $this->entityManager->persist($protocolo);
        $this->entityManager->flush();

        return $protocolo;
    }
}
