<?php
 
namespace Urbem\CoreBundle\Entity\Ponto;

/**
 * ImportacaoPonto
 */
class ImportacaoPonto
{
    /**
     * PK
     * @var integer
     */
    private $codPonto;

    /**
     * PK
     * @var integer
     */
    private $codContrato;

    /**
     * PK
     * @var integer
     */
    private $codImportacao;

    /**
     * @var integer
     */
    private $codFormato;

    /**
     * @var \DateTime
     */
    private $dtPonto;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ImportacaoPontoHorario
     */
    private $fkPontoImportacaoPontoHorarios;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    private $fkPessoalContrato;

    /**
     * ManyToOne
     * @var \Urbem\CoreBundle\Entity\Ponto\FormatoImportacao
     */
    private $fkPontoFormatoImportacao;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPontoImportacaoPontoHorarios = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codPonto
     *
     * @param integer $codPonto
     * @return ImportacaoPonto
     */
    public function setCodPonto($codPonto)
    {
        $this->codPonto = $codPonto;
        return $this;
    }

    /**
     * Get codPonto
     *
     * @return integer
     */
    public function getCodPonto()
    {
        return $this->codPonto;
    }

    /**
     * Set codContrato
     *
     * @param integer $codContrato
     * @return ImportacaoPonto
     */
    public function setCodContrato($codContrato)
    {
        $this->codContrato = $codContrato;
        return $this;
    }

    /**
     * Get codContrato
     *
     * @return integer
     */
    public function getCodContrato()
    {
        return $this->codContrato;
    }

    /**
     * Set codImportacao
     *
     * @param integer $codImportacao
     * @return ImportacaoPonto
     */
    public function setCodImportacao($codImportacao)
    {
        $this->codImportacao = $codImportacao;
        return $this;
    }

    /**
     * Get codImportacao
     *
     * @return integer
     */
    public function getCodImportacao()
    {
        return $this->codImportacao;
    }

    /**
     * Set codFormato
     *
     * @param integer $codFormato
     * @return ImportacaoPonto
     */
    public function setCodFormato($codFormato)
    {
        $this->codFormato = $codFormato;
        return $this;
    }

    /**
     * Get codFormato
     *
     * @return integer
     */
    public function getCodFormato()
    {
        return $this->codFormato;
    }

    /**
     * Set dtPonto
     *
     * @param \DateTime $dtPonto
     * @return ImportacaoPonto
     */
    public function setDtPonto(\DateTime $dtPonto)
    {
        $this->dtPonto = $dtPonto;
        return $this;
    }

    /**
     * Get dtPonto
     *
     * @return \DateTime
     */
    public function getDtPonto()
    {
        return $this->dtPonto;
    }

    /**
     * OneToMany (owning side)
     * Add PontoImportacaoPontoHorario
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ImportacaoPontoHorario $fkPontoImportacaoPontoHorario
     * @return ImportacaoPonto
     */
    public function addFkPontoImportacaoPontoHorarios(\Urbem\CoreBundle\Entity\Ponto\ImportacaoPontoHorario $fkPontoImportacaoPontoHorario)
    {
        if (false === $this->fkPontoImportacaoPontoHorarios->contains($fkPontoImportacaoPontoHorario)) {
            $fkPontoImportacaoPontoHorario->setFkPontoImportacaoPonto($this);
            $this->fkPontoImportacaoPontoHorarios->add($fkPontoImportacaoPontoHorario);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PontoImportacaoPontoHorario
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\ImportacaoPontoHorario $fkPontoImportacaoPontoHorario
     */
    public function removeFkPontoImportacaoPontoHorarios(\Urbem\CoreBundle\Entity\Ponto\ImportacaoPontoHorario $fkPontoImportacaoPontoHorario)
    {
        $this->fkPontoImportacaoPontoHorarios->removeElement($fkPontoImportacaoPontoHorario);
    }

    /**
     * OneToMany (owning side)
     * Get fkPontoImportacaoPontoHorarios
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Ponto\ImportacaoPontoHorario
     */
    public function getFkPontoImportacaoPontoHorarios()
    {
        return $this->fkPontoImportacaoPontoHorarios;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPessoalContrato
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato
     * @return ImportacaoPonto
     */
    public function setFkPessoalContrato(\Urbem\CoreBundle\Entity\Pessoal\Contrato $fkPessoalContrato)
    {
        $this->codContrato = $fkPessoalContrato->getCodContrato();
        $this->fkPessoalContrato = $fkPessoalContrato;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPessoalContrato
     *
     * @return \Urbem\CoreBundle\Entity\Pessoal\Contrato
     */
    public function getFkPessoalContrato()
    {
        return $this->fkPessoalContrato;
    }

    /**
     * ManyToOne (inverse side)
     * Set fkPontoFormatoImportacao
     *
     * @param \Urbem\CoreBundle\Entity\Ponto\FormatoImportacao $fkPontoFormatoImportacao
     * @return ImportacaoPonto
     */
    public function setFkPontoFormatoImportacao(\Urbem\CoreBundle\Entity\Ponto\FormatoImportacao $fkPontoFormatoImportacao)
    {
        $this->codFormato = $fkPontoFormatoImportacao->getCodFormato();
        $this->fkPontoFormatoImportacao = $fkPontoFormatoImportacao;
        
        return $this;
    }

    /**
     * ManyToOne (inverse side)
     * Get fkPontoFormatoImportacao
     *
     * @return \Urbem\CoreBundle\Entity\Ponto\FormatoImportacao
     */
    public function getFkPontoFormatoImportacao()
    {
        return $this->fkPontoFormatoImportacao;
    }

    /**
     * PrePersist
     * @param \Doctrine\Common\Persistence\Event\LifecycleEventArgs $args
     */
    public function generatePkSequence(\Doctrine\Common\Persistence\Event\LifecycleEventArgs $args)
    {
        $this->codPonto = (new \Doctrine\ORM\Id\SequenceGenerator('ponto.seq_importacao_ponto', 1))->generate($args->getObjectManager(), $this);
    }
}
