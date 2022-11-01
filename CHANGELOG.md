## Versão 1

Aqui tínhamos uma versão muito simples, um escopo inicial da ideia. A classe Container implementava os métodos `get` e `has`, obedecendo à interface. Havia também um pseudo "auto-wiring", onde o Container era capaz de identificar a classe, instanciar ela, e injetar em outras. Porém, a versão não suportava o uso de `Interfaces`, já que fica abstrato demais e o Container não saberia qual a classe correspondente necessária para injetar em outra.

Aqui uma ideia de como foi "resolvido" esse problema da `Interface`:

```
use Jrs\DI\Container;
use Jrs\Tests\Controller\TestController;
use Jrs\Tests\Service\SecondTestService;
use Jrs\Tests\Service\ServiceInterface;
use Jrs\Tests\Service\TestService;

...

$container = new Container();
$container->get(TestController::class, [ServiceInterface::class => ['class' => TestService::class]])->index();
$container->get(TestController::class, [ServiceInterface::class => ['class' => SecondTestService::class]])->index();

```

Neste exemplo, o `TestController` possuia um argumento `service` que era uma implementação da `ServiceInterface`. Por sua vez, as classes `TestService` e `SecondTestService`, implementavam essa interface. Para conseguir passar o service correto para o controller em cada chama, recorri ao uso de um array, onde a chave é o nome da interface que o controller esperava, e dentro havia um segundo array (ou quantos mais fossem necessários, seguindo a mesma ideia), com duas keys esperadas, `class` e `arguments`. Como é de se esperar, a chave `class` servia para dizer qual a classe que seria implementada quando a interface fosse encontrada, e a chave `arguments` seria necessário caso essa classe a ser injetada, também possuísse uma injeção de dependência por interfaces no seu construtor.

~~Basicamento era um `DE => PARA` se preferir desta forma.~~

Porém convenhamos que não era uma abordagem muito prática. Mesmo funcionando o auto wiring para classes explicitamente tipadas, o uso de interfaces torna um pouco mais complexa a implementação. Não sou à favor de ter um arquivo para `setar` todas as injeções de dependências da aplicação, porque pensando em uma abordagem de uma aplicação de médio à grande porte, esse arquivo seria gigantesco. Mesmo "quebrando" esse arquivo em menores e unindo tudo, acredito que não é uma abordagem prática e correta da situação.

---

## Alterações

#### 2022-10-24

<br>

Apagada a pasta de testes que eu tinha para testar a versão 1 deste DI, e instalada a dependência do `php unit`. Todavia, tive problemas com compatibilidade para conseguir instalar esse pacote, precisando rodas o comando:

> composer require --dev phpunit/phpunit ^9 --ignore-platform-reqs

<br>

Criado também o arquivo `phpunit.xml` na raíz do projeto.

Além disso, a minha extensão de PHPUnit me deixou na mão, então troquei para a `Better PHPUnit`, e com ela consegui rodar os testes.

<br>

---

## Alterações

#### 2022-10-30

Criada nova classe Container, a anterior eu renomeei para Container_old.

Tive que fazer alguns ajustes no PHPUnit, porque eu queria o Coverage funcionando corretamente. Como eu estou utilizando a extensão `Better PHPUnit`, precisei adicionar uma configuração para gerar corretamente:

> "better-phpunit.commandSuffix": "--coverage-html ./tests/coverage"

Desta forma ao executar os testes esse complemento é adicionado à instrução e os coverage gera na pasta indicada. Também adicionei essa pasta no `.gitignore` porque não preciso desses dados no meu GitHub.

<br>

Também precisei habilitar no `php.ini`, a configuração:

> xdebug.mode=debug,coverage

Para que assim consiga gerar o coverage.

---

## Alterações

#### 2022-10-31

Criada nova configuração no arquivo do `phpunit.xml`, agora não preciso mais da configuração de comando adicional que acrescentei anteriormente na extensão.

---

Test List

-   [ ] Teste simples do método `get`, retornando uma instância. Esse teste deverá utilizar auto wiring, ou seja, ele DEVE ser capaz de resolver situações simples, onde a classe esta determinada como Injeção de Dependência em outra.
-   [ ] Teste do método `get` tentando instanciar uma classe com o construtor privativo, uma técnica utilizada as vezes na criação de classes singleton. Esse teste deverá esperar uma exceção.
-   [ ] Teste do método `get` tentando instanciar uma classe com o construtor sem parâmetros. O retorno deve ser a classe sem erros.
-   [ ] Teste do método `has`. Este método irá trabalhar da seguinte forma:
    1. Ele verificará se determinada classe está préviamente mapeada entre as que precisam de tratamento especial para resolução. Portanto precisará que o programador defina como determinada classe deverá ser resolvida. Essa situação será util quando a Injeção de Dependência é uma Interface.
    2. Se NÃO houver mapeamento, esse método deverá retornar um erro.
-   [ ] Teste do método `has` onde não houve o mapeamento, esperando um Exception como resposta. Situação já descrita anteriormente.
-   [ ] Teste do método `singleton` que deverá retornar uma classe de instância única. Esse teste deverá executar o comando, alterar algum valor do objeto, e chamar o método novamente. O objeto retornado na segunda chamada deverá conter a alteração anterior, já que é um Singleton.
