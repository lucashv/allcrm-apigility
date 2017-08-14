<?php

namespace crm\Entity\Repository;

use crm\V1\Rest\Filter\TelefoneFilter;
use Doctrine\DBAL\Types\VarDateTimeType;
use Doctrine\ORM\Tools\Pagination\Paginator;

class InteracoesContatoRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $con;

    protected $statusEmNegociacao = "4,6,9,15";

    private function getEm()
    {
        return $this->getEntityManager();
    }

    private function init()
    {
        $this->con = $this->getEm()->getConnection();
    }

    public function findByContato($idContato)
    {
        return  $this->getEm()->getRepository('crm\Entity\InteracoesContato')
                              ->findBy(array('status' => 1,'contato' => $idContato ));
    }
    public function relatorioGeral($params)
    {
        $this->init();
        $stmt = $this->getQueryRelatorioGeral($params);

        try {
            $stmt->execute();
            $dados =  $stmt->fetchAll();

            if($params->arrayDashGestor) {
                $dadosPorCorretor = $this->montaArrayGestor($dados);
                return $dadosPorCorretor;
            }
            if($params->dashGestorNacional) {
                $dadosGestorNacional = $this->montaArrayGestorNascional($dados);
                return $dadosGestorNacional;
            }

            $dados['grafico'] =  $this->montaArrayGraficosDashBoard($dados);
            return $this->padronizaRetorno($dados);

        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }

    }

    private function getQueryRelatorioGeral($params)
    {

        $params = $this->getParametrosRelatorioGeral($params);

        $sql = "SELECT
                      ic.id AS idInteracao,
                      ic.interacao_pai_id as idInteracaoPai,
                      DATE_FORMAT( ic.data_criacao , '%d/%m/%Y %H:%i' ) AS dataCadastroInterecao,
                      CONCAT( usuarioCorretor.nome,' ',usuarioCorretor.sobre_nome) AS usuarioCorretor,
                      IF(usuarioCorretor.envio_bloqueado, TRUE, FALSE) as envioBloqueado,
                      usuarioCorretor.filiais_id as filialCorretor,
                      usuarioCorretor.id as idCorretor,
                      filiais.razao_social as nomeFilialCorretor,
                      CONCAT( usuarioCadastro.nome,' ',usuarioCadastro.sobre_nome) AS usuarioCadastro,
                      c.id AS idContato,
                      c.nome AS nomeContato,
                      op.`nome_fantasia`,
                      IF(c.`empresa`, 'PME','PF') AS pmePf,
                      si.`descricao` AS situacao,
                      te.`tipo_envio` AS tipoEnvio,
                      sites.`site`,
                      fn.`nome_fantasia` as fornecedorNome,
                      outras_origens_interacoes.`outra_origem`,
                      tc.telefone,
                      ec.email,
                      c.status as statusContato,
                      si.id AS situacaoId
                    FROM
                      `interacoes_contato` AS ic
                      JOIN contatos AS c
                        ON c.id = ic.`contato_id`

                      LEFT JOIN `telefones_contato` AS tc
                      ON tc.`contato_id` = c.id
                      LEFT JOIN `emails_contato` AS ec
                      ON ec.`contato_id` = c.`id`
                      LEFT JOIN `operadoras` AS op
                      ON op.id = c.`operadoras_id`
                     LEFT JOIN `usuarios` AS usuarioCorretor
                        ON `usuarioCorretor`.id = ic.`corretor_usuario_id`
                      JOIN `usuarios` AS usuarioCadastro
                      ON `usuarioCadastro`.id = ic.`usuario_id`
                      LEFT JOIN filiais
                      ON usuarioCorretor.filiais_id = filiais.id
                      JOIN `situacoes_interacoes` AS si
                      ON si.id = ic.`situacao_interecoes_id`
                      LEFT JOIN `tipos_envios` AS te
                      ON te.id = ic.`tipo_envio_id`
                      JOIN `interacoes_origem` AS io
                      ON io.id = ic.`interacoes_origem_id`
                      LEFT JOIN `sites` AS sites
                      ON sites.id = io.`id`
                      LEFT JOIN `fornecedores` AS fn
                      ON fn.id = io.`id`
                      LEFT JOIN `outras_origens_interacoes`
                      ON `outras_origens_interacoes`.id = io.`id`
                      WHERE 1 = 1 AND ic.interacao_pai_id IS NULL AND  ic.`corretor_usuario_id` IS NOT NULL
                      ";


        if($params['idOrigemInteracao']) {
            $sql .= "AND ic.interacoes_origem_id = :idOrigemInteracao";
        }

        if($params['idContato']) {
            $sql .= " AND c.id = :idContato";
        }

        if($params['dataInicio'] && $params['dataFim']) {

            $sql .= " AND DATE(ic.data_criacao) BETWEEN '{$params['dataInicio'] }' AND '{$params['dataFim']}' ";
        }


        if($params['filialId'] ) {
            $sql .= " AND  usuarioCorretor.filiais_id = :filialId ";
        }

        if($params['corretorId']) {
            $sql .= " AND usuarioCorretor.id = :corretorId";
        }

        if($params['nome']) {
            $sql .= " AND c.nome LIKE :nome";
        }

        if($params['telefone']) {
            $sql .= " AND  tc.telefone = :telefone";
        }

        if($params['email']) {
            $sql .= " AND  ec.email = :email";
        }

        if($params['idOperadora']) {
            $sql .= " AND  op.id = :idOperadora";
        }

        if($params['tipoEnvio']) {
            $sql .= " AND  te.id = :tipoEnvio";
        }

        if($params['idStatus']) {

            if($params['idStatus'] == 19) { //  Todods em negociacao 'Sumarizado'
                $sql .= " AND  ic.situacao_interecoes_id IN ({$this->statusEmNegociacao}) ";
            } else {
                $sql .= " AND  ic.situacao_interecoes_id = :idStatus";
            }
        }

        if($params['pmePf'] === 'pme' && isset($params['empresa']))
        {
            $sql.= "AND c.empresa LIKE :empresa";
        }

        if($params['respondidas']) {
            $arrayNaoRespondidadas = "1,2"; // 1-cadastrada 2- enviada ao corretor.
            $sql .= " AND  ic.situacao_interecoes_id NOT IN ({$arrayNaoRespondidadas})";
        }

         $sql .= " GROUP BY c.id";

         $sql .= " ORDER BY ic.data_criacao DESC";

         $stmt = $this->con->prepare($sql);


        if($params['filialId']) {
            $stmt->bindValue('filialId',$params['filialId']);
        }

        if($params['idOrigemInteracao']) {
            $stmt->bindValue('idOrigemInteracao',$params['idOrigemInteracao']);
        }


        if($params['idContato']) {
            $stmt->bindValue('idContato',$params['idContato']);
        }

        if($params['corretorId']) {
            $stmt->bindValue('corretorId',$params['corretorId']);
        }

        if($params['nome']) {
            $stmt->bindValue('nome', '%'.$params['nome'].'%');
        }

        if($params['telefone']) {
            $stmt->bindValue('telefone', $params['telefone']);
        }

        if($params['email']) {
            $stmt->bindValue('email', $params['email']);
        }

        if($params['idOperadora']) {
            $stmt->bindValue('idOperadora', $params['idOperadora']);
        }

        if($params['tipoEnvio']) {
            $stmt->bindValue('tipoEnvio', $params['tipoEnvio']);
        }

        if($params['idStatus'] && $params['idStatus']!== '19') {
            $stmt->bindValue('idStatus', $params['idStatus']);
        }

        if($params['pmePf'] === 'pme' && isset($params['empresa'])) {
            $stmt->bindValue('empresa', '%'.$params['empresa'].'%');
        }

        return $stmt;
    }

    private function getParametrosRelatorioGeral($params)
    {

        $consulta = array();
        $consulta ['corretorId']  = false;
        $consulta ['idContato']   = false;
        $consulta ['nome']        = false;
        $consulta ['telefone']    = false;
        $consulta ['email']       = false;
        $consulta ['idOperadora'] = false;
        $consulta ['idStatus']    = false;
        $consulta ['tipoEnvio']   = false;
        $consulta ['dataInicio']  = false;
        $consulta ['dataFim']     = false;
        $consulta ['origemTipo']  = false;
        $consulta ['idOrigem']    = false;
        $consulta ['pmePf']       = false;
        $consulta ['empresa']     = false;
        $consulta ['inativos']    = false;
        $consulta ['idFilial']    = false;
        $consulta ['groupBy']     = false;
        $consulta ['dashGestorNacional'] = false;
        $consulta ['respondidas'] = false;
        $consulta ['filialId']    = false;
        $consulta ['idOrigemInteracao'] =  false;

        if(!empty($params->respondidas) && $params->respondidas !== 'false') {
            $consulta ['respondidas'] = $params->respondidas;
        }

        if(!empty($params->idFilial)) {
            $consulta ['idFilial'] = $params->idFilial;
        }

        if(!empty($params->corretorId)) {
            $consulta ['corretorId'] = $params->corretorId;
        }

        if(!empty($params->idContato)) {
            $consulta ['idContato'] = $params->idContato;
        }

        if(!empty($params->nome)) {
            $consulta ['nome'] = $params->nome;
        }

        if(!empty($params->telefone)) {
            $consulta ['telefone'] = $params->telefone;
        }

        if(!empty($params->email)) {
            $consulta ['email'] = $params->email;
        }

        if(!empty($params->idOperadora)) {
            $consulta ['idOperadora'] = $params->idOperadora;
        }

        if(!empty($params->idStatus)) {
            $consulta ['idStatus'] = $params->idStatus;
        }

        if(!empty($params->tipoEnvio)) {
            $consulta ['tipoEnvio'] = $params->tipoEnvio;
        }

        if(!empty($params->dataInicio) && !empty($params->dataFim)) {
            $consulta ['dataInicio'] = $params->dataInicio;
            $consulta ['dataFim']    = $params->dataFim;
        }

        if(!empty($params->origemTipo) && !empty($params->idOrigem)) {
            $consulta ['origemTipo'] = $params->origemTipo;
            $consulta ['idOrigem']   = $params->idOrigem;
            $idOrigem = $this->getOrigemInteraca($params->origemTipo, $params->idOrigem);
            $idOrigem = $idOrigem[0]['id'];
            $consulta ['idOrigemInteracao'] = $idOrigem;


        }

        if(!empty($params->pmePf)) {
            $consulta ['pmePf'] = $params->pmePf;
        }

        if(!empty($params->empresa)) {
            $consulta ['empresa'] = $params->empresa;
        }

        if(!empty($params->inativos)) {
            $consulta ['inativos'] = true;
        }
        if(!empty($params->groupBy)) {
            $consulta ['groupBy'] = true;
        }
        if(!empty($params->dashGestorNacional)) {
            $consulta ['dashGestorNacional'] = true;
        }
        if(!empty($params->filialId)) {
            $consulta ['filialId'] = $params->filialId;
        }


        return $consulta;
    }

    public function getRelatorioIndicacoes($params)
    {
        $this->init();

        $sql ="SELECT
                  ic.id AS idInteracao,
                  c.id as contatoId,
                  DATE_FORMAT( ic.data_criacao , '%d/%m/%Y %H:%i' ) AS dataCadastroInterecao,
                  CONCAT(
                      usuarioCorretor.nome,
                      ' ',
                      usuarioCorretor.sobre_nome
                  ) AS usuarioCorretor,
                  CONCAT(
                      usuarioCadastro.nome,
                      ' ',
                      usuarioCadastro.sobre_nome
                  ) AS usuarioCadastro,
                  c.id AS idContato,
                  c.nome AS nomeContato,
                  op.`nome_fantasia`,
                  IF(c.`empresa`, 'PME', 'PF') AS pmePf,
                  si.`descricao` AS situacao,
                  te.`tipo_envio` AS tipoEnvio,
                  sites.`site`,
                  fn.`nome_fantasia` AS fornecedorNome,
                  outras_origens_interacoes.`outra_origem`,
                  tc.telefone,
                  ec.email,
                  c.status AS statusContato,
                  si.id as situacaoId
                FROM
                  `interacoes_contato` AS ic
                  JOIN contatos AS c
                    ON c.id = ic.`contato_id`
                  LEFT JOIN `telefones_contato` AS tc
                    ON tc.`contato_id` = c.id
                  LEFT JOIN `emails_contato` AS ec
                    ON ec.`contato_id` = c.`id`
                  LEFT JOIN `operadoras` AS op
                    ON op.id = c.`operadoras_id`
                  LEFT JOIN `usuarios` AS usuarioCorretor
                    ON `usuarioCorretor`.id = ic.`corretor_usuario_id`
                  JOIN `usuarios` AS usuarioCadastro
                    ON `usuarioCadastro`.id = ic.`usuario_id`
                  JOIN `situacoes_interacoes` AS si
                    ON si.id = ic.`situacao_interecoes_id`
                  LEFT JOIN `tipos_envios` AS te
                    ON te.id = ic.`tipo_envio_id`
                  JOIN `interacoes_origem` AS io
                    ON io.id = ic.`interacoes_origem_id`
                  LEFT JOIN `sites` AS sites
                    ON sites.id = io.`id`
                  LEFT JOIN `fornecedores` AS fn
                    ON fn.id = io.`id`
                  LEFT JOIN `outras_origens_interacoes`
                    ON `outras_origens_interacoes`.id = io.`id`
                WHERE usuarioCorretor.id = :corretorId AND ic.interacao_pai_id IS NULL ";

        if($params['dataInicio'] && $params['dataFim']) {
            $sql .= " AND DATE(ic.data_criacao) BETWEEN '{$params['dataInicio'] }' AND '{$params['dataFim']}' ";
        }

        $sql.= " GROUP BY c.id";
        $sql.= "  ";


        $stmt = $this->con->prepare($sql);
        $stmt->bindValue('corretorId', $params['corretorId']);

        try {
            $stmt->execute();
            $dados =  $stmt->fetchAll();

            return $this->padronizaRetorno($dados);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }

    }

    private function padronizaRetorno($dados)
    {

        $retorno = array();
        foreach($dados as $resultado) {
            if(isset($resultado['telefone'])) {
                $resultado['telefone'] = TelefoneFilter::formataTelefone(false,$resultado['telefone']) ;
            }
            $retorno[] = $resultado;
        }

        return $retorno;
    }

    private function montaArrayGraficosDashBoard($dados)
    {
        $situacoes = array();

        foreach($dados as $dado)
        {
            if(!array_key_exists($dado['situacao'], $situacoes)){
                $situacoes[$dado['situacao']] = 0;
            }
            $situacoes[$dado['situacao']] =  $situacoes[$dado['situacao']] +1;

        }
        return $situacoes;
    }

    private function montaArrayGestor(array $indicacoes)
    {
        $corretores = array();

        foreach($indicacoes as $indicacao) {

            if(!array_key_exists($indicacao['usuarioCorretor'], $corretores)){
                $corretores[$indicacao['usuarioCorretor']] = [] ;
            }
                $corretores[$indicacao['usuarioCorretor']][]  = $indicacao ;
        }

        return $corretores;

    }

    private function getOrigemInteraca($tipo, $id)
    {
        if($tipo === 'fornecedores'){
            $campoId = 'fornecedor_id';
        }

        if($tipo === 'outras'){
            $campoId = 'outras_origens_interacoes_id';
        }

        if($tipo === 'sites'){
            $campoId = 'site_id';
        }
        $sql = "SELECT id FROM interacoes_origem WHERE origem = '{$tipo}' AND {$campoId} = $id ";

        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
