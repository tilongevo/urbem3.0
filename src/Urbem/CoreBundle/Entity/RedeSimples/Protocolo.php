<?php

namespace Urbem\CoreBundle\Entity\RedeSimples;

/**
 * Protocolo
 */
class Protocolo
{
    const STATUS_CRIADO = 'CRIADO';
    const STATUS_AGUARDANDO = 'AGUARDANDO';
    const STATUS_FINALIZADO = 'CONCLUÍDO';

    // Status Ferramenta BPM
    const STATUS_PROTOCOLADO = 'PROTOCOLADO';
    const STATUS_RECEBIDO = 'RECEBIDO';
    const STATUS_DIGITALIZADO = 'DIGITALIZADO';
    const STATUS_DISTRIBUIDO = 'DISTRIBUÍDO';
    const STATUS_CONCLUIDO = 'CONCLUÍDO';
    const STATUS_INDEFERIDO = 'INDEFERIDO';

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $protocolo;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $retorno;

    /**
     * @var \DateTime
     */
    private $dataCriacao;

    /**
     * @var \DateTime
     */
    private $dataUltimaConsulta;

    /**
     * @var \Doctrine\Common\Collections\Collection|ProtocoloItem
     */
    private $fkRedeSimplesProtocoloItens;

    /**
     * @var \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    private $fkAdministracaoUsuario;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkRedeSimplesProtocoloItens = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dataCriacao = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set protocolo
     *
     * @param string $protocolo
     *
     * @return Protocolo
     */
    public function setProtocolo($protocolo)
    {
        $this->protocolo = $protocolo;

        return $this;
    }

    /**
     * Get protocolo
     *
     * @return string
     */
    public function getProtocolo()
    {
        return $this->protocolo;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Protocolo
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set retorno
     *
     * @param string $retorno
     *
     * @return Protocolo
     */
    public function setRetorno($retorno)
    {
        $this->retorno = $retorno;

        return $this;
    }

    /**
     * Get retorno
     *
     * @return string
     */
    public function getRetorno()
    {
        return $this->retorno;
    }

    /**
     * Set dataCriacao
     *
     * @param \DateTime $dataCriacao
     *
     * @return Protocolo
     */
    public function setDataCriacao(\DateTime $dataCriacao)
    {
        $this->dataCriacao = $dataCriacao;

        return $this;
    }

    /**
     * Get dataCriacao
     *
     * @return \DateTime|null
     */
    public function getDataCriacao()
    {
        return $this->dataCriacao;
    }

    /**
     * Set dataUltimaConsulta
     *
     * @param \DateTime $dataUltimaConsulta
     *
     * @return Protocolo
     */
    public function setDataUltimaConsulta(\DateTime $dataUltimaConsulta)
    {
        $this->dataUltimaConsulta = $dataUltimaConsulta;

        return $this;
    }

    /**
     * Get dataUltimaConsulta
     *
     * @return \DateTime
     */
    public function getDataUltimaConsulta()
    {
        return $this->dataUltimaConsulta;
    }

    /**
     * Add fkRedeSimplesProtocoloIten
     *
     * @param ProtocoloItem $fkRedeSimplesProtocoloItem
     *
     * @return Protocolo
     */
    public function addFkRedeSimplesProtocoloItem(ProtocoloItem $fkRedeSimplesProtocoloItem)
    {
        if (false === $this->fkRedeSimplesProtocoloItens->contains($fkRedeSimplesProtocoloItem)) {
            $fkRedeSimplesProtocoloItem->setFkProtocoloRedeSimplesProtocolo($this);

            $this->fkRedeSimplesProtocoloItens[] = $fkRedeSimplesProtocoloItem;
        }

        return $this;
    }

    /**
     * Remove fkRedeSimplesProtocoloIten
     *
     * @param ProtocoloItem $fkRedeSimplesProtocoloItem
     */
    public function removeFkRedeSimplesProtocoloItem(ProtocoloItem $fkRedeSimplesProtocoloItem)
    {
        $this->fkRedeSimplesProtocoloItens->removeElement($fkRedeSimplesProtocoloItem);
    }

    /**
     * Get fkRedeSimplesProtocoloItens
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFkRedeSimplesProtocoloItens()
    {
        return $this->fkRedeSimplesProtocoloItens;
    }

    /**
     * Set fkAdministracaoUsuario
     *
     * @param \Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario
     *
     * @return Protocolo
     */
    public function setFkAdministracaoUsuario(\Urbem\CoreBundle\Entity\Administracao\Usuario $fkAdministracaoUsuario)
    {
        $this->fkAdministracaoUsuario = $fkAdministracaoUsuario;

        return $this;
    }

    /**
     * Get fkAdministracaoUsuario
     *
     * @return \Urbem\CoreBundle\Entity\Administracao\Usuario
     */
    public function getFkAdministracaoUsuario()
    {
        return $this->fkAdministracaoUsuario;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s/%s', $this->protocolo, $this->dataCriacao->format('dmY'));
    }
}
