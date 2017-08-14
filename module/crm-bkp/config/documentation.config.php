<?php
return array(
    'crm\\V1\\Rest\\Contatos\\Controller' => array(
        'collection' => [
            'POST' => [
                'request' => '{
   "nome": "Nome do contato.",
   "idade": "Idade do contato, pode ser nulo.",
   "origemTipo": "Tipo da origem : sites, fornecedores, outras.",
   "origem": "ID da origem.(valor fixo de acordo com o fornecedor)",
   "Observação": "Observação a respeito do contato.",
   "situacao": "Situação do contato, valor padrão  1.",
   "idUsuarioCad": "Identificador do usuário que está efetuado o cadastro.",
   "idOperadora": "Identificador da operada. Pode ser nulo."
}',
                'response' => '{"interacao":{"id":11946,"descricao":"Contato cadastrado no sistema.","data_criacao":{"date":"2016-02-03 14:44:20.000000","timezone_type":3,"timezone":"Etc\\/GMT+3"},"data_edicao":null,"is_status":1,"contato":{"servico":null},"usuario":{"__initializer__":{},"__cloner__":{},"__isInitialized__":false,"id":"2"},"corretor":null,"situacoes_interacoes":{"__initializer__":{},"__cloner__":{},"__isInitialized__":false,"id":1},"interacoes_origem":{"__initializer__":null,"__cloner__":null,"__isInitialized__":true,"id":3,"origem":"sites","dataCriacao":{"date":"2015-12-03 11:57:40.000000","timezone_type":3,"timezone":"Etc\\/GMT+3"},"dataEdicao":null,"status":true,"fornecedor":null,"outrasOrigensInteracoes":null,"sites":{"__initializer__":{},"__cloner__":{},"__isInitialized__":false}},"produto":null,"interacao_pai":null,"tipo_envio":null,"is_email_enviado":1,"observacao_envio":null,"tipo_ligacao":null,"plantao":null},"contato":{"interesse":null,"id":10922,"nome":"YRdyr","idade":32,"observacao":"teste","data_criacao":{"date":"2016-02-03 14:44:20.000000","timezone_type":3,"timezone":"Etc\\/GMT+3"},"data_edicao":null,"is_status":1,"empresa":null,"operadora":{"__initializer__":{},"__cloner__":{},"__isInitialized__":false},"is_numero_pessoas_empresas":0,"servico":null,"status":1,"numero_pessoas_empresas":0},"_links":{"self":{"href":"http:\\/\\/localhost:666\\/contatos"}}}',
            ],
        ],
    ),
);
