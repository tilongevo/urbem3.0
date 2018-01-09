<?php
 
namespace Urbem\CoreBundle\Entity\Pessoal;

/**
 * Conselho
 */
class Conselho
{
    /**
     * PK
     * @var integer
     */
    private $codConselho;

    /**
     * @var string
     */
    private $sigla;

    /**
     * @var string
     */
    private $descricao;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorConselho
     */
    private $fkPessoalContratoServidorConselhos;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPessoalContratoServidorConselhos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set codConselho
     *
     * @param integer $codConselho
     * @return Conselho
     */
    public function setCodConselho($codConselho)
    {
        $this->codConselho = $codConselho;
        return $this;
    }

    /**
     * Get codConselho
     *
     * @return integer
     */
    public function getCodConselho()
    {
        return $this->codConselho;
    }

    /**
     * Set sigla
     *
     * @param string $sigla
     * @return Conselho
     */
    public function setSigla($sigla)
    {
        $this->sigla = $sigla;
        return $this;
    }

    /**
     * Get sigla
     *
     * @return string
     */
    public function getSigla()
    {
        return $this->sigla;
    }

    /**
     * Set descricao
     *
     * @param string $descricao
     * @return Conselho
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
     * Add PessoalContratoServidorConselho
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorConselho $fkPessoalContratoServidorConselho
     * @return Conselho
     */
    public function addFkPessoalContratoServidorConselhos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorConselho $fkPessoalContratoServidorConselho)
    {
        if (false === $this->fkPessoalContratoServidorConselhos->contains($fkPessoalContratoServidorConselho)) {
            $fkPessoalContratoServidorConselho->setFkPessoalConselho($this);
            $this->fkPessoalContratoServidorConselhos->add($fkPessoalContratoServidorConselho);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PessoalContratoServidorConselho
     *
     * @param \Urbem\CoreBundle\Entity\Pessoal\ContratoServidorConselho $fkPessoalContratoServidorConselho
     */
    public function removeFkPessoalContratoServidorConselhos(\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorConselho $fkPessoalContratoServidorConselho)
    {
        $this->fkPessoalContratoServidorConselhos->removeElement($fkPessoalContratoServidorConselho);
    }

    /**
     * OneToMany (owning side)
     * Get fkPessoalContratoServidorConselhos
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Pessoal\ContratoServidorConselho
     */
    public function getFkPessoalContratoServidorConselhos()
    {
        return $this->fkPessoalContratoServidorConselhos;
    }

    /**
     * @return string
     */
    public function __toString() {
        return (string) $this->getSigla();
    }
}
