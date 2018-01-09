<?php
 
namespace Urbem\CoreBundle\Entity\Patrimonio;

/**
 * ArquivoColetora
 */
class ArquivoColetora
{
    /**
     * PK
     * @var integer
     */
    private $codigo;

    /**
     * @var string
     */
    private $nome;

    /**
     * @var string
     */
    private $md5sum;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * OneToMany
     * @var \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraDados
     */
    private $fkPatrimonioArquivoColetoraDados;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fkPatrimonioArquivoColetoraDados = new \Doctrine\Common\Collections\ArrayCollection();
        $this->timestamp = new \DateTime;
    }

    /**
     * Set codigo
     *
     * @param integer $codigo
     * @return ArquivoColetora
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
        return $this;
    }

    /**
     * Get codigo
     *
     * @return integer
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set nome
     *
     * @param string $nome
     * @return ArquivoColetora
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set md5sum
     *
     * @param string $md5sum
     * @return ArquivoColetora
     */
    public function setMd5sum($md5sum)
    {
        $this->md5sum = $md5sum;
        return $this;
    }

    /**
     * Get md5sum
     *
     * @return string
     */
    public function getMd5sum()
    {
        return $this->md5sum;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return ArquivoColetora
     */
    public function setTimestamp(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * OneToMany (owning side)
     * Add PatrimonioArquivoColetoraDados
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraDados $fkPatrimonioArquivoColetoraDados
     * @return ArquivoColetora
     */
    public function addFkPatrimonioArquivoColetoraDados(\Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraDados $fkPatrimonioArquivoColetoraDados)
    {
        if (false === $this->fkPatrimonioArquivoColetoraDados->contains($fkPatrimonioArquivoColetoraDados)) {
            $fkPatrimonioArquivoColetoraDados->setFkPatrimonioArquivoColetora($this);
            $this->fkPatrimonioArquivoColetoraDados->add($fkPatrimonioArquivoColetoraDados);
        }
        
        return $this;
    }

    /**
     * OneToMany (owning side)
     * Remove PatrimonioArquivoColetoraDados
     *
     * @param \Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraDados $fkPatrimonioArquivoColetoraDados
     */
    public function removeFkPatrimonioArquivoColetoraDados(\Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraDados $fkPatrimonioArquivoColetoraDados)
    {
        $this->fkPatrimonioArquivoColetoraDados->removeElement($fkPatrimonioArquivoColetoraDados);
    }

    /**
     * OneToMany (owning side)
     * Get fkPatrimonioArquivoColetoraDados
     *
     * @return \Doctrine\Common\Collections\Collection|\Urbem\CoreBundle\Entity\Patrimonio\ArquivoColetoraDados
     */
    public function getFkPatrimonioArquivoColetoraDados()
    {
        return $this->fkPatrimonioArquivoColetoraDados;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Importar arquivo coletora';
    }
}
