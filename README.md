# PHP Zenmail API Client

[Zenmail](https://zenmail.com.br) é a ferramenta de [envio de email marketing](https://zenmail.com.br/recursos/) criada pela [Templateria](https://templateria.com/). Esta biblioteca PHP é um cliente de sua API que permite a automação de qualquer recurso disponível no [painel web](https://app.zenmail.marketing).

O próprio painel do Zenmail consome sua API - essa é a nossa maneira de garantir uma API completa e fácil de usar.

## Instalação

Usando [Composer](https://getcomposer.org):

```bash
composer require templateria/zenmail-php
```

## Autenticação

Solicite um token de acesso ao suporte enviando um email para [suporte@zenmail.com.br](mailto:suporte@zenmail.com.br).

## Introdução

Todas as requisições à API passam por uma instância de `Zenmail\Client`:

```php
$zenmail = new Zenmail\Client([
    'token'      => 'seu token aqui'
    'account_id' => 9999
])
```

Através de interfaces fluentes, você acessa todos os recursos disponíveis na API:

```php
$contact = $zenmail->contacts->get('pedro@templateria.com'); // obtém um contato pelo email
$contact = $zenmail->contacts->get(58978456);                // ou então diretamente pelo ID
```

## Roadmap

Esta biblioteca encontra-se em estágio inicial de desenvolvimento. Estão disponíveis as seguintes operações:

Contatos
[x] criar contatos
[x] listar contatos
[x] buscar contatos
[x] remover contatos
[x] atualizar contatos

Listas
[x] [criar uma lista](#lists-create)
[x] [adicionar um contato a uma lista](#lists-append)
[x] [buscar listas](#lists-list)
[x] [retornar uma lista](#lists-get)
[x] [remover uma lista](#lists-delete)
[x] [atualizar/editar uma lista](#lists-update)


## Gerenciamento de Contatos

### Criar um Contato

```php
$zenmail->contacts->create([
    'email'   => 'pedro@templateria.com',
    'details' => ['nome' => 'Pedro']
]);
```

### Obter um Contato

```php
$contact = $zenmail->contacts->get('pedro@templateria.com'); // obtém um contato pelo email
$contact = $zenmail->contacts->get(58978456);                // ou então diretamente pelo ID
```

### Listar Contatos (com busca por email)

```php
// retorna todos os contatos do domínio templateria.com
$zenmail->contacts->find(['email' => '@templateria.com']);
```

### Atualizar um Contato

```php
$zenmail->contacts->update($contact->id, [
    'details' => [
        'nome'      => 'Pedro',
        'sobrenome' => 'Padron',
        'empresa'   => 'Templateria'
    ]
]);
```

### Remover um Contato

```php
$zenmail->contacts->delete($contact->id);
```

## Listas

### Criar uma Lista <a name="lists-create"></a>

```php
$zenmail->contactLists->create(['name' => 'Assinantes da Newsletter']);
```

### Adicionar um Contato a uma Lista <a name="lists-append"></a>

Se o contato ainda não existe na conta, ele será criado automaticamente. Se o contato já existe em alguma outra lista, ele apenas será adicionado a mais uma lista.

```php
$zenmail->contactLists->append($listId, ['email' => 'pedro@templateria.com']);
```

### Buscar uma Lista por Nome <a name="lists-find"></a>

```php
$lists = $zenmail->contactLists->find(['name' => 'Assinantes da Newsletter']);
```

### Retornar uma Lista <a name="lists-get"></a>

```php
$lists = $zenmail->contacts->get(['name' => 'Assinantes da Newsletter']);
```

### Atualizar/Editar uma Lista <a name="lists-update"></a>

```php
$listId = 9999;
$zenmail->contactLists->update($listId, ['name' => 'Assinantes da Newsletter pelo Site']);
```

### Remover uma Lista <a name="lists-delete"></a>

```php
$listId = 9999;
$lists  = $zenmail->contactLists->delete($listId);
```

## Campanhas

### Obter uma Campanha

```php
$zenmail->campaigns->get(12345);
```

### Listar Campanhas

```php
foreach ($zenmail->campaigns->all() as $campaign) {
    echo 'Campanha #' . $campaign->id . ': ' . $campaign->subject;
}
```

```php
$page = 1;

do {
    $campaigns = $zenmail->campaigns->find(['page' => $page]);
    $lastPage  = $campaigns->getPaginationData()->last_page;
    foreach ($campaigns as $campaign) {
        echo 'Campanha #' . $campaign->id . ': ' . $campaign->subject . "\n";
    }
    $page++;
} while ($page <= $lastPage);
```

### Criar uma Campanha

```php
$campaign = $zenmail->campaigns->create([
    'recipients' => 'lists',
    'list_ids'   => [329104],
    'subject'    => 'Novidades do Zenmail',
    'from_name'  => 'Zenmail',
    'from_email' => 'suporte@zenmail.com.br',
    'html'       => $html,
]);
```

### Enviando uma Campanha

```php
$zenmail->campaigns->send($campaign->id);
```

### Editando uma Campanha

```php
$campaign = $zenmail->campaigns->update([
    'recipients' => 'all'
]);
```

### Remover uma Campanha

```php
$zenmail->campaigns->delete($campaign->id);
```

## Suporte

Acesse nossa [documentação](https://zenmail.com.br/ajuda) para saber mais sobre o *Zenmail* e envie um email para [suporte@zenmail.com.br](mailto:suporte@zenmail.com.br) caso tenha alguma dúvida.

## Segurança

Para questões de segurança como vulnerabilidades encontradas ou outros assuntos, envie um email para [suporte@zenmail.com.br](mailto:suporte@zenmail.com.br).

## Changelog

Detalhes sobre cada versão desta biblioteca estão disponíveis no arquivo [CHANGELOG.md](CHANGELOG.md).

## Licença

MIT License. Copyright 2019 Templateria Ltda. Por favor, veja o [Arquivo de Licença](LICENSE.md) para mais informações.