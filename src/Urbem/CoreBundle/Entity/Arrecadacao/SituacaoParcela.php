<?php
 
namespace Urbem\CoreBundle\Entity\Arrecadacao;

/**
 * SituacaoParcela
 */
class SituacaoParcela
{
    /**
     * PK
     * @var integer
     */
    private $codSituacao;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDocumento
     */
    private $fkArrecadacaoParcelaDocumentos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkArrecadacaoParcelaDocumentos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codSituacao
     *
     * @param integer $codSituacao
     * @return SituacaoParcela
     */
    public function setCodSituacao($codSituacao)
    {
        $this->codSituacao = $codSituacao;
        return $this;
    }

    /**
     * Get codSituacao
     *
     * @return integer
     */
    public function getCodSituacao()
    {
        return $this->codSituacao;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return SituacaoParcela
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Get descricao
     *
     * @return string
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * OneToMany (owning side)
     * Add ArrecadacaoParcelaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDocumento $fkArrecadacaoParcelaDocumento
     * @return SituacaoParcela
     */
    public function addFkArrecadacaoParcelaDocumentos(\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDocumento $fkArrecadacaoParcelaDocumento)
    {
        if (false === $this->fkArrecadacaoParcelaDocumentos->contains($fkArrecadacaoParcelaDocumento)) {
            $fkArrecadacaoParcelaDocumento->setFkArrecadacaoSituacaoParcela($this);
            $this->fkArrecadacaoParcelaDocumentos->add($fkArrecadacaoParcelaDocumento);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove ArrecadacaoParcelaDocumento
     *
     * @param \Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDocumento $fkArrecadacaoParcelaDocumento
     */
    public function removeFkArrecadacaoParcelaDocumentos(\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDocumento $fkArrecadacaoParcelaDocumento)
    {
        $this->fkArrecadacaoParcelaDocumentos->removeElement($fkArrecadacaoParcelaDocumento);
    }

    /**
     * OneToMany (owning side)
     * Get fkArrecadacaoParcelaDocumentos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Arrecadacao\ParcelaDocumento
     */
    public function getFkArrecadacaoParcelaDocumentos()
    {
        return $this->fkArrecadacaoParcelaDocumentos;
    }
}
