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
