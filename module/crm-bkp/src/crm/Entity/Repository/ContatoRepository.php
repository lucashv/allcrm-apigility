<?php

namespace crm\Entity\Repository;
use crm\V1\Rest\DateTime\DateTime;
use crm\V1\Rest\Filter\TelefoneFilter;

/**
 * ContatoRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ContatoRepository extends \Doctrine\ORM\EntityRepository
{
    protected $hoje;
    protected $hojeSemHora;
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $con;

    public function getContatosEnvio()
    {
        $query = $this->getEm()->createQuery(
            "SELECT DISTINCT
                                contato.id as contatoId,
                                contato.nome,
                                contato.idade,
                                contato.observacao,
                                contato.empresa,
                                contato.numeroPessoasEmpresas,
                                contato.interesse,
                                contato.enviarPara,
                                situacao.descricao as situcaoContato,
                                situacao.id as idSituacao,
                                CONCAT( usuario.nome,' ',usuario.sobreNome) as usuarioCadastro,
                                usuario.id as idUsuarioCadastro,
                                origem.origem,
                                emailsContato.email,
                                interacoesContato.id as idInteracaoContatoId,
                                telefonesContato.telefone,
                                sites.site,
                                fornecedores.razaoSocial razaoSocialFornecedor,
                                outrasOrigens.outraOrigem tipoOutraOrigem,
                                origem.id as idOrigem,
                                filiais.razaoSocial as filialContato,
                                filiais.id as idFilial,
                                operadoras.nomeFantasia as operadora,
                                IDENTITY(interacoesContato.interacaoPai) as idInteracaoPai
                            FROM
                                crm\Entity\InteracoesContato interacoesContato
                                JOIN interacoesContato.usuario as usuario
                                JOIN interacoesContato.contato as contato
                                JOIN interacoesContato.situacoesInteracoes as situacao
                                JOIN interacoesContato.interacoesOrigem as origem
                                LEFT JOIN crm\Entity\EmailsContato emailsContato WITH emailsContato.contato = contato.id
                                JOIN crm\Entity\TelefonesContato telefonesContato WITH telefonesContato.contato = contato.id
                                LEFT JOIN crm\Entity\Filiais filiais WITH filiais.id = usuario.filial
                                LEFT JOIN crm\Entity\Sites sites WITH sites.id = origem.sites
                                LEFT JOIN crm\Entity\Fornecedores fornecedores WITH fornecedores.id = origem.fornecedor
                                LEFT JOIN crm\Entity\OutrasOrigensInteracoes outrasOrigens WITH outrasOrigens.id = origem.outrasOrigensInteracoes
                                LEFT JOIN crm\Entity\Operadoras operadoras WITH operadoras.id = contato.operadora
                              WHERE
                                contato.status = 1
                                AND
                                  interacoesContato.situacoesInteracoes = 1
                                AND origem.id <> 115
                                group by contato.id
                                order by contato.id ASC
                                          ")->setMaxResults(10000);

        return $query->getResult();
    }

    public function getById($id)
    {
        $sql =
            "SELECT
                contato.id as contatoId,
                contato.nome,
                contato.idade,
                contato.observacao,
                contato.empresa,
                contato.numeroPessoasEmpresas,
                contato.interesse,
                contato.dataCriacao,
                situacao.descricao as situcaoContato,
                situacao.id as idSituacao,
                CONCAT( usuario.nome,' ',usuario.sobreNome) as usuarioCadastro,
                usuario.id as idUsuarioCadastro,
                origem.origem,
                emailsContato,
                interacoesContato.id as idInteracaoContatoId,
                telefonesContato,
                sites.site,
                fornecedores.razaoSocial razaoSocialFornecedor,
                outrasOrigens.outraOrigem tipoOutraOrigem,
                origem.id as idOrigem,
                operadoras.nomeFantasia as operadora
            FROM
                crm\Entity\InteracoesContato interacoesContato
                JOIN interacoesContato.usuario as usuario
                JOIN interacoesContato.contato as contato
                JOIN interacoesContato.situacoesInteracoes as situacao
                JOIN interacoesContato.interacoesOrigem as origem
                LEFT JOIN crm\Entity\EmailsContato emailsContato WITH emailsContato.contato = contato.id
                JOIN crm\Entity\TelefonesContato telefonesContato WITH telefonesContato.contato = contato.id
                LEFT JOIN crm\Entity\Sites sites WITH sites.id = origem.sites
                LEFT JOIN crm\Entity\Fornecedores fornecedores WITH fornecedores.id = origem.fornecedor
                LEFT JOIN crm\Entity\OutrasOrigensInteracoes outrasOrigens WITH outrasOrigens.id = origem.outrasOrigensInteracoes
                LEFT JOIN crm\Entity\Operadoras operadoras WITH operadoras.id = contato.operadora
              WHERE
               contato.id = :idContato
              ";

        $parameters = array(
            'idContato'  => $id
        );

        $query = $this->getEm()->createQuery($sql);
        $query->setParameters( $parameters );

        $result = $query->getResult();
        if(!empty($result)) {
            return ($result[1]);
        }
        return false;
    }

    private function getQueryRelatorioLigacoes($parametros)
    {
        $parametros = $this->getParametros($parametros);

        $sql = "SELECT";

        if($parametros['groupBy']) {
            $sql .= " COUNT(usuarioCorretor.id) as qtdPorCorretor,";
        }

        $sql .="  c.data_criacao AS dataCadastro,
                  tp.tipo,
                  tp.id as tipoPlantaoId,
                  c.id as contatoId,
                  usuarioCorretor.nome AS corretorNome,
                  usuarioCorretor.sobre_nome AS corretorSobreNome,
                  c.nome AS contatoNome,
                  tc.telefone
                FROM
                  interacoes_contato AS ic
                  JOIN contatos AS c
                    ON c.id = ic.contato_id
                  JOIN telefones_contato AS tc
                  ON tc.contato_id = c.id
                  JOIN plantoes AS p
                    ON ic.plantao_id = p.id
                  JOIN tipos_plantoes AS tp
                  ON tp.id = p.tipos_plantoes_id
                  LEFT JOIN usuarios AS usuarioCorretor
                  ON usuarioCorretor.id = ic.corretor_usuario_id
                  WHERE
                   ic.interacoes_origem_id = 115
                  AND ic.interacao_pai_id IS NOT NULL
                 ";

        if($parametros['nome']) {
            $sql .= " AND c.nome LIKE :nome";
        }

        if($parametros['tipoPlantao']) {
            $sql .= " AND  tp.id = :tipoPlantaoId ";
        }

        if($parametros['corretorId']) {
            $sql .= " AND usuarioCorretor.id = :corretorId ";
        }

        if($parametros['idContato']) {
            $sql .= " AND c.id = :idContato ";
        }


        if($parametros['telefone']) {
            $sql .= " AND tc.telefone = :telefone ";
        }


        if($parametros['dataInicio'] && $parametros['dataFim']) {
            $sql .= " AND DATE(ic.data_criacao) BETWEEN '{$parametros['dataInicio'] }' AND '{$parametros['dataFim']}' ";
        }

        if($parametros['groupBy']) {
            $sql .= ' GROUP BY usuarioCorretor.id , tp.id';
        }

        $sql.= " ORDER BY  c.data_criacao ASC";


        $stmt = $this->con->prepare($sql);


        if($parametros['nome']) {
            $stmt->bindValue('nome',$parametros['nome']);
        }

        if($parametros['tipoPlantao']){
            $stmt->bindValue('tipoPlantaoId', $parametros['tipoPlantao']);
        }

        if($parametros['telefone']) {
            $stmt->bindValue('telefone', $parametros['telefone']);
        }


        if($parametros['corretorId']) {
            $stmt->bindValue('corretorId', $parametros['corretorId']);
        }

        if($parametros['idContato']) {
            $stmt->bindValue('idContato', $parametros['idContato']);
        }

         return $stmt;

    }

    public function getRelatorioLigacoes($parametros)
    {
        $this->init();
        $stmt        = $this->getQueryRelatorioLigacoes($parametros);


       try {
             $stmt->execute();
             $dados =  $stmt->fetchAll();
             $dados =  $this->padronizaRetorno($dados);
             return $dados;


       } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
       }
    }

    private function padronizaRetorno($dados)
    {

        $retorno = array();
        foreach($dados as $resultado) {
            if($resultado['telefone']) {
                $resultado['telefone'] = TelefoneFilter::formataTelefone(false,$resultado['telefone']) ;
            }
            $retorno[] = $resultado;
        }

        return $retorno;
    }


    private function getEm()
    {
        return $this->getEntityManager();
    }

    private function getParametros($parametros)
    {
        $consulta = array();
        $consulta ['nome']         = false;
        $consulta ['groupBy']      = false;
        $consulta ['telefone']     = false;
        $consulta ['dataInicio']   = false;
        $consulta ['dataFim']      = false;
        $consulta ['tipoPlantao']  = false;
        $consulta ['corretorId']   = false;
        $consulta ['idContato']    = false;


        if(!empty($parametros->nome)) {
            $consulta ['nome'] = $parametros->nome;
        }

        if(!empty($parametros->groupBy)) {
            $consulta ['groupBy'] = true;
        }

        if(!empty($parametros->telefone)) {
            $consulta ['telefone'] = $parametros->telefone;
        }

        if(!empty($parametros->dataFim)) {
            $consulta ['dataFim'] = $parametros->dataFim;
        }

        if(!empty($parametros->dataInicio)) {
            $consulta ['dataInicio'] = $parametros->dataInicio;
        }

        if(!empty($parametros->tipoPlantao)) {
            $consulta ['tipoPlantao'] = $parametros->tipoPlantao;
        }

        if(!empty($parametros->corretorId)) {
            $consulta ['corretorId'] = $parametros->corretorId;
        }


        if(!empty($parametros->idContato)) {
            $consulta ['idContato'] = $parametros->idContato;
        }

        return $consulta;
    }

    private function init()
    {
        $this->hoje        =  DateTime::getDataAtualMySql(true);
        $this->hojeSemHora =  DateTime::getDataAtualMySql();
        $this->con = $this->getEm()->getConnection();
    }
}